<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailCheckRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StudentLoginRequest;
use App\Http\Requests\StudentSigninRequest;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{

    function otp_request(EmailCheckRequest $request)
    {
        $email = $request->validated()['email'];

        //on verifie que leleve qui veut s'inscrire n'est pas deja inscrit avant de lui envoyer le mail d'inscription
        try {
            $student = Student::where('email', $email)->first();

            if($student){
                return response()->json([
                    'status_code' => '400',
                    'status_message' => 'Deja inscrit'
                ]);
            } else {

                try {
                    $otp = random_int(1000, 9999);
                    $email = $request->input('email');
                    Cache::put('otp_' . $email, $otp, 600);

                    Mail::to($email)->send(new OTPMail($otp));

                    return response()->json([
                        'message' => 'OTP envoyé avec succès',
                        'status_code' => '200',
                        ]);
                }catch (\Exception $e){
                    return response()->json([
                        'status_code' => '400',
                        'status_message' => 'probleme interne , veuillez essayer plus tard',
                    ]);
                }

            }

        } catch (\Exception $e) {
            return redirect()->route('user.mailcheck')->with(['message' => 'Erreur interne. Veuillez réessayer.']);
        }
    }

    public function otp_validate(Request $request)
    {
        $otp = $request->input('otp');
        $email = $request->input('email');

        if (Cache::has('otp_' . $email) && Cache::get('otp_' . $email) == $otp) {
            Cache::forget('otp_' . $email);
            return response()->json(['message' => ' OTP valide avec success'], 200);
        } else {
            return response()->json(['message' => 'OTP invalide'], 400);
        }
    }


    public function register(StudentSigninRequest $request)
    {
        $email = $request->input('email');
        $matricule = $request->input('matricule');
        $password = $request->input('password');

        try {
            $student = Student::where('matricule',$matricule)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Vous n`etes pas reconnu comme etudiant dune ecole du college de Paris',
                'status_code' => '200',
            ]);
        }

        $student->update([
            'password'=> bcrypt($password),
            'email'=>  $email,
            'active'=>true
        ]);

        return response()->json([
            'message' => 'inscription reussie',
            'status_code' => '200',
        ]);

    }

    public function login(StudentLoginRequest $request)
    {
        try {
            $user = Student::where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $user_key = Crypt::encrypt($user->id);
                $user_key = $user->createToken($user_key)->plainTextToken ;
                return response()->json([
                    'status_code' => '200',
                    'status_message' => 'Connexion réussie',
                    'data' => [
                        'user'=>$user,
                        'token'=>$user_key
                    ]
                ]);
            } else {
                return response()->json([
                    'status_code' => '403',
                    'status_message' => 'Mot de passe incorrect',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => '403',
                'status_message' => 'Utilisateur non trouvé',
                'data' => null
            ]);
        }
    }

}
