<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTag extends Model
{
    protected $fillable = [
    	'job_id', 
    	'tag_id'
    ];

    public function tag()
    {
      return $this->belongsTo(Tag::class);
    }

    public function job()
    {
      return $this->belongsTo(Job::class);
    }
}
