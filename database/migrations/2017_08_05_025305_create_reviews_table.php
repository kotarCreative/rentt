<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reviewer_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('property_id')->nullable();

            $table->text('message');
            $table->enum('status', [ 'walk-through', 'lived-there' ])->nullable();
            $table->boolean('is_reported')
                  ->default(false);
            $table->timestamps();

            $table->foreign('reviewer_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('user_id')
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
        Schema::dropIfExists('reviews');
    }
}
