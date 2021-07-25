<?php



namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Support\Facades\DB;



class Job extends Model

{



    public $fillable = [

        'title', 'slug', 'email', 'description', 'user_id', 'category_id', 'type_id', 'experience_id', 'status_id', 'apply_type_id', 'country_id', 'location', 'gender', 'monthly_salary', 'salary_currency', 'is_salary_negotiable', 'deadline', 'is_featured', 'is_confirmed'

    ];



    public function user()

    {

        return $this->belongsTo('App\User');

    }



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



    public function template()

    {

        return $this->belongsTo(Template::class);

    }



    public function activities()

    {

        return $this->hasMany(JobActivity::class);

    }



    public function type()

    {

        return $this->belongsTo(JobType::class);

    }



    public function currency()

    {

        return $this->belongsTo(Currency::class, 'salary_currency');

    }



    public function getCurrencyName()

    {

        $job = $this;

        if (!is_null($job->currency)) {

            return $job->currency->name;

        }

        return 'USD';

    }

    public function getCurrencyNameByJobID($job_id)

    {

        $job = Job::find($job_id);

        if (!is_null($job->currency)) {

            return $job->currency->name;

        }

        return 'USD';

    }



    public function apply_type()

    {

        return $this->belongsTo(JobApplyType::class);

    }



    // public function location_data()

    // {

    //     return $this->belongsTo(Location::class, 'location_id');

    // }



    public function country()

    {

        return $this->belongsTo(Country::class);

    }



    // public function skills()

    // {

    //     return $this->hasMany(JobSkill::class);

    // }

    public function results() {

        return $this->hasMany("App\Models\Result", "job_id", "id");

    }



    public function skills()

    {

        return $this->belongsToMany('App\Models\Skill', 'job_skills', 'job_id', 'skill_id');

    }



    public function qualifications()

    {

        return $this->hasMany(JobQualification::class);

    }



    /**

     * checkQualification in the job

     *

     * @param  integer $qualification_id

     * @param  integer $job_id

     * @return boolean

     */

    public function checkQualification($qualification_id, $job_id)

    {

        $qualification = DB::table('job_qualifications')->where('job_id', $job_id)->where('qualification_id', $qualification_id)->first();

        if (!is_null($qualification)) {

            return true;

        }

        return false;

    }



    /**

     * checkSkill in the job

     *

     * @param  integer $skill_id

     * @param  integer $job_id

     * @return boolean

     */

    public function checkSkill($skill_id, $job_id)

    {

        $qualification = DB::table('job_skills')->where('job_id', $job_id)->where('skill_id', $skill_id)->first();

        if (!is_null($qualification)) {

            return true;

        }

        return false;

    }

}

