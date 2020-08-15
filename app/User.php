<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\UserExperience;
use App\Models\UserQualification;
use App\Models\JobActivity;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function company()
    {
        return $this->hasOne('App\Models\CompanyProfile');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job');
    }

    public function favoriteJobs()
    {
        return $this->hasMany('App\Models\JobFavorite');
    }

    public function jobApplications()
    {
        return $this->hasMany('App\Models\JobActivity');
    }

    public function hasAppliedJob($job_id)
    {
        if (JobActivity::where('user_id', $this->id)->where('job_id', $job_id)->first() != null) {
            return true;
        }
        return false;
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function candidate()
    {
        return $this->hasOne('App\Models\CandidateProfile');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\UserCategory');
    }

    public function skills()
    {
        return $this->hasMany('App\Models\UserSkill');
    }

    public function experiences()
    {
        return $this->hasMany('App\Models\UserExperience');
    }

    public function qualifications()
    {
        return $this->hasMany('App\Models\UserQualification');
    }

    public function awards()
    {
        return $this->hasMany('App\Models\UserAward');
    }

    public function portfolios()
    {
        return $this->hasMany('App\Models\UserPortfolio');
    }

    public function received_messages()
    {
        return $this->hasMany('App\Models\Contact', 'to_user_id')->orderBy('is_replied', 'asc')->orderBy('id', 'desc');
    }

    public function sent_messages()
    {
        return $this->hasMany('App\Models\Contact', 'from_user_id')->orderBy('id', 'desc');
    }

    public function age()
    {
        $user = $this;
        $birthdate = $user->candidate->date_of_birth;
        $today = date('Y-m-d');

        if (is_null($birthdate)) {
            return '--';
        }
        $bday = new \DateTime($birthdate); // Your date of birth
        $today = new \Datetime($today);
        $diff = $today->diff($bday);
        //printf(' Your age : %d years, %d month, %d days', $diff->y, $diff->m, $diff->d);
        $year_age = $diff->y;
        return $year_age . ' years';
    }

    public function getExperienceInYears()
    {
        $user = $this;
        $i = 1;
        $start_date = '2012-05-10';
        $end_date = date('Y-m-d');
        
        foreach ($user->experiences as $ex) {
            if ($i == 1) {
                $start_date = $ex->start_date;;
            }
            if ($i == count($user->experiences)) {
                if (!is_null($ex->end_date)) {
                    $end_date = $ex->end_date;
                }
            }
            $i++;
        }

        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = round(($diff / (365*60*60*24)), 1);
        
        return $years;
    }

    public function lastQualification()
    {
        $user = $this;
        $qualification = UserQualification::where('user_id', $user->id)->orderBy('end_date', 'desc')->first();
        if (!is_null($qualification)) {
            return $qualification;
        }
        return null;
    }

    public function currentJob()
    {
        $user = User::find($this->id);
        if (!is_null($user)) {
            $userExperience = UserExperience::where('user_id', $this->id)->where('is_current_job', 1)->orderBy('id', 'desc')->first();
            return $userExperience;
        }
        return null;
    }

    /**
     * userCanPost function
     *
     * Check if the user can post job or not !!
     * @param  integer $user_id Employer ID
     * @return boolean          true if employer can post and false if not !!
     */
    public static function userCanPost($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            if ($user->is_company == 1) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
