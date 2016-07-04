<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_type = Auth::user()->type;
        if($user_type == "student")
            return view('home', ['type' => $user_type]);
        else{
            return view('home', ['type' => $user_type, 'candidates' => $this->countCandidates()]);
        }

    }

    public function countCandidates(){
        $count = 0;
        $activities = Auth::user()->activities()->get();
        foreach($activities as $a){
            $count += $a->enrollments()->count();
        }
        return $count;

    }
}
