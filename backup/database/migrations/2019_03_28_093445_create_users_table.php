<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('phone_no')->nullable();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment("0=>not verified, 1=>active, 2=>banned, 3=>deleted by user");
            $table->string('password');

            $table->string('verify_token')->nullable();
            $table->string('api_token', 60)->unique();

            $table->unsignedInteger('location_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('cover_picture')->nullable();
            $table->text('about')->nullable();

            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_plus_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('stackoverflow_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('github_link')->nullable();
            $table->string('website')->nullable();

            $table->boolean('is_company')->default(0);

            $table->rememberToken();

            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('users');
    }
}
