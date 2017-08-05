<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_user', function(Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('language_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('language_id')
                  ->references('id')
                  ->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_user');
    }
}
