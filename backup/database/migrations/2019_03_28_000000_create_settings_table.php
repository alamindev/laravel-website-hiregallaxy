<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_title');
            $table->string('site_author')->nullable();
            $table->string('site_short_description')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_address')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_email')->nullable();
            $table->string('site_phone')->nullable();
            $table->string('site_url')->nullable();

            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_plus_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('stackoverflow_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('github_link')->nullable();
            $table->string('instragram_links')->nullable();

            $table->text('download_app_text')->nullable();
            $table->string('playstore_app_link')->nullable();
            $table->string('applestore_app_link')->nullable();

            $table->unsignedTinyInteger('user_category_limit')->default(10);
            $table->unsignedTinyInteger('user_skill_limit')->default(10);

            $table->string('admin_theme')->default('primary');
            $table->boolean('enable_job_editing')->default(1);
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
        Schema::dropIfExists('settings');
    }
}
