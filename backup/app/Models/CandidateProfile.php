<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class CandidateProfile extends Model

{

	public $fillable = [

		'date_of_birth', 'user_id', 'career_level_id', 'sector', 'descipline_id', 'cv', 'gender'

	];



    public function sector_data()

    {

    	return $this->belongsTo(Category::class, 'sector');

    }    

  public function experience()

    {

        return $this->belongsTo(Experience::class);

    }

    public function career_level()

    {

    	return $this->belongsTo(CareerLevel::class);

    }

}

