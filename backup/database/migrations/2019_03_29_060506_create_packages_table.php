<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('business_type_name');
            $table->boolean('is_most_sold')->default(0)->comment('It will be as a featured package');
            $table->float('cost_per_month');
            $table->unsignedInteger('cost_currency');
            $table->unsignedInteger('job_posting_limit')->default(0);
            $table->unsignedInteger('featured_job_limit')->default(0);
            $table->unsignedInteger('renew_job_limit')->default(0);
            $table->unsignedInteger('category_job_limit')->default(0);
            $table->unsignedInteger('days_duration')->default(0);
            $table->timestamps();


            $table->foreign('cost_currency')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
