<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('certificate_degree_name');
            $table->string('major_subject')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('institute_university_name');
            $table->unsignedTinyInteger('percentage')->nullable();
            $table->float('get_cgpa')->nullable();
            $table->float('on_cgpa')->nullable()->comment('The CGPA count in what ? or (out of ?)');
            $table->boolean('is_current_qualification')->default(0);

            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_qualifications');
    }
}
