<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    protected $fillable = [

        'name',

        'slug',

        'description',

        'status',

    ];

    public function skill_jobs()
    {

        return $this->belongsToMany('App\Models\Skill', 'job_skills')->withTimestamps();

    }

}
