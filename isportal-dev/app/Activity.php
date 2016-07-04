<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function creator(){
        return $this->belongsTo(User::class);
    }

    public function enrollments(){
    	return $this->hasMany(Enrollment::class, 'activity_id');
    }
}
