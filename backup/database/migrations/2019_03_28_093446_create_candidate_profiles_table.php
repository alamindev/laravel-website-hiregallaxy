<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_of_birth')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('career_level_id')->nullable();
            $table->unsignedInteger('sector')->nullable();
            $table->unsignedInteger('experience_id')->nullable();
            $table->string('cv')->nullable()->comment('Job Seeker CV file');

            $table->foreign('career_level_id')->references('id')->on('career_levels');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('experience_id')->references('id')->on('experiences');
            $table->foreign('sector')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_profiles');
    }
}
