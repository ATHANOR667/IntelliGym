<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public $student;
    public  $class ;
    public string $ecole ;
    public $semaine ;
    public $BookableHour ;
    public $BookedHour;
    public $NoBookableHour ;
    public $limit ;
    public $campus ;

    public function __construct(Request $request)
    {

        $this->semaine = $request->semaine ;

    }

    public function histo()
    {
        $this->student = \auth()->user();

        $reservations_de_la_semaine =  DB::table('hour_slot_student')
            ->join('hour_slots', 'hour_slot_student.hour_slot_id', '=', 'hour_slots.id')
            ->where('hour_slot_student.student_id', $this->student->id)
            ->where('hour_slot_student.annulation','=',false)
            ->where('hour_slots.classe_id',$this->student->classe_id)
            ->select( ['hour_slots.jour','hour_slots.mois','hour_slots.d_o_w','hour_slots.debut'])
            ->get();

        return response()->json([
            'historique des reservations' => $reservations_de_la_semaine
        ]);

    }

    public function params()
    {
        $this->set_free();
        $this->BookableHourSet();
        $this->NoBookableHour = $this->rest($this->BookableHour);
        $this->BookedHourSet();


        return response()->json([
            'semaine'=>$this->semaine,
            'limit'=>$this->limit,
            'bookable'=>$this->BookableHour,
            'notbookable'=>$this->NoBookableHour,
            'booked'=>$this->BookedHour
        ]);
    }


    public function exec(Request $request)
    {

       $add = $request->add ;
       $delete = $request->delete;
       $this->add($add);
       $this->throw($delete);

        $this->set_free();
        $this->BookableHourSet();
        $this->NoBookableHour = $this->rest($this->BookableHour);
        $this->BookedHourSet();

        return response()->json([
            'semaine'=>$this->semaine,
            'limit'=>$this->limit,
            'bookable'=>$this->BookableHour,
            'notbookable'=>$this->NoBookableHour,
            'booked'=>$this->BookedHour
        ]);

    }




    /**
     *
     * FONCTION UTILISEE POUR OBTENIR LE MIRROIR DES VALEURS DANS UN TABLEAU SUR UNE PLAGE $PLAGE
     *ELLE SERA UTILISEE POUR DETERMINER LES HEURES NON RESERVABLES UNE FOIS LES HEURS RESERVALES DETERMINEES
     *
     * */
    public function rest($array) {
        $rest = [];
        $PLAGE = 49 ;
        for ($i = 1; $i <= $PLAGE; $i++) {
            if (!in_array($i, $array)) {
                $rest[] = $i;
            }
        }
        return $rest;
    }


    /** PERMET A L'TILISATEUR DE SELECTIONNER SUR QUELLE SEMAINE IL EFFECTUE CES OPPERATIONS  */
    public function setWeek($week,)
    {
        $this->semaine = $week;
        $this->to_add = [];
        $this->to_delete = [];
        $this->jours =$this->getJoursSemaine($week);
        // $this->dispatch('weekUpdated', new Weekupdate($this->semaine,$this->jours));
    }

    /** PERMET D'AFFICHER "SEMAINE DU ... AU .. POUR LA PLAGE SELECTIONNEE PAR L'UTILISATEUR  */
    public  function getJoursSemaine($numeroSemaine) {

        $date = Carbon::now();
        $annee = $date->format('Y');
        $date->setISODate($annee, $numeroSemaine);

        $premierJour = $date->startOfWeek()->format('Y-m-d');
        $dernierJour = $date->endOfWeek()->format('Y-m-d');

        return array($premierJour, $dernierJour);
    }

    /** LOGIQUE DE RESERVATION :
     *
     * ON RECHERCHE LA SEANCE QUE L'UTILISATEUR VEURT RESERVER
     *ON VERIFIE QU'ELLE N'EST PAS PLEINE PUIS ON L'INSERE
     *
     */
    public function add_logic($d_o_w , $fin){
        $this->student = \auth()->user();
        $query_campus  = DB::table('campuses')
            ->join('ecoles','campuses.id','=','ecoles.campus_id')
            ->join('classes','ecoles.id','=','classes.ecole_id')
            ->where('classes.id','=',$this->student->classe_id)
            ->first(['campuses.capacite','campuses.id']);
        $this->campus = $query_campus->id;
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        $slots = \App\Models\HourSlot::where([
            'date'=> $date->format('Y').'-'.$date->format('m').'-'.$d_o_w,
            'semaine'=> $this->semaine,
            'fin' => $fin ,
            'campus_id'=> $this->campus,
            'delete'=>false,
        ])->get();

        $query = DB::table('hour_slot_student');

        foreach ($slots as $slot){
            $query = DB::table('hour_slot_student');
            if(!$slot->full){
                $query->insert([
                    'annulation'=>false,
                    'presence'=>false,
                    'student_id'=>$this->student->id ,
                    'hour_slot_id'=> $slot->id,
                ]);
            }

            /**si la reservation qui vient d'etre faite remplit la seance , on change  la valeur
             * du champ full de cette seance a true
             */

            $n = $query->where([
                'hour_slot_id'=> $slot->id,
            ])->count();

            if($n == $this->limit){
                $slot->update([
                    'full'=>true
                ]);
            }
        }

    }

    /** LOGIQUE D'ANNULATION DE RESERVATION :
     *
     * ON RECHERCHE LA LA SEANCE RESERVEE
     * PUIS ON ANNULE LA RESERVATION ASSOCIEE
     *
     */
    public function throw_logic($d_o_w , $fin)
    {
        $this->student = \auth()->user();
        $query_campus  = DB::table('campuses')
            ->join('ecoles','campuses.id','=','ecoles.campus_id')
            ->join('classes','ecoles.id','=','classes.ecole_id')
            ->where('classes.id','=',$this->student->classe_id)
            ->first(['campuses.capacite','campuses.id']);
        $this->campus = $query_campus->id;
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        $slots = \App\Models\HourSlot::where([
            'date'=> $date->format('Y').'-'.$date->format('m').'-'.$d_o_w,
            'semaine'=> $this->semaine,
            'fin' => $fin ,
            'campus_id'=> $this->campus,
            'delete'=>false,
        ])->get();

        $query = DB::table('hour_slot_student');

        foreach ($slots as $slot)
        {

            $query->where([
                'student_id'=>$this->student->id ,
                'hour_slot_id'=> $slot->id,
            ])->delete();

            /** apres avoir supprime la reservation si la seance etait full on signale en bd q'ulle ne l'est plus
             *
             */
            if($slot->full == true){
                $slot->update([
                    'full'=>false
                ]);
            }
        }
    }

    /** LOGIQUE DE RESERVABILITE D'UNE HEURE :
     *
     * ON RECHERCHE LA  SEANCE DESIREE
     *ON VERIFIE QU'ELLE N'EST PAS SUPPRIMEE (SOFT ) ET QUE DES PLACES ONT ENCORE DISPONIBLE
     *
     */

    public function BookableHourSet_logic($d_o_w , $fin,$id)
    {
        $this->student = \auth()->user();

        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        $slot = \App\Models\HourSlot::where([
            'date'=> $date->format('Y').'-'.$date->format('m').'-'.$d_o_w,
            'semaine'=> $this->semaine,
            'fin' => $fin ,
            'classe_id'=> $this->student->classe_id,
        ])->first();

        if($slot != null){
            if($this->is_full($slot->id) || $slot->delete == true){
                if (($key = array_search( $id, $this->BookableHour)) !== false) {
                    unset($this->BookableHour[$key]);
                }
            }
        }else{
            if (($key = array_search( $id, $this->BookableHour)) !== false) {
                unset($this->BookableHour[$key]);
            }
        }
    }

    /** RESERVATION PROPREMENT DITE :
     *ON RECUPERE UN TABLEAU D'HEURES A RESERVER PUI ON UTLISE LA LOGIQUE
     * PRECEDEMENT ENONCEE POUR PROCEDER A LA REERVATION DES DITES HEURES
     */
    public function add($selectedTimes)
    {
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $this->semaine)->isoWeekday(1)->day ;
        $mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4;$samedi =$lundi+5;$dimanche = $lundi+6;
        foreach ($selectedTimes as $data){
            switch ($data){
                case 1 :
                    $this->add_logic($lundi,10);
                    break;
                case 2 :
                    $this->add_logic($mardi,10);
                    break;
                case 3 :
                    $this->add_logic($mercredi,10);
                    break;
                case 4 :
                    $this->add_logic($jeudi,10);
                    break;
                case 5 :
                    $this->add_logic($vendredi,10);
                    break;
                case 6 :
                    $this->add_logic($samedi,10);
                    break;
                case 7 :
                    $this->add_logic($dimanche,10);
                    break;
                case 8 :
                    $this->add_logic($lundi,12);
                    break;
                case 9 :
                    $this->add_logic($mardi,12);
                    break;
                case  10:
                    $this->add_logic($mercredi,12);
                    break;
                case 11 :
                    $this->add_logic($jeudi,12);
                    break;
                case 12 :
                    $this->add_logic($vendredi,12);
                    break;
                case 13 :
                    $this->add_logic($samedi,12);
                    break;
                case 14 :
                    $this->add_logic($dimanche,12);
                    break;
                case 15 :
                    $this->add_logic($lundi,14);
                    break;
                case 16 :
                    $this->add_logic($mardi,14);
                    break;
                case 17 :
                    $this->add_logic($mercredi,14);
                    break;
                case 18 :
                    $this->add_logic($jeudi,14);
                    break;
                case 19 :
                    $this->add_logic($vendredi,14);
                    break;
                case 20 :
                    $this->add_logic($samedi,14);
                    break;
                case 21 :
                    $this->add_logic($dimanche,14);
                    break;
                case 22 :
                    $this->add_logic($lundi,16);
                    break;
                case 23 :
                    $this->add_logic($mardi,16);
                    break;
                case 24 :
                    $this->add_logic($mercredi,16);
                    break;
                case  25:
                    $this->add_logic($jeudi,16);
                    break;
                case 26 :
                    $this->add_logic($vendredi,16);
                    break;
                case 27 :
                    $this->add_logic($samedi,16);
                    break;
                case 28 :
                    $this->add_logic($dimanche,16);
                    break;
                case 29 :
                    $this->add_logic($lundi,18);
                    break;
                case 30 :
                    $this->add_logic($mardi,18);
                    break;
                case 31 :
                    $this->add_logic($mercredi,18);
                    break;
                case 32 :
                    $this->add_logic($jeudi,18);
                    break;
                case 33 :
                    $this->add_logic($vendredi,18);
                    break;
                case 34 :
                    $this->add_logic($samedi,18);
                    break;
                case 35 :
                    $this->add_logic($dimanche,18);
                    break;
                case 36 :
                    $this->add_logic($lundi,20);
                    break;
                case 37 :
                    $this->add_logic($mardi,20);
                    break;
                case 38 :
                    $this->add_logic($mercredi,20);
                    break;
                case 39:
                    $this->add_logic($jeudi,20);
                    break;
                case 40 :
                    $this->add_logic($vendredi,20);
                    break;
                case 41 :
                    $this->add_logic($samedi,20);
                    break;
                case 42 :
                    $this->add_logic($dimanche,20);
                    break;
                case 43 :
                    $this->add_logic($lundi,22);
                    break;
                case 44 :
                    $this->add_logic($mardi,22);
                    break;
                case 45 :
                    $this->add_logic($mercredi,22);
                    break;
                case 46 :
                    $this->add_logic($jeudi,22);
                    break;
                case 47 :
                    $this->add_logic($vendredi,22);
                    break;
                case 48 :
                    $this->add_logic($samedi,22);
                    break;
                case 49 :
                    $this->add_logic($dimanche,22);
                    break;
            }
        }
    }

    /** ANNULATION PROPREMENT DITE :
     *
     *ON RECUPERE UN TABLEAU D'HEURES A ANNULLER PUI ON UTLISE LA LOGIQUE
     * PRECEDEMENT ENONCEE POUR PROCEDER A L'ANNULATION DES DITES HEURES
     */
    public function throw($todletes)
    {
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $this->semaine)->isoWeekday(1)->day ;
        $mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4;$samedi=$lundi+5;$dimanche=$lundi+6;
        foreach ($todletes as $d)
        {
            switch ($d) {
                case 1 :
                    $this->throw_logic($lundi,10);
                    break;
                case 2 :
                    $this->throw_logic($mardi,10);
                    break;
                case 3 :
                    $this->throw_logic($mercredi,10);
                    break;
                case 4 :
                    $this->throw_logic($jeudi,10);
                    break;
                case 5 :
                    $this->throw_logic($vendredi,10);
                    break;
                case 6 :
                    $this->throw_logic($samedi,10);
                    break;
                case 7 :
                    $this->throw_logic($dimanche,10);
                    break;
                case 8 :
                    $this->throw_logic($lundi,12);
                    break;
                case 9 :
                    $this->throw_logic($mardi,12);
                    break;
                case  10:
                    $this->throw_logic($mercredi,12);
                    break;
                case 11 :
                    $this->throw_logic($jeudi,12);
                    break;
                case 12 :
                    $this->throw_logic($vendredi,12);
                    break;
                case 13 :
                    $this->throw_logic($samedi,12);
                    break;
                case 14 :
                    $this->throw_logic($dimanche,12);
                    break;
                case 15 :
                    $this->throw_logic($lundi,14);
                    break;
                case 16 :
                    $this->throw_logic($mardi,14);
                    break;
                case 17 :
                    $this->throw_logic($mercredi,14);
                    break;
                case 18 :
                    $this->throw_logic($jeudi,14);
                    break;
                case 19 :
                    $this->throw_logic($vendredi,14);
                    break;
                case 20 :
                    $this->throw_logic($samedi,14);
                    break;
                case 21 :
                    $this->throw_logic($dimanche,14);
                    break;
                case 22 :
                    $this->throw_logic($lundi,16);
                    break;
                case 23 :
                    $this->throw_logic($mardi,16);
                    break;
                case 24 :
                    $this->throw_logic($mercredi,16);
                    break;
                case  25:
                    $this->throw_logic($jeudi,16);
                    break;
                case 26 :
                    $this->throw_logic($vendredi,16);
                    break;
                case 27 :
                    $this->throw_logic($samedi,16);
                    break;
                case 28 :
                    $this->throw_logic($dimanche,16);
                    break;
                case 29 :
                    $this->throw_logic($lundi,18);
                    break;
                case 30 :
                    $this->throw_logic($mardi,18);
                    break;
                case 31 :
                    $this->throw_logic($mercredi,18);
                    break;
                case 32 :
                    $this->throw_logic($jeudi,18);
                    break;
                case 33 :
                    $this->throw_logic($vendredi,18);
                    break;
                case 34 :
                    $this->throw_logic($samedi,18);
                    break;
                case 35 :
                    $this->throw_logic($dimanche,18);
                    break;
                case 36 :
                    $this->throw_logic($lundi,20);
                    break;
                case 37 :
                    $this->throw_logic($mardi,20);
                    break;
                case 38 :
                    $this->throw_logic($mercredi,20);
                    break;
                case 39:
                    $this->throw_logic($jeudi,20);
                    break;
                case 40 :
                    $this->throw_logic($vendredi,20);
                    break;
                case 41 :
                    $this->throw_logic($samedi,20);
                    break;
                case 42 :
                    $this->throw_logic($dimanche,20);
                    break;
                case 43 :
                    $this->throw_logic($lundi,22);
                    break;
                case 44 :
                    $this->throw_logic($mardi,22);
                    break;
                case 45 :
                    $this->throw_logic($mercredi,22);
                    break;
                case 46 :
                    $this->throw_logic($jeudi,22);
                    break;
                case 47 :
                    $this->throw_logic($vendredi,22);
                    break;
                case 48 :
                    $this->throw_logic($samedi,22);
                    break;
                case 49 :
                    $this->throw_logic($dimanche,22);
                    break;
            }
        }
    }




    /** FONCTION DETERMINANT LES HEURES RESERVABLES EN FONCTION DE LA LOGIQUE PRECEDMENT ENONCEE */
    public  function BookableHourSet(){
        $this->student = \auth()->user();
        $this->class = Classe::find($this->student->classe_id);
        if(!$this->class->c_d_s){
            $ids = [36,37,38,39,40,41,48,7,14,21,28,35,42,49,6,13,20,27,34];
            foreach ($ids as $id){
                $this->BookableHour[] = $id;
            }

        }elseif ($this->class->c_d_s){
            $ids = [1,2,3,4,5,8,9,10,11,12,15,16,17,18,19,22,23,24,25,26,29,30,31,32,33,41,48,7,14,21,28,35,42,49] ;
            foreach ($ids as $id){
                $this->BookableHour[] = $id;
            }
        }
        //retirer les heures supprimees par l'administration
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $this->semaine)->isoWeekday(1)->day ;
        $mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4;$samedi=$lundi+5;$dimanche=$lundi+6;
        foreach ($this->BookableHour as $h){
            switch ($h){
                case 1 :
                    $this->BookableHourSet_logic($lundi,10,1);
                    break;
                case 2 :
                    $this->BookableHourSet_logic($mardi,10,2);
                    break;
                case 3 :
                    $this->BookableHourSet_logic($mercredi,10,3);
                    break;
                case 4 :
                    $this->BookableHourSet_logic($jeudi,10,4);
                    break;
                case 5 :
                    $this->BookableHourSet_logic($vendredi,10,5);
                    break;
                case 6 :
                    $this->BookableHourSet_logic($samedi,10,6);
                    break;
                case 7 :
                    $this->BookableHourSet_logic($dimanche,10,7);
                    break;
                case 8 :
                    $this->BookableHourSet_logic($lundi,12,8);
                    break;
                case 9 :
                    $this->BookableHourSet_logic($mardi,12,9);
                    break;
                case  10:
                    $this->BookableHourSet_logic($mercredi,12,10);
                    break;
                case 11 :
                    $this->BookableHourSet_logic($jeudi,12,11);
                    break;
                case 12 :
                    $this->BookableHourSet_logic($vendredi,12,12);
                    break;
                case 13 :
                    $this->BookableHourSet_logic($samedi,12,13);
                    break;
                case 14 :
                    $this->BookableHourSet_logic($dimanche,12,14);
                    break;
                case 15 :
                    $this->BookableHourSet_logic($lundi,14,15);
                    break;
                case 16 :
                    $this->BookableHourSet_logic($mardi,14,16);
                    break;
                case 17 :
                    $this->BookableHourSet_logic($mercredi,14,17);
                    break;
                case 18 :
                    $this->BookableHourSet_logic($jeudi,14,18);
                    break;
                case 19 :
                    $this->BookableHourSet_logic($vendredi,14,19);
                    break;
                case 20 :
                    $this->BookableHourSet_logic($samedi,14,20);
                    break;
                case 21 :
                    $this->BookableHourSet_logic($dimanche,14,21);
                    break;
                case 22 :
                    $this->BookableHourSet_logic($lundi,16,22);
                    break;
                case 23 :
                    $this->BookableHourSet_logic($mardi,16,23);
                    break;
                case 24 :
                    $this->BookableHourSet_logic($mercredi,16,24);
                    break;
                case  25:
                    $this->BookableHourSet_logic($jeudi,16,25);
                    break;
                case 26 :
                    $this->BookableHourSet_logic($vendredi,16,26);
                    break;
                case 27 :
                    $this->BookableHourSet_logic($samedi,16,27);
                    break;
                case 28 :
                    $this->BookableHourSet_logic($dimanche,16,28);
                    break;
                case 29 :
                    $this->BookableHourSet_logic($lundi,18,29);
                    break;
                case 30 :
                    $this->BookableHourSet_logic($mardi,18,30);
                    break;
                case 31 :
                    $this->BookableHourSet_logic($mercredi,18,31);
                    break;
                case 32 :
                    $this->BookableHourSet_logic($jeudi,18,32);
                    break;
                case 33 :
                    $this->BookableHourSet_logic($vendredi,18,33);
                    break;
                case 34 :
                    $this->BookableHourSet_logic($samedi,18,34);
                    break;
                case 35 :
                    $this->BookableHourSet_logic($dimanche,18,35);
                    break;
                case 36 :
                    $this->BookableHourSet_logic($lundi,20,36);
                    break;
                case 37 :
                    $this->BookableHourSet_logic($mardi,20,37);
                    break;
                case 38 :
                    $this->BookableHourSet_logic($mercredi,20,38);
                    break;
                case 39:
                    $this->BookableHourSet_logic($jeudi,20,39);
                    break;
                case 40 :
                    $this->BookableHourSet_logic($vendredi,20,40);
                    break;
                case 41 :
                    $this->BookableHourSet_logic($samedi,20,41);
                    break;
                case 42 :
                    $this->BookableHourSet_logic($dimanche,20,42);
                    break;
                case 43 :
                    $this->BookableHourSet_logic($lundi,22,43);
                    break;
                case 44 :
                    $this->BookableHourSet_logic($mardi,22,44);
                    break;
                case 45 :
                    $this->BookableHourSet_logic($mercredi,22,45);
                    break;
                case 46 :
                    $this->BookableHourSet_logic($jeudi,22,46);
                    break;
                case 47 :
                    $this->BookableHourSet_logic($vendredi,22,47);
                    break;
                case 48 :
                    $this->BookableHourSet_logic($samedi,22,48);
                    break;
                case 49 :
                    $this->BookableHourSet_logic($dimanche,22,49);
                    break;
            }
        }
    }

    /** FONCTION RECUPREANT LES HEURE DEJA RESERVEES */
    public function BookedHourSet()
    {
        $this->student = \auth()->user();
        $s = $this->student;
        $books = DB::table('hour_slot_student')
            ->join('hour_slots', 'hour_slot_student.hour_slot_id', '=', 'hour_slots.id')
            ->where('hour_slot_student.student_id', $s->id)
            ->where('hour_slot_student.annulation','=',false)
            ->where('hour_slots.semaine',$this->semaine)
            ->where('hour_slots.classe_id',$this->student->classe_id)
            ->select( 'hour_slots.debut','hour_slots.d_o_w')
            ->get();

        foreach ($books as $book){
            if($book->d_o_w == 'lundi' && $book->debut == 8){
                $this->BookedHour[]= 1;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 10){
                $this->BookedHour[]= 8;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 12){
                $this->BookedHour[]= 15;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 14){
                $this->BookedHour[] =22;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 16){
                $this->BookedHour[]= 29;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 18){
                $this->BookedHour[]= 36;
            }elseif ($book->d_o_w == 'lundi' && $book->debut == 20){
                $this->BookedHour[]= 43;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 8){
                $this->BookedHour[]= 2;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 10){
                $this->BookedHour[]= 9;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 12){
                $this->BookedHour[]= 16;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 14){
                $this->BookedHour[]= 23;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 16){
                $this->BookedHour[]= 30;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 18){
                $this->BookedHour[]= 37;
            }elseif ($book->d_o_w == 'mardi' && $book->debut == 20){
                $this->BookedHour[]= 44;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 8){
                $this->BookedHour[]= 3;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 10){
                $this->BookedHour[]= 10;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 12){
                $this->BookedHour[]= 17;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 14){
                $this->BookedHour[]= 24;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 16){
                $this->BookedHour[]= 31;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 18){
                $this->BookedHour[]= 38;
            }elseif ($book->d_o_w == 'mercredi' && $book->debut == 20){
                $this->BookedHour[]= 44;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 8){
                $this->BookedHour[]= 4;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 10){
                $this->BookedHour[]= 11;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 12){
                $this->BookedHour[]= 18;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 14){
                $this->BookedHour[]= 25;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 16){
                $this->BookedHour[]= 32;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 18){
                $this->BookedHour[]= 39;
            }elseif ($book->d_o_w == 'jeudi' && $book->debut == 20){
                $this->BookedHour[]= 46;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 8){
                $this->BookedHour[]= 5;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 10){
                $this->BookedHour[]= 12;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 12){
                $this->BookedHour[]= 19;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 14){
                $this->BookedHour[]= 26;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 16){
                $this->BookedHour[]= 33;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 18){
                $this->BookedHour[]= 40;
            }elseif ($book->d_o_w == 'vendredi' && $book->debut == 20){
                $this->BookedHour[]= 47;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 8){
                $this->BookedHour[]= 6;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 10){
                $this->BookedHour[]= 13;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 12){
                $this->BookedHour[] = 20;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 14){
                $this->BookedHour[] = 27;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 16){
                $this->BookedHour[]= 34;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 18){
                $this->BookedHour[]= 41;
            }elseif ($book->d_o_w == 'samedi' && $book->debut == 20){
                $this->BookedHour[]= 48;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 8){
                $this->BookedHour[] = 7;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 10){
                $this->BookedHour[] = 14;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 12){
                $this->BookedHour[] = 21;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 14){
                $this->BookedHour[] = 28;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 16){
                $this->BookedHour[]= 35;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 18){
                $this->BookedHour[]= 42;
            }elseif ($book->d_o_w == 'dimanche' && $book->debut == 20){
                $this->BookedHour[] = 49;
            }
        }

    }

    /** FONCTION VERIFIANT SI UNE SEANCE ET FULL */
    public function is_full($id){
        $query = DB::table('hour_slot_student');
        $n = $query->where([
            'hour_slot_id'=> $id
        ])->count();
        if ($n <= $this->limit){
            return false ;
        }else{
            return true ;
        }
    }

    /** FONCTION RENDANT RESERVABLE UNE SEANCE GRACE A LORSQU'UN TPE EST AJOUTE */
    public function set_free()
    {
        $this->student = \auth()->user();
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        $query = DB::table('free_hours');
        $query->where('classe_id' ,'=',$this->student->classe_id);
        $query->where('semaine','=',$this->semaine);
        $query->where('annee','=', $date->format('Y'));
        $frees = $query->get();



        foreach ($frees as $free){
            if($free->d_o_w == 'lundi' && $free->debut == 8){
                $this->BookableHour[] = 1;
                $this->BookableHour[] = 8;

            }elseif ($free->d_o_w == 'lundi' && $free->debut == 13){
                $this->BookableHour[] = 29;
                $this->BookableHour[] = 22;
                $this->BookableHour[] = 15;
            }elseif ($free->d_o_w == 'lundi' && $free->debut == 18){
                $this->BookableHour[] = 36;
                $this->BookableHour[] = 43;
            }elseif($free->d_o_w == 'mardi' && $free->debut == 8){
                $this->BookableHour[] = 2;
                $this->BookableHour[] = 9;
            }elseif ($free->d_o_w == 'mardi' && $free->debut == 13){
                $this->BookableHour[] = 30;
                $this->BookableHour[] = 23;
                $this->BookableHour[] = 16;
            }elseif ($free->d_o_w == 'mardi' && $free->debut == 18){
                $this->BookableHour[] = 37;
                $this->BookableHour[] = 44;
            }elseif($free->d_o_w == 'mercredi' && $free->debut == 8){
                $this->BookableHour[] = 3;
                $this->BookableHour[] = 10;
            }elseif ($free->d_o_w == 'mercredi' && $free->debut == 13){
                $this->BookableHour[] = 31;
                $this->BookableHour[] = 24;
                $this->BookableHour[] = 17;
            }elseif ($free->d_o_w == 'mercredi' && $free->debut == 18){
                $this->BookableHour[] = 38;
                $this->BookableHour[] = 45;
            }elseif($free->d_o_w == 'jeudi' && $free->debut == 8){
                $this->BookableHour[] = 4;
                $this->BookableHour[] = 11;
            }elseif ($free->d_o_w == 'jeudi' && $free->debut == 13){
                $this->BookableHour[] = 32;
                $this->BookableHour[] = 25;
                $this->BookableHour[] = 18;
            }elseif ($free->d_o_w == 'jeudi' && $free->debut == 18){
                $this->BookableHour[] = 39;
                $this->BookableHour[] = 46;
            }elseif($free->d_o_w == 'vendredi' && $free->debut == 8){
                $this->BookableHour[] = 5;
                $this->BookableHour[] = 12;
            }elseif ($free->d_o_w == 'vendredi' && $free->debut == 13){
                $this->BookableHour[] = 33;
                $this->BookableHour[] = 26;
                $this->BookableHour[] = 19;
            }elseif ($free->d_o_w == 'vendredi' && $free->debut == 18){
                $this->BookableHour[] = 40;
                $this->BookableHour[] = 47;
            }elseif($free->d_o_w == 'samedi' && $free->debut == 8){
                $this->BookableHour[] = 6;
                $this->BookableHour[] = 13;
            }elseif ($free->d_o_w == 'samedi' && $free->debut == 13){
                $this->BookableHour[] = 34;
                $this->BookableHour[] = 27;
                $this->BookableHour[] = 20;
            }
        }
    }
}

