<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmmenityPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ammenity_property', function(Blueprint $table) {
            $table->unsignedInteger('ammenity_id');
            $table->unsignedInteger('property_id');

            $table->foreign('ammenity_id')
                  ->references('id')
                  ->on('ammenities');

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
        Schema::dropIfExists('ammenity_property');
    }
}
