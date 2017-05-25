<?php
/**
 * Created by PhpStorm.
 * User: pjoaquim
 * Date: 18-05-2017
 * Time: 15:37
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

require_once(app_path() . "/Libraries/FenixEdu/FenixEdu.class.php");

class FenixEduAuthController extends Controller
{


    public function loginWithFenix()
    {

        $fenixEduClient = \FenixEdu::getSingleton();
        $authorizationUrl = $fenixEduClient->getAuthURL();

        return redirect()->away($authorizationUrl);

    }



    public function logout()
    {

        Auth::logout();

        Session::flush();

        return redirect('/')->withCookie(Cookie::forget(Auth::getRecallerName()));
    }


    public function authCallback()
    {
        if(isset($_GET['error'])) {
            return redirect("/");
        } else if(isset($_GET['code'])) {
            try {

                $code = $_GET['code'];
                $fenixEduClient = \FenixEdu::getSingleton();
                $fenixEduClient->getAccessTokenFromCode($code);

                $user = $this->getUserData($fenixEduClient->getPerson());

                Auth::login($user, true);

                return redirect()->intended('/home');

            } catch(Exception $e) {
                // The code received is invalid, goto the landing page (user probably tried to pass the code param)
                return redirect("/");
            }
        }
    }

    private function getUserData($person){

        $results = App\User::where('ist_id', $person->username);

        $user = new \App\User();
        $user->name = $person->name;
        $user->ist_id = $person->username;
        $user->email = $person->email;
        $user->type = $this->getUserType($person);


        if($results->count() == 1){

            $dbResult = $results->get()[0];

            $dbResult->name = $user->name;
            $dbResult->ist_id = $user->ist_id;
            $dbResult->email = $user->email;
            $dbResult->type = $user->type;

            var_dump($dbResult->update());

            return $dbResult;
        }
        else{
            return $user;
        }
    }


    private function getUserType($person){

        $type = "student";

        foreach ($person->roles as $role){
            if($role->type === "TEACHER" || $role->type === "PROFESSOR"){
                $type = "professor";
                break;
            }
        }

        return $type;
    }



}