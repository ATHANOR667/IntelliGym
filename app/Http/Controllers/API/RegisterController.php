<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\EmailCheckRequest;
use App\Mail\OtpMail;
use App\Mail\PasswordResetMail;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
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

            $user = Student::where('email', $email)->first();

            if($user){
                return response()->json([
                    'status_code' => '400',
                    'status_message' => 'Deja inscrit'
                ]);
            } else {
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (Cache::has('last_email_sent_time_'.$email)) {
                    $lastSentTime = Cache::get('last_email_sent_time_'.$email);
                    $currentTime = now();

                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return response()->json([
                            'message' => 'Veuillez attendre ' . (5 - $diffInMinutes) . ' minutes avant de retenter.',
                            'status_code' => 400
                        ]);
                    }
                }

                // Générer et envoyer l'OTP
                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 300);
                    Mail::to($email)->send(new OtpMail($otp));
                    Cache::put('validation_email', $email);

                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    Cache::put('last_email_sent_time_'.$email, now());

                    return response()->json([
                        'message' => 'Un OTP vous a ete envoye ',
                        'status_code' => '200',
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status_code' => '400',
                        'message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.'
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => '400',
                'message' => 'Erreur interne'
            ]);
        }
    }

    public function otp_validate(Request $request)
    {
        $otp = $request->input('otp');
        $email = $request->input('email');

        if (Cache::has('otp_' . $email) ) {
            if (Cache::get('otp_' . $email) == $otp) {
                Cache::forget('otp_' . $email);
                return response()->json(['message' => ' OTP valide , operation effectuee avec success'], 200);
            }else {
                return response()->json(['message' => 'OTP invalide'], 400);
            }
        } else {
            return response()->json(['message' => 'OTP Expire , veuillez en demander un autre'], 400);
        }
    }


    public function register( Request $request)
    {
        $email = $request->input('email');
        $matricule = $request->input('matricule');
        $password = $request->input('password');

        try {
            $student = Student::where('matricule',$matricule)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Vous n`etes pas reconnu comme etudiant dune ecole du college de Paris',
                'status_code' => '400',
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

    public function login( AdminLoginRequest $request)
    {
        try {
            $user = Student::where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
                Auth::guard('student')->login($user);
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

    public function data()
    {
        $user =   \auth()->user();
        return response()->json([
            'status_code' => '200',
            'data' => [
                'user'=>$user,
            ]
        ]);
    }

    public function password_reset_init( )
    {
        $user =   \auth()->user();
        $email = $user->email ;
        //dd($user);

        try {
            if ($user) {
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (Cache::has('last_email_sent_time_'.$email)) {
                    $lastSentTime = Cache::get('last_email_sent_time_'.$email);
                    $currentTime = now();

                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return response()->json([
                            'message' => 'Veuillez attendre ' . (5 - $diffInMinutes) . ' minutes avant de retenter.',
                            'status_code' => 400
                        ]);
                    }
                }

                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 300);
                    Cache::put('validation_email', $email);
                    Cache::put('last_email_sent_time_'.$email, now());
                    Mail::to($email)->send(new PasswordResetMail($user,$otp));
                    return response()->json([
                        'message' => 'un email de reinitialisation vous a ete envoye ',
                        'status_code' => '200',
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status_code' => '400',
                        'message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.'
                    ]);
                }
            } else {
                return response()->json([
                    'status_code' => '400',
                    'message' => 'Adresse inconnue'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => '400',
                'message' => 'Erreur interne'
            ]);
        }
    }


    function password_reset_init_while_disconnected(EmailCheckRequest $request)
    {
        $email = $request->input('email');

        try {
            $user = Student::where('email', $email)->first();

            if ($user) {
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (Cache::has('last_email_sent_time_'.$email)) {
                    $lastSentTime = Cache::get('last_email_sent_time_'.$email);
                    $currentTime = now();

                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return response()->json([
                            'message' => 'Veuillez attendre ' . (5 - $diffInMinutes) . ' minutes avant de retenter.',
                            'status_code' => 400
                            ]);
                    }
                }

                // Générer et envoyer l'OTP
                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 300);
                    Cache::put('validation_email', $email);
                    Cache::put('last_email_sent_time_'.$email, now());
                    Mail::to($email)->send(new PasswordResetMail($user,$otp));
                    return response()->json([
                        'message' => 'un email de reinitialisation vous a ete envoye ',
                        'status_code' => '200',
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status_code' => '400',
                        'message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.'
                    ]);
                }
            } else {
                return response()->json([
                    'status_code' => '400',
                    'message' => 'Adresse inconnue'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => '400',
                'message' => 'Erreur interne'
            ]);
        }
    }

    public function email_reset_init(EmailCheckRequest $request)
    {


        try {

            $user =   \auth()->user();
            $email = $request['email'] ;
            if ($user->email !== $email) {
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (Cache::has('last_email_sent_time_'.$email)) {
                    $lastSentTime = Cache::get('last_email_sent_time_'.$email);
                    $currentTime = now();

                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return response()->json([
                            'message' => 'Veuillez attendre ' . (5 - $diffInMinutes) . ' minutes avant de retenter.',
                            'status_code' => 400
                        ]);
                    }
                }

                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 300);
                    Cache::put('validation_email', $email);
                    Cache::put('last_email_sent_time_'.$email, now());
                    Mail::to($email)->send(new OTPMail($otp));
                    return response()->json([
                        'message' => 'un OTP vous a ete envoye ',
                        'status_code' => '200',
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status_code' => '400',
                        'message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.'
                    ]);
                }
            } else {
                return response()->json([
                    'status_code' => '400',
                    'message' => 'Adresse inconnue'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => '400',
                'message' => 'il s\'agit de votre adresse actuelle'
            ]);
        }
    }




}
