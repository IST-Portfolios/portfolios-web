<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachingTeam extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email'];

    /*
		Return array with all the coachers Users of the team
    */
	public function coachers() {
		$coachersEnrollments = $this->hasMany(CoacherEnrollment::class,'coaching_team_id')->get();
		$coachers = array();
        foreach ($coachersEnrollments as $enrr) {
        	array_push($coachers, $enrr->coacher());
        }
        return $coachers;
    } 

}

?>