<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use App\Notifications\AdminPasswordResetNotification;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'username',
        'password',
        'image',
        'address',
        'verify_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
      $this->notify(new AdminPasswordResetNotification($token));
    }

    public function role()
    {
       return $this->belongsToMany(Role::class, 'role_admins');
    }
    
    public function hasRole($role)
    {
       foreach($this->role as $r){
           return $r->slug === $role;
       }
    }

}
