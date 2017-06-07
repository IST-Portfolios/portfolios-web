<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoacherEnrollment extends Model
{

    public function coachingTeam(){
    	return $this->belongsTo(CoachingTeam::class);
    }

    public function coacher(){
        return User::find($this->coacher_id);
    }

}