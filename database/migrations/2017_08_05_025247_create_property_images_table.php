<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_images', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id');

            $table->string('filename');
            $table->string('filepath');
            $table->string('mime_type');
            $table->timestamps();

            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_images');
    }
}
