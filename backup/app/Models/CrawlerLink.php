<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrawlerLink extends Model
{
    public function crawlerUrl()
    {
        return $this->belongsTo(WebCrawler::class, 'web_crawler_id');
    }

    public function crawlerSite()
    {
        return $this->belongsTo(CrawlerSite::class, 'crawler_site_id');
    }
}
