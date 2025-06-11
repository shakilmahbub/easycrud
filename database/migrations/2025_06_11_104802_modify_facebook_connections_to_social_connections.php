<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade for raw updates
use App\Enums\PlatformName; // Import the class-based Enum

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::rename('facebook_connections', 'social_connections');

        Schema::table('social_connections', function (Blueprint $table) {
            // Add platform column
            // For a class-based enum, a string type is appropriate.
            // If you were using a backed enum with DB enum type: $table->enum('platform', array_column(PlatformName::cases(), 'value'))->after('user_id');
            $table->string('platform')->after('user_id')->nullable(); // Nullable temporarily for existing data before update

            // Rename facebook_user_id to platform_user_id
            $table->renameColumn('facebook_user_id', 'platform_user_id');

            // Add metadata column
            $table->json('metadata')->nullable()->after('token_expires_at');

            // Note: Dropping old Facebook-specific columns (page_id, page_name, group_id, group_name)
            // is deferred. This should happen after a separate data migration step
            // to move existing data from these columns into the 'metadata' JSON field.
            // Example: $table->dropColumn(['page_id', 'page_name', 'group_id', 'group_name']);
        });

        // Update existing records (which are all Facebook records at this point) to set the platform.
        DB::table('social_connections')->whereNull('platform')->update(['platform' => PlatformName::FACEBOOK]);

        // Make platform non-nullable after update if desired
        Schema::table('social_connections', function (Blueprint $table) {
            $table->string('platform')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Before renaming columns or table, make platform nullable again if it was changed
        Schema::table('social_connections', function (Blueprint $table) {
            $table->string('platform')->nullable()->change();
        });

        Schema::table('social_connections', function (Blueprint $table) {
            // If old columns were dropped in 'up', add them back here.
            // $table->string('page_id')->nullable();
            // $table->string('page_name')->nullable();
            // $table->string('group_id')->nullable();
            // $table->string('group_name')->nullable();

            $table->dropColumn('metadata');
            $table->renameColumn('platform_user_id', 'facebook_user_id');
            $table->dropColumn('platform');
        });

        Schema::rename('social_connections', 'facebook_connections');
    }
};
