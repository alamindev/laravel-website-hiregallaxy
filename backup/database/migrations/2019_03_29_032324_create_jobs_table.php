<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('email');
            $table->text('description');
            $table->unsignedInteger('user_id')->comment('The Company Profile ID');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('experience_id');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('template_id');
            $table->unsignedInteger('apply_type_id');
            $table->unsignedInteger('country_id')->nullable();
            $table->string('location')->nullable();
            $table->string('gender')->default('Male')->comment('Male,Female,Both,Other');
            $table->float('monthly_salary')->default(0);
            $table->unsignedInteger('salary_currency')->nullable();
            $table->boolean('is_salary_negotiable')->default(false);
            $table->dateTime('deadline');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_confirmed')->default(false);

            $table->text('job_summery')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('qualification')->nullable();
            $table->text('certification')->nullable();
            $table->text('experience')->nullable();
            $table->text('about_company')->nullable();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('type_id')->references('id')->on('job_types');
            $table->foreign('experience_id')->references('id')->on('experiences');
            $table->foreign('status_id')->references('id')->on('job_statuses');
            $table->foreign('apply_type_id')->references('id')->on('job_apply_types');
            $table->foreign('salary_currency')->references('id')->on('currencies');
            $table->foreign('location_id')->references('id')->on('countries');
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
        Schema::dropIfExists('jobs');
    }
}
