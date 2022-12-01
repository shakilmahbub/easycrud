<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBiography09sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biography09s', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 255)->nullable();
            $table->string('age')->nullable();
            $table->string('biography')->nullable();
            $table->string('sport')->nullable();
            $table->string('gender')->nullable();
            $table->string('colors')->nullable();
            $table->boolean('is_retired')->nullable();
            $table->string('photo')->nullable();
            $table->string('range')->nullable();
            $table->string('month')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('biography09s');
    }
}
