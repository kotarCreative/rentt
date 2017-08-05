<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyUtilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_utility', function(Blueprint $table) {
            $table->unsignedInteger('property_id');
            $table->unsignedInteger('utility_id');

            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties');

            $table->foreign('utility_id')
                  ->references('id')
                  ->on('utilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_utility');
    }
}
