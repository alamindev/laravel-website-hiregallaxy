<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    public function category()
    {

        return $this->belongsTo(Category::class);

    }

    public function sector()
    {

        return $this->belongsTo(Sector::class);

    }

    public function discipline()
    {

        return $this->belongsTo(Discipline::class);

    }

    public function segment()
    {

        return $this->belongsTo(Segment::class);

    }

}
