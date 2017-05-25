<?php
/**
 * Created by PhpStorm.
 * User: pedroj
 * Date: 25-05-2017
 * Time: 18:49
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Auth;

class FakeLoginController extends Controller
{


    public function loginAsStudent()
    {
        $user = App\User::where('ist_id', 'ist0000')->get()[0];

        Auth::login($user, true);

        return redirect()->intended('/home');

    }


    public function loginAsProfessor()
    {
        $user = App\User::where('ist_id', 'ist0001')->get()[0];

        Auth::login($user, true);

        return redirect()->intended('/home');
    }


}