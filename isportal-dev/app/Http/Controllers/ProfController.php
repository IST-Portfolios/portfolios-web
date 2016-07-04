<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Activity;
use App\Enrollment;
use App\User;

class ProfController extends Controller
{


    public function lookup(){
        return view('professor.lookup');
    }

    public function getActivities(){
        return Activity::all();
    }

    public function getUsers(){
        return User::all();
    }

    public function getEnrollments(){
        return Enrollment::all();
    }

    public function getAll(){
        return array(
            'activities' => $this->getActivities(),
            'users' => $this->getUsers(),
            'enrollments' => $this->getEnrollments()
        );
    }
}
