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
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('type_id');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('coordinates');
            $table->decimal('price', 10, 2);
            $table->decimal('damage_deposit', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('size', 8, 2);
            $table->date('available_at');
            $table->boolean('is_occupied')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

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
