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
        unset($_SESSION["student"]);
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

                $_SESSION["fenixclient"] = $fenixEduClient;
                $_SESSION["student"] = $this->getOrCreateStudent($fenixEduClient->getPerson());

                return redirect("/home");

            } catch(Exception $e) {
                // The code received is invalid, goto the landing page (user probably tried to pass the code param)
                return redirect("/");
            }
        }
    }

    private function getOrCreateStudent($person){

        $user = new \App\User();
        $user->name = $person->name;
        $user->ist_id = $person->username;
        $user->email = $person->email;

        if(App\User::where('ist_id', $user->ist_id)->count() == 1){
            $user->update();
        }
        else{
            $user->save();
        }

        return $user;

    }



}