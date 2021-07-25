<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{

    protected $fillable = [

        'category_id',

        'job_id'

    ];

    public function job()

    {

    	return $this->belongsTo(Job::class);

    }

    public function postions()

    {

    	return $this->belongsTo(Category::class);

    }
}
