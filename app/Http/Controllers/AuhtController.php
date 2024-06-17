<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\EmailCheckRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\StudentLoginRequest;
use App\Http\Requests\StudentSigninRequest;
use App\Mail\AdminCheckmail;
use App\Mail\AdminResetMail;
use App\Mail\EmailCheckMail;
use App\Mail\PasswordResetMail;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class AuhtController extends Controller
{

    /**
     *
     *FONCTION D"AUTHENTIFICATION POUR LES ADMINS
     *
     *
     */

    /**
     * page d'accueil avec login
     */

    function admin_login()
    {
        return view('admin.login');
    }

    function admin_login_process(AdminLoginRequest $request)
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
            Auth::login($admin);
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
    public function admin_logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
    /**
     *
     * page d'incription : on check d'abord l'email
     */

    function admin_checkmail()
    {
        return view('admin.checkmail');
    }

    function admin_checkmail_process(EmailCheckRequest $request)
    {
        $email = $request->validated()['email'];

        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 1) {
                return redirect()->route('admin.checkmail')->with(['message' => 'Veuillez attendre 5 minutes avant de retenter.']);
            }
        }

        //on verifie que l'admin qui veut s'inscrire n'est pas deja inscrit avant de lui envoyer le mail d'inscription
        try {
            $admin = Admin::where('email', $email)->first();

            if ($admin) {
                return redirect()->route('user.mailcheck')->with(['message' => 'Vous êtes déjà inscrit.']);
            } else {

                try {
                    Mail::to($email)->send(new AdminCheckmail());
                    session()->put('validation_email', $email);
                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    session()->put('last_email_sent_time', now());
                    return redirect()->route('user.mailcheck')->with(['message' => 'E-mail envoyé avec succès.']);
                } catch (\Exception $e) {
                    return redirect()->route('user.mailcheck')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('user.mailcheck')->with(['message' => 'Erreur interne . Veuillez réessayer.']);
        }
    }

    /**
     *
     * page d'incription : on demande d creer le mot de passe a partir de la page donton a envoye le lien  dans l'email
     */
    function admin_signin()
    {
        return view('admin.signin');
    }

    function admin_signin_process(StudentSigninRequest $request)
    {
        $email = session('validation_email');
        $data= $request->validated();
        try {
            $admin = Admin::where('matricule',$request->validated(['matricule']))->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $admin = false;
            return redirect(route('admin.signin'))->withErrors([
                'matricule' => 'Vous n`etes pas reconnu comme administrateur  dune ecole du college de Paris'
            ]);
            //User1user1

        }

        $admin->update([
            'password'=> bcrypt($data['password']),
            'email'=>  $email
        ]);

        return to_route('admin.login')->with(['message','Inscription reussie , vous pouvez vous connecter ']);

    }

    /**
     *reset du mmot de passe pour un utilisateur l'ayant oublie
     */
    public function admin_reset_init()
    {
        return view('admin.reset_init');
    }
    public function admin_reset_init_exec(EmailCheckRequest $request)
    {
        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 10) {
                return redirect()->route('admin.reset_init')->with(['message' => 'Veuillez attendre 5 minutes avant de retenter.']);
            }
        }
        try {
            $admin = Admin::where('email', $request['email'])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect(route('admin.reset_init'))->with('message', 'Adresse inconnue');
        }

        if ($admin->email) {
            try {
                Mail::to($admin)->send(new AdminResetMail($admin));
                session()->put('last_email_sent_time', now());
                return redirect(route('admin.login'))->with('message', 'Un email de réinitialisation vous a été envoyé');
            } catch (\Exception $exception) {
                // Log the error for debugging purposes
                Log::error("Une erreur s'est produite lors de l'envoi de l'email : " . $exception->getMessage());
                return redirect(route('user.reset_init'))->with('message', 'Une erreur s\'est produite lors de l\'envoi de l\'email' . $exception->getMessage());

            }
        }


    }


    public function admin_reset( Admin $admin)
    {
        return view('admin.reset');
    }

    public function admin_reset_process(Admin $admin ,PasswordResetRequest $request)
    {
        try {
            $admin->update(['password' => bcrypt($request['password'])]);
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('admin.login');
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
 * FONCTION D"AUTHENTIFICATION POUR LES ELEVES
 *
 *
 *
 *
 *
 *
 *
 *
 */
    function email_check()
    {
        return view('student.emailcheck');
    }

    // on verifie si l'email existe en envoyant n mail pour l'incription
    //si le mail est envoye on sauvegarde l'adresse en session
    function email_check_process(EmailCheckRequest $request)
    {
        $email = $request->validated()['email'];

        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 5) {
                return redirect()->route('user.mailcheck')->with(['message' => 'Veuillez attendre 5 minutes avant de retenter.']);
            }
        }

        //on verifie que leleve qui veut s'inscrire n'est pas deja inscrit avant de lui envoyer le mail d'inscription
        try {
            $student = Student::where('email', $email)->first();

            if($student){
                return redirect()->route('user.mailcheck')->with(['message' => 'Vous êtes déjà inscrit.']);
            } else {

                try {
                    Mail::to($email)->send(new EmailCheckMail());
                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    session()->put('last_email_sent_time', now());
                    session()->put('validation_email', $email);
                    return redirect()->route('user.mailcheck')->with(['message' => 'E-mail envoyé avec succès.']);
                }catch (\Exception $e){
                    return redirect()->route('user.mailcheck')->with(['message' => 'Erreur lors de l\'envoi du mail. Veuillez réessayer.']);
                }

            }

        } catch (\Exception $e) {
            return redirect()->route('user.mailcheck')->with(['message' => 'Erreur interne. Veuillez réessayer.']);
        }
    }

    function student_signin()
    {

        $validation_email = session('validation_email');
        return view('student.signin');
    }

    // on incrit l'eleve en :
    // -enregistrant le mail prealablement fourni
    // - verifiant son matricule
    // - enregistrant son mot de passe
    function student_signin_process(StudentSigninRequest $request)
    {
        $email = session('validation_email');
        $data= $request->validated();
        try {
            $student = Student::where('matricule',$request->validated(['matricule']))->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $student = false;
            return redirect(route('user.signin'))->withErrors([
                'matricule' => 'Vous n`etes pas reconnu comme etudiant dune ecole du college de Paris'
            ]);
            //User1user1

        }

        $student->update([
            'password'=> bcrypt($data['password']),
            'email'=>  $email,
            'active'=>true
        ]);

        return to_route('user.login')->with(['message','Inscription reussie , vous pouvez vous connecter ']);

    }

    function student_login()
    {
        return view('student.login');
    }

    function student_login_process(StudentLoginRequest $request)
    {


        try {
            $user = Student::where('email',$request->validated(['email']))->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $user = false;
            return redirect()->route('user.login')->withErrors([
                'email' => 'Vérifiez votre email ',
            ]);
        }
        //dd($user);
        if ($user && Hash::check($request->validated(['password']),$user->password))
        {
            Auth::login($user);
            $request->session()->regenerate();
            $user_key = Crypt::encrypt($user->id);
            return redirect()->intended(route('user.accueil',['student'=>$user_key]));
        }
        return redirect()->route('user.login')->withErrors([
            'password' => 'Vérifiez votre mot de passe'
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.accueil_guest');
    }
    /**  PASSWORD RESET
     *
     *
     *
     *
     */

    public function reset_init()
    {
        return view('student.reset_init');
    }
    public function reset_init_exec(EmailCheckRequest $request)
    {
        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time'))
        {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 10) {
                return redirect()->route('user.reset_init')->with(['message' => 'Veuillez attendre 5 minutes avant de retenter.']);
            }
        }


        try {
            $student = Student::where('email', $request['email'])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect(route('user.reset_init'))->with('message', 'Adresse inconnue');
        }

        if ($student->email) {
            try {
                Mail::to($student)->send(new PasswordResetMail($student));
                session()->put('last_email_sent_time', now());
                return redirect(route('user.login'))->with('message', 'Un email de réinitialisation vous a été envoyé');
            } catch (\Exception $exception) {
                // Log the error for debugging purposes
                Log::error("Une erreur s'est produite lors de l'envoi de l'email : " . $exception->getMessage());
                return redirect(route('user.reset_init'))->with('message', 'Une erreur s\'est produite lors de l\'envoi de l\'email'. $exception->getMessage());

            }
        }


    }


    public function reset( Student $student)
    {
        return view('student.reset');
    }

    public function reset_process(Student $student ,PasswordResetRequest $request)
    {
        try {
            $student->update(['password' => bcrypt($request['password'])]);
        }catch (\Exception $e){
            return  $e ;
        }
        return redirect()->route('user.login');
    }
}
