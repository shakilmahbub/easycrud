<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Ensure this migration runs AFTER the data migration that moves data to 'metadata'
        Schema::table('social_connections', function (Blueprint $table) {
            $table->dropColumn(['page_id', 'page_name', 'group_id', 'group_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('social_connections', function (Blueprint $table) {
            // Re-add columns in a specific order if desired, e.g., after 'platform_user_id' or 'metadata'
            // For simplicity, adding them without specific order relative to all columns.
            // Defaulting to adding at the end or letting DB decide if not specified.
            // To place them accurately, you might need to know the column after which they should appear.
            // Example: $table->string('group_name')->nullable()->after('metadata');
            // For this example, we add them back as nullable strings.

            $table->string('page_id')->nullable()->after('platform_user_id'); // Example placement
            $table->string('page_name')->nullable()->after('page_id');
            $table->string('group_id')->nullable()->after('page_name');
            $table->string('group_name')->nullable()->after('group_id');
        });
    }
};
