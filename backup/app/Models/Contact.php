<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function sent_user()
    {
    	return $this->belongsTo('App\User', 'to_user_id');
    }    

    public function from_user()
    {
    	return $this->belongsTo('App\User', 'from_user_id');
    }
}
