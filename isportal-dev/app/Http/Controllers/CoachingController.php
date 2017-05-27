<?php

namespace App\Http\Controllers;

use App\CoachingTeam;
use App\Activity;
use App\Enrollment;
use App\CoacherEnrollment;
use App\User;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
	Controller that has all the functionality about coaching team management.
	Professor , Coacher and Coachees use it.
*/
class CoachingController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

	/*
		Return the view to enter the coaching team details
	*/
	public function createCoachingTeam() {
        return view('coaching.create');
    }

    /*
		Process a coaching team submission
    */
    public function submitCoachingTeam(Request $request) {
    	$user_type = Auth::user()->type;

		 $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:30|unique:coaching_teams',
            'email' => 'required|email|max:255|unique:coaching_teams',
        ]);

	 	if ($validator->fails()) {
        	return redirect('/createCoachingTeam')
            ->withErrors($validator)
            ->withInput();
   		 }

		$team = new CoachingTeam;
		$team->name = Input::get('name');
		$team->email = Input::get('email');

		$team->save();
		return redirect('home');
   
    }

    /*
		List all the coaching teams that exists
    */
    public function listCoachingTeams() {
    	$coachingTeams = CoachingTeam::all();
    	return view('coaching.list',['teams' => $coachingTeams]);
    }

    /*
        Return all the available coachers to add to a team
    */
    public function addCoacherToTeam($teamId) {
    	$coachingActivity = Activity::where('type','coaching')->first();
        if($coachingActivity) {
            $possibleCoachersEnrr = Enrollment::where('activity_id',$coachingActivity->id)->get();
            $availableCoachersId = array();
            foreach ($possibleCoachersEnrr as $enrr) {
                if(!CoacherEnrollment::where('coacher_id',$enrr->entity_id)->first() &&
                    $enrr->state == 'accepted') {
                    array_push($availableCoachersId, $enrr->entity_id);
                }
            }
            $availableCoachers = User::find($availableCoachersId);
            return view('coaching.addCoacher',["availableCoachers" => $availableCoachers,"teamId" => $teamId]);
        } else {
            return redirect("/home");  
        }
    }

    /*
        Process the submission of a coacher to a specific coaching team
    */
    public function submitCoacherToTeam($teamId, $coacherId) {
    	try {
            $coacherEnrollment = new CoacherEnrollment;
            $coacherEnrollment->coacher_id = $coacherId;
            $coacherEnrollment->coaching_team_id = $teamId;
            $coacherEnrollment->save();
            return redirect("/listCoachingTeams");
        } catch(Exception $e) {
             return redirect("/listCoachingTeams");   
        }
    }

    /*
        Remove the cocher from his coaching team and return the id
    */
    public function removeCoacher($coacherId) {
        $coacherEnrrollment = CoacherEnrollment::where('coacher_id',$coacherId)->first();
        $coacherEnrrollment->delete();
        return $coacherId;
    }

    /*
        Get all the coachers of the given team
    */
    public function getCoachers($teamId) {
        return CoachingTeam::find($teamId)->coachers();
    }

}

?>