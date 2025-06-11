<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Enums\PlatformName; // Assuming this is app/Enums/PlatformName.php

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Using DB facade for direct manipulation for safety during refactor
        // Ensure this migration runs AFTER the one that adds 'metadata' and 'platform' columns
        // and renames the table.
        $connections = DB::table('social_connections')
                         ->where('platform', PlatformName::FACEBOOK)
                         ->get();

        foreach ($connections as $connection) {
            $metadata = [];
            // Check if these properties exist on the stdClass object from DB::table()
            if (property_exists($connection, 'page_id') && !empty($connection->page_id)) {
                $metadata['page_id'] = $connection->page_id;
            }
            if (property_exists($connection, 'page_name') && !empty($connection->page_name)) {
                $metadata['page_name'] = $connection->page_name;
            }
            if (property_exists($connection, 'group_id') && !empty($connection->group_id)) {
                $metadata['group_id'] = $connection->group_id;
            }
            if (property_exists($connection, 'group_name') && !empty($connection->group_name)) {
                $metadata['group_name'] = $connection->group_name;
            }

            if (!empty($metadata)) {
                DB::table('social_connections')
                    ->where('id', $connection->id)
                    ->update(['metadata' => json_encode($metadata)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Revert metadata back to individual columns (best effort)
        // This assumes the old columns (page_id, etc.) still exist or have been re-added by a preceding down migration
        $connections = DB::table('social_connections')
                         ->where('platform', PlatformName::FACEBOOK)
                         ->whereNotNull('metadata')
                         ->get();

        foreach ($connections as $connection) {
            $metadata = json_decode($connection->metadata, true);
            $updateData = []; // Data to update individual columns

            // Prepare data for old columns if they exist in metadata
            if (isset($metadata['page_id'])) {
                $updateData['page_id'] = $metadata['page_id'];
            }
            if (isset($metadata['page_name'])) {
                $updateData['page_name'] = $metadata['page_name'];
            }
            if (isset($metadata['group_id'])) {
                $updateData['group_id'] = $metadata['group_id'];
            }
            if (isset($metadata['group_name'])) {
                $updateData['group_name'] = $metadata['group_name'];
            }

            // Important: Nullify metadata only if we are sure all relevant data is moved back.
            // For this example, we'll just update the columns and leave metadata as is,
            // or it could be selectively cleared. For a full revert, you might set metadata to null.
            // $updateDataWithNullMeta = $updateData;
            // $updateDataWithNullMeta['metadata'] = null;


            if (!empty($updateData)) {
                 DB::table('social_connections')
                     ->where('id', $connection->id)
                     ->update($updateData); // Use $updateData or $updateDataWithNullMeta
            }
        }
    }
};
