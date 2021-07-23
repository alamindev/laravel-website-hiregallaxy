<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }    
}
