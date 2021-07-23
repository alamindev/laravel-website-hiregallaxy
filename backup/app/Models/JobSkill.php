<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    protected $table = 'job_skills'; 
    
    public function job()
    {
    	return $this->belongsTo(Job::class);
    }    
    public function skill()
    {
    	return $this->belongsTo(Skill::class);
    }
}
