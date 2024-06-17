<?php

namespace App\Http\Controllers;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class UserController extends AuhtController
{



    public function generateQRCode($text)
    {
        $renderer = new ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(400),
            new \BaconQrCode\Renderer\Image\ImagickImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($text);

        // Enregistrez le code QR généré dans un fichier
        $path = public_path('qr-codes/');
        $filename = 'qrcode.png';
        $qrCode->saveToFile($path . $filename);

        return $filename;
    }


    function accueil_guest()
    {
        return view('student.accueil_guest');
    }

    function accueil($student)
    {
        try {
            $student = Crypt::decrypt($student);
        }catch (\Exception){
            Return "ERROR 404";
        }
        $student = Student::find($student);
        if(!$student){
            Return "ERROR 404";
        }

        $user_key = Crypt::encrypt($student->id);
       // $qr = $this->generateQRCode($student->matricule);
        return view('student.accueil')->with(['student'=>$student,'user_key'=>$user_key]);//,'qr'=>$qr
    }

    function booking( $student)
    {

        try {
            $student = Crypt::decrypt($student);
        }catch (\Exception){
            Return "ERROR 404";
        }
        $student = Student::find($student);
        if(!$student){
            Return "ERROR 404";
        }

        $user_key = Crypt::encrypt($student->id);
        return view('student.booking')->with(['student'=>$student,'user_key'=>$user_key]);
    }

    function profil($student)
    {
        try {
            $student = Crypt::decrypt($student);
        }catch (\Exception){
            Return "ERROR 404";
        }
        $student = Student::find($student);
        if(!$student){
            Return "ERROR 404";
        }

        $user_key = Crypt::encrypt($student->id);




        return view('student.profil',['student'=>$student,'user_key'=>$user_key]);
    }

}
