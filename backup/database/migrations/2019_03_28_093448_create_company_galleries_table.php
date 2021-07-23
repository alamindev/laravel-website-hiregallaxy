<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_profile_id');
            $table->string('title');
            $table->string('image');
            $table->string('description')->nullable();

            $table->foreign('company_profile_id')->references('id')->on('company_profiles');
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
        Schema::dropIfExists('company_galleries');
    }
}
