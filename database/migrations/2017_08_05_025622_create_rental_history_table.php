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

            $table->string('location');
            $table->string('landlord_first_name');
            $table->string('landlord_last_name');
            $table->string('landlord_email');
            $table->date('started_on');
            $table->date('ended_on')
                  ->nullable();
            $table->string('email_token');
            $table->boolean('verified')
                  ->default(false);
            $table->dateTime('denied_at')->nullable();
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
