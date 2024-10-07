<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateStudentRequest;
use App\Models\Admin;
use App\Models\Ecole;
use App\Models\FreeHour;
use App\Models\HourSlot;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdminController extends AuhtController
{

    function accueil( string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        return view('admin.pages.accueil')->with(['admin_key'=>$admin]);
    }


    /**
     * ROUTE PERMETANT D'AFFICHER LA LISTE DES ETUDIANTS AYANT RESERVE UNE SEANCE
     *
     *
     */
    function list( string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        $admin_key = $admin;
        $admin = Auth::guard('admin')->user();

        $classes = new Ecole();
        $classes= $classes->classes_by_admin_ecole($admin->id);


        return(view('admin.pages.list',['admin'=>$admin, 'admin_key'=>$admin_key,'classes'=>$classes]));
    }

    /**
     *   PROFIL
     *
     */

    public function profil(string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        $admin_key = $admin;
        $admin = Auth::guard('admin')->user();

        return view('admin.pages.profil', [
            'admin'=>$admin,
            'admin_key'=>$admin_key
        ]);

    }
    function add_student( string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {

        $admin_key = $admin ;
        $admin = Auth::guard('admin')->user();

        $classes = new Ecole();
        $classes= $classes->classes_by_admin_ecole($admin->id);


        return(view('admin.pages.add_student',['admin'=>$admin, 'admin_key'=>$admin_key,'classes'=>$classes]));
    }
    function add_student_process(AdminCreateStudentRequest $request,  string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\Foundation\Application
    {
        try {
            $student = $request->validated();
            $admin_key = $admin  ;
            $admin = Auth::guard('admin')->user();
            Student::create([
                'classe_id' => $student['classe'],
                'matricule' => $student['matricule'],
                'nom' => $student['nom'],
                'prenom' => $student['prenom'],
                'date_naiss' => $student['date_naiss'],
                'sexe' => $student['sexe'],
                'adherant'=>false ,
                'delete'=>false,
                'active'=>false,
                'admin_id'=>$admin->id
            ]);
        }catch (\Exception $e){
            return 'ERROR 404';
        }


        return redirect(route('admin.add_student',['admin'=>$admin_key]))->with(['message' => 'Élève enregistré']);
    }


    /**
     *
     *
     * FONCTIONS LIEES AUX DATES ET AUX HEURES
     */


    /** AJOUT DES HEURES LIBRES POUR CHAQUE SEMAINE
     *
     *
     */
    function add_free_hour( string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        $admin_key =$admin;
        $admin = Auth::guard('admin')->user();

        return view('admin.pages.add_free_hour',[
            'admin'=>$admin,
            'admin_key'=> $admin_key
        ]);

    }


    /**
     * AJOUT DES HEURES OULA SALLE DEVRA ETRE FERMEE POUR LES ETUDIANTS D'UNE ECOLE
     *
     *
     */

    function hour_slot( string $admin) :\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        $admin_key = $admin;
        $admin = Auth::guard('admin')->user();

        return view('admin.pages.add_hour_slot',[
            'admin'=>$admin,
            'admin_key'=> $admin_key
        ]);

    }

}
