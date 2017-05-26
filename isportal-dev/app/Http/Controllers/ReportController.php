<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Validator;
use DB;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function submitReport(Request $request){
      $target_dir = __DIR__."/../../../reports/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
        $user = Auth::user();
        $user->report = $_FILES["fileToUpload"]["name"];
        $user->save();
      } else {
        return view('report.index');
      }

      return redirect('home');
    }

    public function index(){
        return view('report.index');
    }


}
