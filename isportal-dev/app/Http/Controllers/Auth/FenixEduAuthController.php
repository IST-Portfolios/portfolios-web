<?php
/**
 * Created by PhpStorm.
 * User: pjoaquim
 * Date: 18-05-2017
 * Time: 15:37
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

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
                $_SESSION["student"] = getOrCreateStudent($fenixEduClient->getPerson());

            } catch(Exception $e) {
                // The code received is invalid, goto the landing page (user probably tried to pass the code param)
                header("Location: index.php");
            }
        }
    }



}