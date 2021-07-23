<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
	public $fillable = [
		'user_id',
		'category_id',
		'establish_date',
		'establish_year',
		'team_member',
		'total_view',
	];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
    
    public function team()
    {
    	return $this->belongsTo(TeamSize::class, 'team_member');
    }
}
