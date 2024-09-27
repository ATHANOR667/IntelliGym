<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabController extends Controller
{
    public function list(Request $request)
    {
       $etudiants =  DB::table('hour_slot_student')
           ->join('hour_slots', 'hour_slot_student.hour_slot_id', '=', 'hour_slots.id')
           ->join('students','students.id','=','hour_slot_student.student_id')
           ->join('classes','students.classe_id','=','classes.id')
           ->join('ecoles','ecoles.id','=','classes.ecole_id')
           ->where('hour_slots.semaine', $request->semaine)
           ->where('hour_slots.d_o_w', $request->d_o_w)
           ->where('hour_slots.debut', $request->debut)
           ->where('hour_slots.annee', $request->annee)
           ->where('hour_slots.campus_id', $request->campus_id)
           ->distinct('hour_slot_student.student_id')
           ->get(['students.nom','students.prenom','classes.niveau','ecoles.nom as nom_ecole']);


       ;


        return response()->json([
            'liste des etudiants ayant reserve la seance' => $etudiants
        ]);

    }

    public function set_campus(Request $request)
    {
        try {
            $user = Admin::where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
                //Auth::login($user);
                //$user_key = Crypt::encrypt($user->id);
                //$user_key = $user->createToken($user_key)->plainTextToken ;
                $campus = DB::table('campuses')
                ->join('ecoles','campuses.id','=','ecoles.campus_id')
                ->join('admins','admins.ecole_id','=','ecoles.id')
                ->where('admins.id','=',$user->id)
                ->first('campuses.*');
                return response()->json([
                    'status_code' => '200',
                    'status_message' => 'Identification réussie',
                    'data' => [
                        'campus'=> $campus,
                        //'admin'=>$user,
                        //'token'=>$user_key
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
                'status_message' => 'Utilisateur non reconnu',
                'data' => null
            ]);
        }
    }

}
