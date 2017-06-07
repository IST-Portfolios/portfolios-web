<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class ActivityController extends Controller{


    private $context;

    public function __construct(){
        $this->middleware('auth');
    }

    public function activityList(){
        $user = Auth::user();
        $enrolledIds = array();
        $activities = Activity::all();
        $enrolledActivities = array();
        if($user->enrollments()->count() > 0){
            $enrollments = $user->enrollments()->get();
            foreach ($enrollments as $e){
                array_push($enrolledIds, $e->entity_id);
            }

            $enrolledActivities = Activity::find($enrolledIds);
            $activities = Activity::whereNotIn('id', $enrolledIds)->where('type' , 'regular')->get();
        }



        return view('activity.list',['activities' => $activities ,'enrolled' => $enrolledActivities]);
    }

    public function getActivity($id){
        return Activity::findOrFail($id);
    }

    public function createActivity_index(){
        $coachingActivityExist = Activity::where('type', 'coaching')->first() === null;
        return view('activity.create',["coachingExist" => $coachingActivityExist]);
    }


    public function submitActivity(Request $request){
        $user_type = Auth::user()->type;
        $validator = null;

        if($user_type == 'student'){
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:5|max:30',
                'motivation' => 'required|min:50|max:500',
                'objectives' => 'required|min:50|max:500',
                'description' => 'required|min:50|max:1000',
                'type' => 'in:regular',
            ]);

        }
        else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:5|max:30',
                'vacancies' => 'required|min:1|max:30',
                'objectives' => 'required|min:50|max:500',
                'description' => 'required|min:50|max:1000',
                'type' => 'in:regular,coaching',
            ]);
        }

        if ($validator->fails()) {
            return redirect('/createActivity')
                ->withErrors($validator)
                ->withInput();
        }

        if($this->coachingActivityExist()) {
            return redirect('/createActivity')
                ->withErrors(array("Coaching activity already exist"))
                ->withInput();
        }

        $activity = new Activity;
        $activity->title =  Input::get('title');
        $activity->description =  Input::get('description');


        $activity->creator_id = Auth::user()->id;

        if($user_type == 'student'){
            $activity->motivation = Input::get('motivation');
            $activity->state = 'pending';
            $activity->type = 'self-proposed';
            $activity->vacancies = 1;
        }
        else{
            $activity->state = 'accepted';
            $activity->objectives = Input::get('objectives');
            $activity->type = Input::get('type');
            $activity->vacancies = Input::get('vacancies');
        }
        $activity->save();

        return redirect('home');
    }

    private function coachingActivityExist() {
        return Activity::where('type', 'coaching')->get() === null;
    }

    public function changeActivity($id){

        $validator = Validator::make(Input::all(), [
            'title' => 'required|min:5|max:30',
            'vacancies' => 'required|min:1|max:30',
            'objectives' => 'required|min:50|max:500',
            'description' => 'required|min:50|max:1000',
        ]);

        $activity = Activity::findOrFail($id);
        $activity->title = Input::get('title');
        $activity->vacancies = Input::get('vacancies');
        $activity->description = Input::get('description');
        $activity->objectives = Input::get('objectives');
        $activity->save();
        return redirect()->back();
    }

    public function manageActivities(){
        if(Auth::user()->type == "student"){
            return redirect("/home");
        }
        else{
            $activities = Auth::user()->activities()->get();
            return view('activity.management', ["activities" => $activities]);
        }
    }

}



?>