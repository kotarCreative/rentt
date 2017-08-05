<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_history', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('landlord_id')
                  ->nullable();
            $table->unsignedInteger('property_id')
                  ->nullable();
            $table->unsignedInteger('city_id');

            $table->string('landlord_first_name');
            $table->string('landlord_last_name');
            $table->string('landlord_email');
            $table->date('started_at');
            $table->date('ended_at')
                  ->nullable();
            $table->boolean('is_verified')
                  ->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('landlord_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties');

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_history');
    }
}
