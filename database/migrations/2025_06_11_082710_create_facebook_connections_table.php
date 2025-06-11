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
    public function up()
    {
        Schema::create('facebook_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assumes users table exists
            $table->string('facebook_user_id')->index();
            $table->string('page_id')->nullable()->index();
            $table->string('page_name')->nullable();
            $table->string('group_id')->nullable()->index();
            $table->string('group_name')->nullable();
            $table->text('access_token'); // Will be encrypted via model cast
            $table->text('scopes')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_connections');
    }
};
