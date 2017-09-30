<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenityPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenity_property', function(Blueprint $table) {
            $table->unsignedInteger('amenity_id');
            $table->unsignedInteger('property_id');

            $table->foreign('amenity_id')
                  ->references('id')
                  ->on('amenities');

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
        Schema::dropIfExists('amenity_property');
    }
}
