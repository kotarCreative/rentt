<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
          $table->date('birthday')
            ->after('description')
            ->nullable();
          $table->enum('gender', [ 'Male', 'Female', 'Other' ])
            ->after('birthday')
            ->nullable();
          $table->enum('employment', [ 'Employed', 'Unemployed', 'Student' ])
            ->after('linked_in_url')
            ->nullable();
          $table->boolean('is_searching_for_roommate')
            ->after('is_a_smoker')
            ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
          $table->dropColumn([ 'employment', 'is_searching_for_roommate', 'gender', 'birthday' ]);
        });
    }
}
