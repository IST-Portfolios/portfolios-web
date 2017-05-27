<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoacheeEnrollment extends Model
{

    public function coachingTeam(){
    	return $this->belongsTo(CoachingTeam::class);
    }

    public function coachee(){
        return User::find($this->coachee_id);
    }

}