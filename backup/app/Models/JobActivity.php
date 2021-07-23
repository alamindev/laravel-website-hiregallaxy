<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobActivity extends Model
{

	public $fillable = [
		'user_id',
		'job_id',
		'expected_salary',
		'salary_currency',
		'is_salary_negotiable',
		'cover_letter',
		'cv'
	];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }    

    public function job()
    {
    	return $this->belongsTo(Job::class);
    }

    public function currency()
    {
    	return $this->belongsTo(Currency::class, 'salary_currency');
    }
}
