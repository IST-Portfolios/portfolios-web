<?php

namespace App\Http\Controllers;

use App\CoachingTeam;
use App\Activity;
use App\Enrollment;
use App\CoacherEnrollment;
use App\CoacheeEnrollment;
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
        Return the page of coaching for each user
    */
    public function index() {
        $user = Auth::user();
        $implicitType;
        if($user->type == 'professor') {
            $implicitType = 'professor';
            $coachingTeams = CoachingTeam::all();
            return view('coaching.index',['teams' => $coachingTeams,'implicitType' => $implicitType]);
        }
        else {
            if($user->isCoacher()) {
                $implicitType = 'coacher';
                //TODO
                return view('coaching.index');
            } else {
                $implicitType = 'coachee';
                //TODO
                return view('coaching.index');
            }
        }
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
		return redirect('coaching');
   
    }

    /*
        Return all the available coachers to add to a team
    */
    public function addCoacherToTeam($teamId) {
    	$coachingActivity = Activity::where('type','coaching')->first();
        if($coachingActivity) {
            $possibleCoachersEnrr = Enrollment::where('activity_id',$coachingActivity->id)->get();
            $availableCoachers = array();
            foreach ($possibleCoachersEnrr as $enrr) {
                if(!CoacherEnrollment::where('coacher_id',$enrr->entity_id)->first() &&
                    $enrr->state == 'accepted') {
                    array_push($availableCoachers, $enrr->entity_id);
                }
            }
            $res = User::find($availableCoachers);
            $coachingTeam = CoachingTeam::find($teamId);
            return view('coaching.addCoacher',["availableCoachers" => $res,"coachingTeam" => $coachingTeam]);
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
            return redirect("/coaching");
        } catch(Exception $e) {
             return redirect("/coaching");   
        }
    }

    /*
        Remove the cocher from his coaching team and return his id
    */
    public function removeCoacher($coacherId) {
        $coacherEnrrollment = CoacherEnrollment::where('coacher_id',$coacherId)->first();
        $coacherEnrrollment->delete();
        return $coacherId;
    }

    /*
        Return all the coachers of the given team
    */
    public function getCoachers($teamId) {
        return CoachingTeam::find($teamId)->coachers();
    }

    /*
        Return all the coachees that have no coaching team yet 
    */
    public function addCoacheeToTeam($teamId) {
        $coachingActivity = Activity::where('type','coaching')->first();
        if($coachingActivity) {
            $coacheesWithoutTeam = array();
            $users = User::where('type','student')->get();
            foreach($users as $user) {
                //TODO Select only the right coachees instead of all users
                array_push($coacheesWithoutTeam,$user);
            }
            $coachingTeam = CoachingTeam::find($teamId);
            return view('coaching.addCoachee',["coacheesWithoutTeam" => $coacheesWithoutTeam,"coachingTeam" => $coachingTeam]);
        } else {
            return redirect("/home");  
        }
    }

    /*
        Process the submission of a coachee to a specific team
    */
    public function submitCoacheeToTeam($teamId,$coacheeId) {
        try {
            $coacheeEnrollment = new CoacheeEnrollment;
            $coacheeEnrollment->coachee_id = $coacheeId;
            $coacheeEnrollment->coaching_team_id = $teamId;
            $coacheeEnrollment->save();
            return redirect("/coaching");
        } catch(Exception $e) {
             return redirect("/coaching");   
        }
    }

    /*
        Remove a coachee from his coaching team and return his id
    */
    public function removeCoachee($coacheeId){
        $coacheeEnrollment = CoacheeEnrollment::where('coachee_id',$coacheeId)->first();
        $coacheeEnrollment->delete();
        return $coacheeId;
    }

    /*
        Return all the coachees of the given team
    */
    public function getCoachees($teamId) {
        return CoachingTeam::find($teamId)->coachees();
    }

}

?>