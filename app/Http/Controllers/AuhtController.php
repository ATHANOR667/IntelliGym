<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminSigninOtpRequest;
use App\Http\Requests\AdminSigninRequest;
use App\Http\Requests\EmailCheckRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Mail\OtpMail;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuhtController extends Controller
{


    /**
     *
     *FONCTION D"AUTHENTIFICATION POUR LES ADMINS
     *
     *
     */




    /**
     *
     *
     * INSCRIPTION D'UN ADMIN
     *
     *
     */
    function otp_request_signin() : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.auth.OtpRequestSignin');
    }

    function otp_request_signin_process( AdminSigninOtpRequest $request ):string|RedirectResponse
    {
        try {
            $email = $request->input('email');
            $matricule = $request->input('matricule');

            // on cherche l'admin avec firstorfail pour declencher une exception si le matricule est inconnu
            $admin = Admin::where('matricule', $request->input('matricule'))->first();

            if ($admin->email !== null){
                return redirect()->route('admin.otp_request_signin')->with([
                    'message' => 'Deja inscrit ....................................................................................'
                ]);
            }

            // Vérifier si l'utilisateur doit attendre avant de retenter
            if (session()->has('last_email_sent_time')) {
                $lastSentTime = session()->get('last_email_sent_time');
                $currentTime = now();

                $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                if ($diffInMinutes < 5) {
                    return redirect()->route('admin.otp_request_signin')->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
                }
            }

            //on verifie que l'admin qui veut s'inscrire n'est pas deja inscrit avant de lui envoyer le mail d'inscription

            try {
                $otp = random_int(1000, 9999);
                Mail::to($email)->send(new OtpMail($otp));
                Cache::put('otp_' . $email, $otp, 600);
                session()->put('validation_email', $email);
                session()->put('validation_matricule', $matricule);
                // Mettre à jour le timestamp de l'envoi d'e-mail
                session()->put('last_email_sent_time', now());
                return redirect()->route('admin.signin')->with(['message' => 'E-mail envoyé avec succès.']);
            } catch (\Exception $e) {
                return redirect()->route('admin.otp_request_signin')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
            }
        }catch (\Exception $e){
            return redirect()->route('admin.otp_request_signin')->with(['message' => 'Matricule inconnu ....................................................................................']);
        }
    }


    function signin(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.auth.signin');
    }

    function signin_process(AdminSigninRequest $request):string|RedirectResponse
    {
        $email = session('validation_email');
        $matricule = session('validation_matricule');
        $otp = $request->input('otp');

        try {
            $admin = Admin::where('matricule', $matricule)->firstOrFail();

            if (Cache::has('otp_' . $email) ) {
                if(Cache::get('otp_' . $email) == $otp){
                    Cache::forget('otp_' . $email);
                    $admin->update([
                        'password'=> bcrypt($request->input('password')),
                        'email'=>$email
                    ]);
                    return redirect()->route('admin.login')->with(['message','Modification reussie , vous pouvez vous connecter ']);
                }else{
                    return redirect()->route('admin.signin')->withErrors([
                        'otp' => ' Otp Incorrect ou expire '
                    ]);
                }
            }else{
                // pour email inconnu pourtant precedement mis en session )
                return redirect()->route('admin.otp_request_signin')->with([
                    'message' => 'Session expirée , veuillez recommencer le processus'
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // execption declenchee pour matricule inconnu  pourtant precedement mis en session )
            return redirect()->route('admin.otp_request_signin')->with([
                'message' => 'Session expirée , veuillez recommencer le processus'
            ]);
        }


    }





    /**
     * page d'accueil avec login
     */

    function login()
    {
        return view('admin.auth.login');
    }

    function login_process(AdminLoginRequest $request)
    {
        try {
            $admin = Admin::where('email',$request->validated(['email']))->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $admin = false;
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Vérifiez votre email ',
            ]);
        }
        //dd($admin);
        if ($admin && Hash::check($request->validated(['password']),$admin->password) )
        {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            $admin_key = Crypt::encrypt($admin->id);
            return redirect()->intended(route('admin.accueil',['admin'=>$admin_key]));
        }
        return redirect()->route('admin.login')->withErrors([
            'password' => 'Vérifiez votre mot de passe'
        ]);


    }

    /** logout
     *
     *
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    /**
     *
     * MODIFICATION DES IDENTIFIANTS
     *
     */







    /**
     *
     *
     *MODIFICAION DU MOT DE PASSE D'UN UTILISATEUR QUI EST CONNECTE
     *
     *
     *
     */


    function password_reset_init($admin):string|RedirectResponse
    {
        try {
            $admin_key = $admin;
            $admin = Admin::find(Crypt::decrypt($admin));
            $admin = $admin[0] == null ? $admin : $admin[0];

            $email = $admin->email;
        }catch (\Exception $e){
            return $e;
        }

        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 5) {
                return redirect()->route('admin.profil',['admin'=>$admin_key])->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
            }
        }

        try {
            $otp = random_int(1000, 9999);
            Cache::put('otp_' . $email, $otp, 600);
            Mail::to($email)->send(new OtpMail($otp));
            session()->put('validation_email', $email);
            // Mettre à jour le timestamp de l'envoi d'e-mail
            session()->put('last_email_sent_time', now());
            return   redirect()->route('admin.password_reset',['admin'=>$admin_key])->with(['message' => 'E-mail envoyé avec succès.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.profil',['admin'=>$admin_key])->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
        }
    }

    function password_reset(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return  view('admin.auth.password_reset');
    }

    function password_reset_process( PasswordResetRequest $request,$admin):string|RedirectResponse
    {
        $email = session('validation_email');
        $admin_key = $admin ;
        // Rechercher l'admin associé à cet email

        $otp = $request->input('otp');

        try {
            $admin = Admin::find(Crypt::decrypt($admin));
            $admin = $admin[0] == null ? $admin : $admin[0];
            if (Cache::has('otp_' . $email) ) {

                if(Cache::get('otp_' . $email) == $otp){
                    Cache::forget('otp_' . $email);
                    $admin->update([
                        'password'=> bcrypt($request->input('password')),
                    ]);
                    return redirect()->route('admin.login')->with(['message','Modification reussie , vous pouvez vous connecter ']);

                }else{
                    return redirect()->route('admin.password_reset',['admin' => $admin_key])->withErrors([
                        'otp' => ' Otp Incorrect  '
                    ]);
                }
            }else{
                return redirect()->route('admin.profil',['admin' => $admin_key])->with([
                    'message' => 'Session expirée '
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }
    }


    /**
     *
     *
     *MODIFICATION DU MOT DE PASSE D'UN UTILISATEUR QUI N'ETANT PAS CONNECTE
     *
     *
     */



    function password_reset_init_while_disconnected(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.auth.OtpRequestPasswordResetWhileDissconnected');
    }

    function password_reset_init_while_disconnected_process(EmailCheckRequest $request): string|RedirectResponse
    {
        $email = $request->input('email');

        try {
            $admin = Admin::where('email', $email)->first();

            if ($admin) {
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (session()->has('last_email_sent_time')) {
                    $lastSentTime = session()->get('last_email_sent_time');
                    $currentTime = now();

                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return redirect()->route('admin.password_reset_init_while_disconnected')
                            ->with(['message' => 'Veuillez attendre ' . (5 - $diffInMinutes) . ' minutes avant de retenter.']);
                    }
                }

                // Générer et envoyer l'OTP
                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 600);
                    Mail::to($email)->send(new OtpMail($otp));
                    session()->put('validation_email', $email);

                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    session()->put('last_email_sent_time', now());

                    return redirect()->route('admin.password_reset_while_disconnected')
                        ->with(['message' => 'E-mail envoyé avec succès.']);
                } catch (\Exception $e) {
                    return redirect()->route('admin.password_reset_init_while_disconnected')
                        ->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
                }
            } else {
                return redirect()->route('admin.password_reset_init_while_disconnected')
                    ->with(['message' => 'Adresse inconnue']);
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.password_reset_init_while_disconnected')
                ->with(['message' => 'Erreur interne']);
        }
    }


    function password_reset_while_disconnected(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return  view('admin.auth.password_reset');
    }

    function password_reset_process_while_disconnected( PasswordResetRequest $request):string|RedirectResponse
    {
        $email = session('validation_email');
        $otp = $request->input('otp');
        $admin = Admin::where('email', '=', $email)->first();
        if ($admin) {
            try {
                if (Cache::has('otp_' . $email)) {

                    if (Cache::get('otp_' . $email) == $otp) {
                        Cache::forget('otp_' . $email);
                        $admin->update([
                            'password' => bcrypt($request->input('password')),
                        ]);
                        return redirect()->route('admin.login')->with(['message', 'Modification reussie , vous pouvez vous connecter ']);

                    } else {
                        return redirect()->route('admin.password_reset_while_disconnected')->withErrors([
                            'otp' => ' Otp Incorrect ou expire  '
                        ]);
                    }
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return $e;
            }
        } else {
            return redirect()->route('admin.login')->with([
                'message' => 'Session expirée '
            ]);
        }

    }







    /**
     *
     *
     *MODIFICATION DE L'EMAIL
     *
     *
     */

    function email_reset_otp_request($admin): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.auth.OtpRequestEmailReset');
    }

    function email_reset_otp_request_process(AdminLoginRequest $request,$admin):string|RedirectResponse
    {
        try {
            $admin_key = $admin ;
            // Rechercher l'admin associé à cet email
            $admin = Admin::find(Crypt::decrypt($admin));
            $admin = $admin[0] == null ? $admin : $admin[0];
            $email = $request->input('email');

            if (Hash::check($request->input('password'),$admin->password) ){
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (session()->has('last_email_sent_time')) {
                    $lastSentTime = session()->get('last_email_sent_time');
                    $currentTime = now();
                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return redirect()->route('admin.email_reset_otp_request',['admin' => $admin_key])->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
                    }
                }
                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 600);
                    Mail::to($email)->send(new OtpMail($otp));
                    session()->put('validation_email', $email);
                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    session()->put('last_email_sent_time', now());
                    return redirect()->route('admin.email_reset',['admin' => $admin_key])->with(['message' => 'E-mail envoyé avec succès.']);
                } catch (\Exception $e) {
                    return redirect()->route('admin.email_reset_otp_request',['admin' => $admin_key])->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
                }
            }
            return redirect()->route('admin.email_reset_otp_request',['admin' => $admin_key])->withErrors([
                'password' => 'Vérifiez votre mot de passe'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }
    }

    public function email_reset($admin): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.auth.EmailReset');
    }

    public function email_reset_process(Request $request,$admin):string|RedirectResponse{
        $admin_key = $admin ;
        $otp = $request->input('otp');
        $email = session('validation_email');
        try {
            $admin = Admin::find(Crypt::decrypt($admin));
            $admin = $admin[0] == null ? $admin : $admin[0];

            if (Cache::has('otp_' . $email) ) {

                if (Cache::get('otp_' . $email) == $otp)
                {
                    Cache::forget('otp_' . $email);
                    $admin->update([
                        'email'=> $email ,
                    ]);

                    return redirect()->route('admin.profil',['admin' => $admin_key])->with(['message','Modification reussie , vous pouvez vous connecter ']);
                }else {
                    return redirect(route('admin.email_reset',['admin' => $admin_key]))->withErrors([
                        'otp' => 'Otp incorrect'
                    ]);

                }
            } else {

                return redirect(route('admin.email_reset',['admin' => $admin_key]))->withErrors([
                    'otp' => 'OTP Expire , veuillez en demander un autre'
                ]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }
    }


    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *FONCTION DAUTHENTIFICATION POUR LES UTILISATEURS
     *
     * ( uniquement le reset de mot de passe  car la preinscriptionetant un processus interne
     *   et le signin le reset  d'adresse mail  et login se vot via api )
     *
     *
     *
     *
     *
     */



    /**
     *
     * MODIFICATION DU MOT DE PASSE DU USER  CONNECTE
     *
     *
     */

    public function password_reset_user($user)
    {
        return view('user.auth.PasswordReset');
    }
    function password_reset_user_process( PasswordResetRequest $request,$user):string|RedirectResponse
    {
        $user_key = $user ;
        $otp = $request->input('otp');

        try {
            $user = Student::find(Crypt::decrypt($user));
            $user = $user[0] == null ? $user : $user[0];
            $email = $user->email;

            if (Cache::has('otp_' . $email) ) {
                if (Cache::get('otp_' . $email) == $otp) {
                    $user->update([
                    'password'=> bcrypt($request->input('password')),
                         ]);
                    Cache::forget('otp_' . $email);
                    return redirect()->route('user.success',['user'=>$user_key]);
                }else {
                    return redirect()->route('user.password_reset',['user' => $user_key])
                        ->with(['message' => 'OTP invalide']);
                }
            } else {
                return redirect()->route('user.password_reset',['user' => $user_key])
                    ->with(['message' => 'OTP Expire , veuillez en demander un autre']);
            }


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.password_reset',['user' => $user_key])->with([
                'message' => 'Erreur interne '
            ]);
        }



    }


    /**
     *
     * MODIFICATION DU MOT DE PASSE DU USER NON CONNECTE
     *
     *
     */


    function user_password_reset_while_disconnected(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return  view('admin.auth.password_reset');
    }

    function user_password_reset_process_while_disconnected( PasswordResetRequest $request):string|RedirectResponse
    {
        $email = session('validation_email');
        $otp = $request->input('otp');
        $admin = Admin::where('email', '=', $email)->first();
        if ($admin) {
            try {
                if (Cache::has('otp_' . $email)) {

                    if (Cache::get('otp_' . $email) == $otp) {
                        Cache::forget('otp_' . $email);
                        $admin->update([
                            'password' => bcrypt($request->input('password')),
                        ]);
                        return redirect()->route('admin.login')->with(['message', 'Modification reussie , vous pouvez vous connecter ']);

                    } else {
                        return redirect()->route('admin.password_reset_while_disconnected')->withErrors([
                            'otp' => ' Otp Incorrect ou expire  '
                        ]);
                    }
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return $e;
            }
        } else {
            return redirect()->route('admin.login')->with([
                'message' => 'Session expirée '
            ]);
        }

    }

    /**
     *
     *Vue retournee apres mofification des identifiants utilisateur via web
     */
    public function success($user)
    {
        return view('user.auth.Success');
    }
}
