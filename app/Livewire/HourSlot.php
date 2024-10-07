<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Ecole;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HourSlot extends Component
{
    public $admin;
    public array |string $classes ;
    public array |string $weeks ;
    public  $classe ;//id de la classe selectionnee
    public $class ; // objet de la classe selectionnee
    public $semaine ;
    public array $slots;
    public $jours ;
    public string $id;
    public $HeureLibreEditable ;
    public array $selection;
    public $to_add = [];
    public $to_delete =[];
    public  $freehours ;
    //protected $listeners = ['weekUpdated','classUpdated'];

    public function mount()
    {
        $this->admin =  $this->admin[0] == null ? $this->admin : $this->admin[0];
        $this->classes = (new Ecole())->classes_by_admin_ecole($this->admin->id)->toArray();
        $this->weeks = [Carbon::now()->weekOfYear , Carbon::now()->weekOfYear +1 ];
        $this->semaine = Carbon::now()->weekOfYear;
        $this->jours = $this->getJoursSemaine($this->semaine);
        $this->classe = $this->classes[0]['id'] ;
        $this->slots = ['','8h a 10h', '10h a 12h' , '12h a 14h', '14h a 16h', '16h a 18h', '18h a 20h', '20h a 22h'];
        $this->id = 1;
        $this->to_add = [];
        $this->to_delete = [];
    }

    public function render()
    {
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        $this->HeureLibreEditable= [];
        // envoi des heures potentiellements preselectionnees a la page pur modification ou ajout
        $query = \App\Models\HourSlot::query();
        $query->where('semaine', $this->semaine);
        $query->where('classe_id', $this->classe);
        $query->where('annee','=',$date->format('Y'));
        $this->freehours = $query->get();

        $this->class =Classe::find($this->classe);


        $i =0 ;

        foreach ($this->freehours as $free_hour){
            if($free_hour->delete == false && $free_hour->d_o_w=='lundi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =1 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =8 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =15 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =22 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =29 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =36 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'lundi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =43 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =2 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =9 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =16 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =23 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =30 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =37 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'mardi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =44 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =3 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =10 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =17 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =24 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =31 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =38 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'mercredi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =45 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =4 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =11 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =18 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =25 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =32 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =39 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'jeudi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =46 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =5 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =12 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =19 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =26 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =33 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =40 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'vendredi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =47 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =6 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =13 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =20 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =27 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =34 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =41 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'samedi' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =48 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =7 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==10){
                $this->HeureLibreEditable[$i] =14 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==12){
                $this->HeureLibreEditable[$i] =21 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==14){
                $this->HeureLibreEditable[$i] =28 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==16){
                $this->HeureLibreEditable[$i] =35 ;
            }elseif($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =42 ;
            }elseif ($free_hour->delete == false && $free_hour->d_o_w == 'dimanche' && $free_hour->debut==20){
                $this->HeureLibreEditable[$i] =49 ;
            }
            $i++;
        }
        return view('livewire.hour-slot',[
            'freehours'=>$this->freehours,
            'classes'=>$this->classes,
            'weeks'=>$this->weeks,
            'jours'=>$this->jours,
            'class'=>$this->class,
            'semaine'=>$this->semaine,
            'slots'=>$this->slots,
            'id'=>$this->id,
            'admin'=>$this->admin,
            'HeureLibreEditable'=>$this->HeureLibreEditable,
            'to_add'=>$this->to_add = [],
            'to_delete'=>$this->to_delete =[],
        ]);
    }

    /** PERMET A L'UTILISATEUR DE SELECTIONNER SUR QUELLE CLASSE IL EFFECTUE CES OPPERATIONS  */

    public function setClass($class)
    {
        $this->classe = $class;
        $this->to_add = [];
        $this->to_delete = [];
        //$this->dispatch('classUpdated', new Classupdate($this->class));
    }

    /** PERMET A L'UTILISATEUR DE SELECTIONNER SUR QUELLE SEMAINE IL EFFECTUE CES OPPERATIONS  */
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

    /** LOGIQUE D'AJOUT D'UNE SEANCE ET DE REATTRIBUTION DES RESERVATIONS ASSOCIEES  */
    public function add_logic($d_o_w,$debut)
    {
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);
        $mois = $date->format('F');
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $this->semaine)->isoWeekday(1)->day ;
        $mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4;$samedi = $lundi+5 ; $dimanche = $lundi+6;
        $jour = ['lundi'=>$lundi , 'mardi'=>$mardi , 'mercredi'=>$mercredi ,'jeudi'=>$jeudi,
            'vendredi' => $vendredi , 'samedi' => $samedi , 'dimanche' => $dimanche];

        // on recherche la seance et on annulle sa supression
        $query = \App\Models\HourSlot::query();
        $query->where('d_o_w','=',$d_o_w);
        $query->where('semaine','=',$this->semaine);
        $query->where('annee','=',$date->format('Y'));
        $query->where('classe_id','=',$this->classe);
        $query->where('debut','=',$debut);
        $query->update(['delete'=>false,'admin_id'=>$this->admin->id]);

        $campus = DB::table('campuses')
                ->join('ecoles','campuses.id','=','ecoles.campus_id')
                ->join('admins','admins.ecole_id','=','ecoles.id')
                ->where('admins.id','=',$this->admin->id)
                ->first('campuses.*');

        //si elle n'existe pas on la cree
        if ($query->update(['delete'=>false]) == 0 ){
            \App\Models\HourSlot::create([
                'date'=> $date->format('Y').'-'.$date->format('m').'-'.$jour[$d_o_w],
                'd_o_w'=> $d_o_w  ,
                'jour'=> $jour[$d_o_w] ,
                'semaine'=> $this->semaine,
                'mois'=> $mois,
                'annee'=> $date->format('Y') ,
                'debut'=> $debut,
                'fin' => $debut+2 ,
                'classe_id'=> $this->classe,
                'ecole'=>$this->admin->ecole ,
                'delete'=>false,
                'full'=>false,
                'campus_id' => $campus->id ,
                'admin_id'=>$this->admin->id
            ]);
        }
        // reatribution des reservation annullees lors de la supression posterieures de la seance
        $Id = $query->get('id');
        DB::table('hour_slot_student')
            ->where('hour_slot_id','=', $Id[0]->id)
            ->update(['annulation' => false]);
        /*if ($firstIteration) {
                $user = Student::find($student);
                $book = \App\Models\HourSlot::find($book);
                $user->notify(new GetOutWaitListNotification($book));

                $firstIteration = false;
            }*/
    }

    /** LOGIQUE DE SUPRESSION D'UNE SEANCE ET D'ANNULATION DES RESERVATIONS ASSOCIEES */
    public function throw_logic($d_o_w,$debut)
    {
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);
        $query = \App\Models\HourSlot::query();
        $query->where('d_o_w','=',$d_o_w);
        $query->where('semaine','=',$this->semaine);
        $query->where('annee','=',$date->format('Y'));
        $query->where('classe_id','=',$this->classe);
        $query->where('debut','=',$debut);
        $query->update(['delete'=>true,'admin_id'=>$this->admin->id]);
        //supression soft des reservations a l'heure qui vient d'etre annullee
        $Id = $query->get('id');
        DB::table('hour_slot_student')
            ->where('hour_slot_id','=', $Id[0]->id)
            ->update(['annulation' => true]);

        /*if ($firstIteration) {
                $user = Student::find($student);
                $book = \App\Models\HourSlot::find($book);
                $user->notify(new GetOutWaitListNotification($book));

                $firstIteration = false;
            }*/
    }

    public function add($selectedTimes)
    {
        foreach ($selectedTimes as $data){
            switch ($data)
            {
                case 1:
                    $this->add_logic('lundi',8);
                    break;
                case 2:
                    $this->add_logic('mardi',8);
                    break;
                case 3:
                    $this->add_logic('mercredi',8);
                    break;
                case 4:
                    $this->add_logic('jeudi',8);
                    break;
                case 5:
                    $this->add_logic('vendredi',8);
                    break;
                case 6:
                    $this->add_logic('samedi',8);
                    break;
                case 7:
                    $this->add_logic('dimanche',8);
                    break;
                case 8:
                    $this->add_logic('lundi',10);
                    break;
                case 9:
                    $this->add_logic('mardi',10);
                    break;
                case 10:
                    $this->add_logic('mercredi',10);
                    break;
                case 11:
                    $this->add_logic('jeudi',10);
                    break;
                case 12:
                    $this->add_logic('vendredi',10);
                    break;
                case 13:
                    $this->add_logic('samedi',10);
                    break;
                case 14:
                    $this->add_logic('dimanche',10);
                    break;
                case 15:
                    $this->add_logic('lundi',12);
                    break;
                case 16:
                    $this->add_logic('mardi',12);
                    break;
                case 17:
                    $this->add_logic('mercredi',12);
                    break;
                case 18:
                    $this->add_logic('jeudi',12);
                    break;
                case 19:
                    $this->add_logic('vendredi',12);
                    break;
                case 20:
                    $this->add_logic('samedi',12);
                    break;
                case 21:
                    $this->add_logic('dimanche',12);
                    break;
                case 22:
                    $this->add_logic('lundi',14);
                    break;
                case 23:
                    $this->add_logic('mardi',14);
                    break;
                case 24:
                    $this->add_logic('mercredi',14);
                    break;
                case 25:
                    $this->add_logic('jeudi',14);
                    break;
                case 26:
                    $this->add_logic('vendredi',14);
                    break;

                case 27:
                    $this->add_logic('samedi',14);
                    break;

                case 28:
                    $this->add_logic('dimanche',14);
                    break;
                case 29:
                    $this->add_logic('lundi',16);
                    break;
                case 30:
                    $this->add_logic('mardi',16);
                    break;
                case 31:
                    $this->add_logic('mercredi',16);
                    break;
                case 32:
                    $this->add_logic('jeudi',16);
                    break;
                case 33:
                    $this->add_logic('vendredi',16);
                    break;
                case 34:
                    $this->add_logic('samedi',16);
                    break;
                case 35:
                    $this->add_logic('dimanche',16);
                    break;
                case 36:
                    $this->add_logic('lundi',18);
                    break;
                case 37:
                    $this->add_logic('mardi',18);
                    break;
                case 38:
                    $this->add_logic('mercredi',18);
                    break;
                case 39:
                    $this->add_logic('jeudi',18);
                    break;
                case 40:
                    $this->add_logic('vendredi',18);
                    break;
                case 41:
                    $this->add_logic('samedi',18);
                    break;
                case 42:
                    $this->add_logic('dimanche',18);
                    break;
                case 43:
                    $this->add_logic('lundi',20);
                    break;
                case 44:
                    $this->add_logic('mardi',20);
                    break;
                case 45:
                    $this->add_logic('mercredi',20);
                    break;
                case 46:
                    $this->add_logic('jeudi',20);
                    break;
                case 47:
                    $this->add_logic('vendredi',20);
                    break;
                case 48:
                    $this->add_logic('samedi',20);
                    break;
                case 49:
                    $this->add_logic('dimanche',20);
                    break;
            }
        }
    }

    public function throw($todletes)
    {
        foreach ($todletes as $d)
        {
            switch ($d)
            {
                case 1:
                    $this->throw_logic('lundi',8);
                    break;
                case 2:
                    $this->throw_logic('mardi',8);
                    break;
                case 3:
                    $this->throw_logic('mercredi',8);
                    break;
                case 4:
                    $this->throw_logic('jeudi',8);
                    break;
                case 5:
                    $this->throw_logic('vendredi',8);
                    break;
                case 6:
                    $this->throw_logic('samedi',8);
                    break;
                case 7:
                    $this->throw_logic('dimanche',8);
                    break;
                case 8:
                    $this->throw_logic('lundi',10);
                    break;
                case 9:
                    $this->throw_logic('mardi',10);
                    break;
                case 10:
                    $this->throw_logic('mercredi',10);
                    break;
                case 11:
                    $this->throw_logic('jeudi',10);
                    break;
                case 12:
                    $this->throw_logic('vendredi',10);
                    break;
                case 13:
                    $this->throw_logic('samedi',10);
                    break;
                case 14:
                    $this->throw_logic('dimanche',10);
                    break;
                case 15:
                    $this->throw_logic('lundi',12);
                    break;
                case 16:
                    $this->throw_logic('mardi',12);
                    break;
                case 17:
                    $this->throw_logic('mercredi',12);
                    break;
                case 18:
                    $this->throw_logic('jeudi',12);
                    break;
                case 19:
                    $this->throw_logic('vendredi',12);
                    break;
                case 20:
                    $this->throw_logic('samedi',12);
                    break;
                case 21:
                    $this->throw_logic('dimanche',12);
                    break;
                case 22:
                    $this->throw_logic('lundi',14);
                    break;
                case 23:
                    $this->throw_logic('mardi',14);
                    break;
                case 24:
                    $this->throw_logic('mercredi',14);
                    break;
                case 25:
                    $this->throw_logic('jeudi',14);
                    break;
                case 26:
                    $this->throw_logic('vendredi',14);
                    break;

                case 27:
                    $this->throw_logic('samedi',14);
                    break;

                case 28:
                    $this->throw_logic('dimanche',1);
                    break;
                case 29:
                    $this->throw_logic('lundi',16);
                    break;
                case 30:
                    $this->throw_logic('mardi',16);
                    break;
                case 31:
                    $this->throw_logic('mercredi',16);
                    break;
                case 32:
                    $this->throw_logic('jeudi',16);
                    break;
                case 33:
                    $this->throw_logic('vendredi',16);
                    break;
                case 34:
                    $this->throw_logic('samedi',16);
                    break;
                case 35:
                    $this->throw_logic('dimanche',16);
                    break;
                case 36:
                    $this->throw_logic('lundi',18);
                    break;
                case 37:
                    $this->throw_logic('mardi',18);
                    break;
                case 38:
                    $this->throw_logic('mercredi',18);
                    break;
                case 39:
                    $this->throw_logic('jeudi',18);
                    break;
                case 40:
                    $this->throw_logic('vendredi',18);
                    break;
                case 41:
                    $this->throw_logic('samedi',18);
                    break;
                case 42:
                    $this->throw_logic('dimanche',18);
                    break;
                case 43:
                    $this->throw_logic('lundi',20);
                    break;
                case 44:
                    $this->throw_logic('mardi',20);
                    break;
                case 45:
                    $this->throw_logic('mercredi',20);
                    break;
                case 46:
                    $this->throw_logic('jeudi',20);
                    break;
                case 47:
                    $this->throw_logic('vendredi',20);
                    break;
                case 48:
                    $this->throw_logic('samedi',20);
                    break;
                case 49:
                    $this->throw_logic('dimanche',20);
                    break;
            }
        }
    }


    /** EXECUTION DES FONCTIONS D'ADDITION ET SUPPRESSION LORS DE LA SOUMISSION DES VALEURS SELECTIONNEES */
    public function exec($toAdd,$toThrow)
    {

        //$toAdd = Json::encode($toAdd);
        //$toThrow = Json::encode($toThrow);
        $this->add($toAdd);
        $this->throw($toThrow);
        $this->to_add = [];
        $this->to_delete = [];
        $this->render();

    }
}
