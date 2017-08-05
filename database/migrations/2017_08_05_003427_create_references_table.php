<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->enum('relationship', [ 'family', 'friend', 'co-worker', 'employer' ]);
            $table->boolean('is_approved')
                  ->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
