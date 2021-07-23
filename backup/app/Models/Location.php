<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	public $fillable = [
		'country_id',
		'street_address',
		'city',
		'state',
		'zip'
	];
	
    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

}
