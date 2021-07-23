<?php

namespace App\Models;
use App\Models\AptitudeAnswer;
use App\Models\Experience; 
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;

class Aptitude extends Model
{
    protected $casts = [
        'skills' => 'array',
    ];
    public function aptitudeanswers()
    {
        return $this->hasOne('App\Models\AptitudeAnswer', 'aptitude_id', 'id');
    }
    public function getAllSkill()
    {
        return Skill::whereIn('id', $this->skills)->pluck('name')->toArray(); 
    }
    public function getAllExperience()
    {
        $exp = explode(',', $this->exparience);
        return  Experience::whereIn('id', $exp)->pluck('name')->toArray(); 
    }
}
