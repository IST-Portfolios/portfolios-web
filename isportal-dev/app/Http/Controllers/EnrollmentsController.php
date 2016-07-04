<?php
/**
 * Created by IntelliJ IDEA.
 * User: joao
 * Date: 3/2/16
 * Time: 12:25 PM
 */

namespace App\Http\Controllers;


use App\Enrollment;
use App\Activity;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Validator;
use DB;
use App\Http\Requests;
use Auth;


class EnrollmentsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function prepareEnrollment()
    {
        $task_id = Input::get('id');
        $answer = "nok";
        try{
            Activity::findOrFail($task_id);
            $answer = "ok";
        }
        catch( Exception $e ){
        }

        $response = array(
            "response" => $answer,
            "url" => "/enrollIn/" . $task_id
        );

        return $response;
    }

    public function enrollIn($id){
        $priorities =  array(1,2,3);

        try{
            $activity = Activity::findOrFail($id);
            $user = Auth::user();

            if( $user->enrollments()->count() == 3 ){
                return redirect('/activity');
            }
            else{

                if($user->enrollments()->count() > 0){
                    $enrollments = $user->enrollments()->get();
                    foreach($enrollments as $e){
                        unset($priorities[$e->priority - 1]);
                    }

                }
                return view('activity.show',['activity' => $activity, 'priorities' => $priorities]);
            }
        }
        catch(Exception $e){
            return redirect("/activity");
        }
    }

    public function submitEnroll($id){
        $motivation = Input::get('motivation');

        //TODO: verifications;

        $validator = Validator::make(Input::all(),[
            'motivation' => 'required|min:50|max:500',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $enrollment = new Enrollment;

            $enrollment->activity_id = $id;
            $enrollment->motivation = $motivation;
            $enrollment->priority = Input::get('priority');
            $enrollment->entity_id = Auth::user()->id;
            $enrollment->state = 'pending';

            $enrollment->save();


            return redirect('/enrollments');
        }
        catch (QueryException $e){
            return redirect('/activity');
        }

    }

    public function index(){
        $enrollments = Auth::user()->enrollments()->get();
        return view('enrollment.index', ['enrollments' => $enrollments]);
    }

    public function changePriorities(){


        $changes = Input::get('changes');
        foreach($changes as $c){
            $enrollment = Enrollment::findOrFail($c['id']);
            $enrollment->priority = $c['priority'];
            $enrollment->save();
        }
        return array( 'response' => 'ok' );
    }

    public function deleteEnrollment(){
        $answer = 'nok';
        $id = Input::get('id');
        try{
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();
            $answer = 'ok';
        }
        catch (Exception $e){

        }
        $response = array(
            "response" => $answer
        );

        return $response;
    }

    public function manageCandidates(){
        $user = Auth::user();
        $activities = $user->activities()->get();
        $ids = array();
        foreach($activities as $a){
            array_push($ids, $a->id);
        }

        $pending = Enrollment::whereIn('activity_id', $ids)->where('state','pending')->get();
        $rejected = Enrollment::whereIn('activity_id', $ids)->where('state','rejected')->get();
        $accepted = Enrollment::whereIn('activity_id', $ids)->where('state','accepted')->get();

        return view('enrollment.candidates', [
            'pending' => $pending,
            'rejected' => $rejected,
            'accepted' => $accepted
        ]);
    }

    public function acceptEnrollment(){
        $id = Input::get('id');

        try{
            $e = Enrollment::findOrFail($id);
            $activity = Activity::findOrFail($e->activity_id);
            if( $activity->vacancies > 0 ){
                $e->state = 'accepted';
                $e->save();

                $activity->vacancies--;
                $activity->save();

                return array(
                    "response" => 'ok'
                );
            }
            else{
                return array(
                    'response' => 'err',
                    'err' => 'No more Vacancies'
                );
            }
        } catch (Exception $e){
            return array(
                'response' => 'nok'
            );
        }
    }

    public function rejectEnrollment()
    {
        $id = Input::get('id');

        try{
            $e = Enrollment::findOrFail($id);
            $activity = Activity::findOrFail($e->activity_id);

            $wasAccepted = false;
            if($e->state == "accepted"){
                $wasAccepted = true;
            }

            $e->state="rejected";
            $e->save();

            if($wasAccepted){
                $activity->vacancies++;
                $activity->save();
            }

            return array(
                "response"  =>  'ok'
            );

        }catch(Exception $e){
            return array(
                "response" => 'nok'
            );
        }
    }



}