<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    public function country()
    {
    	return $this->belongsTo(Country::class, 'job_location_country');
    }
}
