<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('type_id')->nullable();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('postal')->nullable();
            $table->string('coordinates')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('damage_deposit', 10, 2)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('size', 8, 2)->nullable();
            $table->date('available_at')->nullable();
            $table->boolean('is_occupied')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('type_id')
                  ->references('id')
                  ->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
