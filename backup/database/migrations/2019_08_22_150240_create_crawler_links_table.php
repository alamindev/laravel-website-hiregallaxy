<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlerLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawler_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('web_crawler_id');
            $table->unsignedBigInteger('crawler_site_id');

            $table->foreign('web_crawler_id')->references('id')->on('web_crawlers');
            $table->foreign('crawler_site_id')->references('id')->on('crawler_links');
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
        Schema::dropIfExists('crawler_links');
    }
}
