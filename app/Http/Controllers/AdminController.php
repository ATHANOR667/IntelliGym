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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdminController extends AuhtController
{

    function accueil( $admin)
    {
        return view('admin.accueil')->with(['admin_key'=>$admin]);
    }

    function add_student( $admin)
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }
        $admin = Admin::find($admin);
        if (!$admin) {
            return 'ERROR 404';
        }
        $admin = $admin[0] == null ? $admin : $admin[0];
        $admin_key = Crypt::encrypt($admin);

        $classes = new Ecole();
        $classes= $classes->classes_by_admin_ecole($admin->id);


        return(view('admin.add_student',['admin'=>$admin, 'admin_key'=>$admin_key,'classes'=>$classes]));
    }
    function add_student_process(AdminCreateStudentRequest $request,  $admin)
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }
        $admin = Admin::find($admin);
        if (!$admin) {
            return 'error 404 ';
        }
        $admin = $admin[0] == null ? $admin : $admin[0];
        $student = $request->validated();

        Student::create([
            'classe_id' => $student['classe'],
            'ecole' => $admin->ecole,
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

        $admin_key = Crypt::encrypt($admin);


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
    function add_free_hour( $admin)
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }
        $admin = Admin::find($admin);
        if (!$admin) {
            return 'ERROR 404';
        }

        $admin_key =Crypt::encrypt($admin);
        return view('admin.add_free_hour',[
            'admin'=>$admin,
            'admin_key'=> $admin_key
        ]);

    }
    function  add_free_hour_process( $admin, Request $request)
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }
        $admin = Admin::find($admin);
        if (!$admin) {
            return 'ERROR 404';
        }
        $admin_key = Crypt::encrypt($admin);

        return redirect(route('admin.add_free_hour',['admin'=>$admin_key]));
    }


    /**
     * AJOUT DES HEURES OULA SALLE DEVRA ETRE FERMEE POUR LES ETUDIANTS D'UNE ECOLE
     *
     *
     */

    function hour_slot( $admin )
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }

        $admin = Admin::find($admin);
        if (!$admin) {
            return 'ERROR 404';
        }

        $admin_key =Crypt::encrypt($admin);
        return view('admin.add_hour_slot',[
            'admin'=>$admin,
            'admin_key'=> $admin_key
        ]);

    }
    function  hour_slot_process( $admin, Request $request)
    {
        try {
            $admin = Crypt::decrypt($admin);
        }catch (\Exception $e){
            return $e;
        }
        $admin = Admin::find($admin);
        if (!$admin) {
            return 'ERROR 404';
        }
        $admin_key = Crypt::encrypt($admin);

        return redirect(route('admin.add_hour_slot',['admin'=>$admin,'admin_key'=>$admin_key]));
    }
}