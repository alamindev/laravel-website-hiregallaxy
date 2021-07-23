<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSector extends Model
{
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
