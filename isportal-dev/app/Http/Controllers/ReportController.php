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
use Illuminate\Http\Response;
use ZipArchive;
use \RecursiveIteratorIterator;
use \RecursiveDirectoryIterator;

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

    public function downloadReport(){
      $report = Auth::user()->report;
      $file = __DIR__."/../../../reports/".$report;
      $headers = array(
              'Content-Type: application/pdf',
            );

      return response()->download($file, $report, $headers);
    }


    public function downloadReportsZipa(){
        $dir = __DIR__."/../../../reports/";
        $zip_file = 'file.zip';

        // Get real path for our folder
        $rootPath = realpath($dir);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();


        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($zip_file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zip_file));
        readfile($zip_file);

    }


    public function index(){
        return view('report.index');
    }


}
