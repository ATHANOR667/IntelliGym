<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookList extends Component
{
    public $admin ;
    public $weeks;
    public $semaine ;
    public $annee ;
    public $campus_id ;
    public $jours ;
    public $etudiants ;
    public $slots ;
    public $id ;


    public function render()
    {
        return view('livewire.book-list',[
            'etudiants' => $this->etudiants ,
            'jours'=>$this->jours,
            'weeks'=>$this->weeks,
            'slots'=>$this->slots,
            'id'=>$this->id,
        ]);
    }

    public function mount()
    {
        $this->admin = $this->admin[0] == null ? $this->admin : $this->admin[0];
        $this->weeks = [Carbon::now()->weekOfYear , Carbon::now()->weekOfYear +1 ];
        $this->semaine = Carbon::now()->weekOfYear;
        $this->slots = ['','8h a 10h', '10h a 12h' , '12h a 14h', '14h a 16h', '16h a 18h', '18h a 20h', '20h a 22h'];
        $this->id = 1;
        $this->campus_id =  DB::table('campuses')
            ->join('ecoles','campuses.id','=','ecoles.campus_id')
            ->join('admins','admins.ecole_id','=','ecoles.id')
            ->where('admins.id','=',$this->admin->id)
            ->pluck('campuses.id');
        $this->jours = $this->getJoursSemaine($this->semaine);
        $this->etudiants = [];
    }

    /** PERMET A L'UTILISATEUR DE SELECTIONNER SUR QUELLE SEMAINE IL EFFECTUE CES OPPERATIONS  */

    public function setWeek($week)
    {
        $this->semaine = $week;
        $this->jours =$this->getJoursSemaine($week);
    }


    /** PERMET D'AFFICHER "SEMAINE DU ... AU .. POUR LA PLAGE SELECTIONNEE PAR L'UTILISATEUR  */
    public  function getJoursSemaine($numeroSemaine)
    {
        $date = Carbon::now();
        $annee = $date->format('Y');
        $date->setISODate($annee, $numeroSemaine);
        $premierJour = $date->startOfWeek()->format('Y-m-d');
        $dernierJour = $date->endOfWeek()->format('Y-m-d');

        return array($premierJour, $dernierJour);
    }

    public function list_logic($d_o_w , $fin , $id)
    {
        $date = Carbon::now();
        $annee = $date->format('Y');
        $this->etudiants =  DB::table('hour_slot_student')
           ->join('hour_slots', 'hour_slot_student.hour_slot_id', '=', 'hour_slots.id')
           ->join('students','students.id','=','hour_slot_student.student_id')
           ->join('classes','students.classe_id','=','classes.id')
           ->join('ecoles','ecoles.id','=','classes.ecole_id')
           ->where('hour_slots.semaine', $this->semaine)
           ->where('hour_slots.d_o_w', $d_o_w)
           ->where('hour_slots.fin', $fin)
           ->where('hour_slots.annee', $annee)
           ->where('hour_slots.campus_id', $this->campus_id)
           ->where('hour_slot_student.attente',0)
           ->where('hour_slot_student.annulation',0)
           ->distinct('hour_slot_student.student_id')
           ->get(['students.nom','students.prenom','classes.niveau','ecoles.nom as nom_ecole']);

    }

    public function list($h)
    {
            switch ($h){

                case 1 :
                    $this->list_logic('lundi',10,1);
                    break;
                case 2 :
                    $this->list_logic('mardi',10,2);
                    break;
                case 3 :
                    $this->list_logic('mercredi',10,3);
                    break;
                case 4 :
                    $this->list_logic('jeudi',10,4);
                    break;
                case 5 :
                    $this->list_logic('vendredi',10,5);
                    break;
                case 6 :
                    $this->list_logic('samedi',10,6);
                    break;
                case 7 :
                    $this->list_logic('dimanche',10,7);
                    break;
                case 8 :
                    $this->list_logic('lundi',12,8);
                    break;
                case 9 :
                    $this->list_logic('mardi',12,9);
                    break;
                case  10:
                    $this->list_logic('mercredi',12,10);
                    break;
                case 11 :
                    $this->list_logic('jeudi',12,11);
                    break;
                case 12 :
                    $this->list_logic('vendredi',12,12);
                    break;
                case 13 :
                    $this->list_logic('samedi',12,13);
                    break;
                case 14 :
                    $this->list_logic('dimanche',12,14);
                    break;
                case 15 :
                    $this->list_logic('lundi',14,15);
                    break;
                case 16 :
                    $this->list_logic('mardi',14,16);
                    break;
                case 17 :
                    $this->list_logic('mercredi',14,17);
                    break;
                case 18 :
                    $this->list_logic('jeudi',14,18);
                    break;
                case 19 :
                    $this->list_logic('vendredi',14,19);
                    break;
                case 20 :
                    $this->list_logic('samedi',14,20);
                    break;
                case 21 :
                    $this->list_logic('dimanche',14,21);
                    break;
                case 22 :
                    $this->list_logic('lundi',16,22);
                    break;
                case 23 :
                    $this->list_logic('mardi',16,23);
                    break;
                case 24 :
                    $this->list_logic('mercredi',16,24);
                    break;
                case  25:
                    $this->list_logic('jeudi',16,25);
                    break;
                case 26 :
                    $this->list_logic('vendredi',16,26);
                    break;
                case 27 :
                    $this->list_logic('samedi',16,27);
                    break;
                case 28 :
                    $this->list_logic('dimanche',16,28);
                    break;
                case 29 :
                    $this->list_logic('lundi',18,29);
                    break;
                case 30 :
                    $this->list_logic('mardi',18,30);
                    break;
                case 31 :
                    $this->list_logic('mercredi',18,31);
                    break;
                case 32 :
                    $this->list_logic('jeudi',18,32);
                    break;
                case 33 :
                    $this->list_logic('vendredi',18,33);
                    break;
                case 34 :
                    $this->list_logic('samedi',18,34);
                    break;
                case 35 :
                    $this->list_logic('dimanche',18,35);
                    break;
                case 36 :
                    $this->list_logic('lundi',20,36);
                    break;
                case 37 :
                    $this->list_logic('mardi',20,37);
                    break;
                case 38 :
                    $this->list_logic('mercredi',20,38);
                    break;
                case 39:
                    $this->list_logic('jeudi',20,39);
                    break;
                case 40 :
                    $this->list_logic('vendredi',20,40);
                    break;
                case 41 :
                    $this->list_logic('samedi',20,41);
                    break;
                case 42 :
                    $this->list_logic('dimanche',20,42);
                    break;
                case 43 :
                    $this->list_logic('lundi',22,43);
                    break;
                case 44 :
                    $this->list_logic('mardi',22,44);
                    break;
                case 45 :
                    $this->list_logic('mercredi',22,45);
                    break;
                case 46 :
                    $this->list_logic('jeudi',22,46);
                    break;
                case 47 :
                    $this->list_logic('vendredi',22,47);
                    break;
                case 48 :
                    $this->list_logic('samedi',22,48);
                    break;
                case 49 :
                    $this->list_logic('dimanche',22,49);
                    break;
            }

    }
}
