<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertStudentStatusToBoolean extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
          $table->dropColumn('employment');
          $table->boolean('is_a_student')
            ->after('is_searching_for_roommate')
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
          $table->dropColumn('is_a_student');
          $table->enum('employment', [ 'Employed', 'Unemployed', 'Student' ])
            ->after('linked_in_url')
            ->nullable();
        });
    }
}
