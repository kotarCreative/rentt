<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_property', function(Blueprint $table) {
            $table->unsignedInteger('detail_id');
            $table->unsignedInteger('property_id');
            $table->string('details');

            $table->foreign('detail_id')
                  ->references('id')
                  ->on('details');

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
        Schema::dropIfExists('detail_property');
    }
}
