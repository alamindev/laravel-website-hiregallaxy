<?php

namespace App\Models;

use App\Models\Answers;
use App\Models\Experience;
use App\Models\Question;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'lar_question';
    protected $casts = [
        'skills' => 'array',
    ];
    public function answers()
    {
        return $this->hasOne('App\Models\Answers', 'question_id', 'id');
    }
    public function getAllSkill()
    {
        $skills = Skill::whereIn('id', $this->skills)->pluck('name')->toArray();
        return $skills;
    }
    public function getAllExperience()
    {
        $exp = explode(',', $this->exparience);
        $skills = Experience::whereIn('id', $exp)->pluck('name')->toArray();
        return $skills;
    }
}