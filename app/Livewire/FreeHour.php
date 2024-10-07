<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Ecole;
use App\Models\Student;
use App\Notifications\GetOutWaitListNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
class FreeHour extends Component
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
    public $free_hours;
    public $HeureLibreEditable ;
    public array $selection;
    public array $to_add ;
    public array $to_delete ;
    public  $freehours ;
    public $CoursDuSoir ;
    //protected $listeners = ['weekUpdated','classUpdated'];


    public function mount()
    {
        $this->admin = $this->admin[0] == null ? $this->admin : $this->admin[0];
        $this->classes = (new Ecole())->classes_by_admin_ecole($this->admin->id)->toArray();
        $this->weeks = [Carbon::now()->weekOfYear , Carbon::now()->weekOfYear +1 ];
        $this->semaine = Carbon::now()->weekOfYear;
        $this->jours = $this->getJoursSemaine($this->semaine);
        $this->classe =$this->classes[0]['id'];
        $this->slots = ['','8h30 a 12h30', '13h30 a 17h30'];
        $this->id = 1;
        $this->to_add = [];
        $this->to_delete = [];
    }

    public function render()
    {

        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);
        $this->class =Classe::find($this->classe);


        $this->HeureLibreEditable= [];
        // envoi des heures potentiellements preselectionnees a la page pur modification ou ajout
        $query = \App\Models\FreeHour::query();
        $query->where('semaine', $this->semaine);
        $query->where('classe_id', $this->classe);
        $query->where('annee','=',$date->format('Y'));
        $this->freehours = $query->get();
        $this->CoursDuSoir = $this->class->c_d_s;


        $i =0 ;

        foreach ($this->freehours as $free_hour){
            if($free_hour->d_o_w=='lundi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =1 ;
            }elseif ($free_hour->d_o_w == 'lundi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =6 ;
            }elseif($free_hour->d_o_w == 'mardi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =2 ;
            }elseif ($free_hour->d_o_w == 'mardi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =7 ;
            }elseif ($free_hour->d_o_w == 'mercredi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =3 ;
            }elseif ($free_hour->d_o_w == 'mercredi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =8 ;
            }elseif($free_hour->d_o_w == 'jeudi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =4 ;
            }elseif ($free_hour->d_o_w == 'jeudi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =9 ;
            }elseif ($free_hour->d_o_w == 'vendredi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =5 ;
            }elseif($free_hour->d_o_w == 'vendredi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =10 ;
            }elseif($free_hour->d_o_w == 'lundi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =11 ;
            }elseif ($free_hour->d_o_w == 'mardi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =12 ;
            }elseif ($free_hour->d_o_w == 'mercredi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =13 ;
            }elseif ($free_hour->d_o_w == 'jeudi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =14 ;
            }elseif($free_hour->d_o_w == 'vendredi' && $free_hour->debut==18){
                $this->HeureLibreEditable[$i] =15 ;
            }elseif ($free_hour->d_o_w == 'samedi' && $free_hour->debut==8){
                $this->HeureLibreEditable[$i] =16 ;
            }elseif ($free_hour->d_o_w == 'samedi' && $free_hour->debut==13){
                $this->HeureLibreEditable[$i] =17 ;
            }
            $i++;
        }
        return view('livewire.free-hour',[
            'CDS'=>$this->CoursDuSoir,
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





    /** LOGIQUE D'ADDITION DE TPE AVEC REATRIBUTION DES RESERVATIONS DES ANNULLEE LORS D'UNE POTENTIELLE PRECEDENTE ANNULATION DU TPE */
    public function add_logic($d_o_w,$jour, $debut , $fin , $debut_1 , $debut_2 , $debut_3 = null){
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);
        $mois = $date->format('F');
        \App\Models\FreeHour::create([
            'date'=> $date->format('Y').'-'.$date->format('m').'-'.$jour,
            'd_o_w'=> $d_o_w  ,
            'jour'=> $jour ,
            'semaine'=> $this->semaine,
            'mois'=> $mois,
            'annee'=> $date->format('Y') ,
            'debut'=> $debut,
            'fin' => $fin ,
            'classe_id'=> $this->classe,
            'delete'=>false,
            'admin_id'=>$this->admin->id,
        ]);
        //restitution des reservations precedement suprimees lors de la supression e ce tpe
        $event = \App\Models\HourSlot::query();
        $event->where('d_o_w', '=', $d_o_w);
        $event->where('semaine', '=', $this->semaine);
        $event->where('annee', '=', $date->format('Y'));
        $event->where('classe_id', '=', $this->classe);
        if($debut_3 !=null){
            $event->where(function ($query) use ( $debut_1 , $debut_2 , $debut_3) {
                $query->where('debut', '=', $debut_1)
                    ->orWhere('debut', '=',$debut_2)
                    ->orWhere('debut', '=',$debut_3);
            });
        }else{
            $event->where(function ($query) use ( $debut_1 , $debut_2 ) {
                $query->where('debut', '=', $debut_1)
                    ->orWhere('debut', '=',$debut_2);
            });
        }
        $event = $event->get();
        foreach ($event as $e){
            DB::table('hour_slot_student')
                ->where('hour_slot_id','=', $e->id)
                ->update(['annulation' => false]);
            /*if ($firstIteration) {
                $user = Student::find($student);
                $book = \App\Models\HourSlot::find($book);
                $user->notify(new GetOutWaitListNotification($book));

                $firstIteration = false;
            }*/
        }

    }

    /** LOGIQUE DE SUPPRESSION DE TPE AVEC ANNULATION DES RESERVATIONS RENDUES POSSIBLE LORS DE L'ATTRIBUTION DU TPE */

    public function throw_logic($d_o_w, $debut , $debut_1 , $debut_2 , $debut_3 = null)
    {
        $date = Carbon::now()->setISODate(Carbon::now()->year, $this->semaine);

        //supression du tpe lui meme

        $query = \App\Models\FreeHour::query();
        $query->where('d_o_w','=',$d_o_w);
        $query->where('semaine','=',$this->semaine);
        $query->where('annee','=',$date->format('Y'));
        $query->where('classe_id','=',$this->classe);
        $query->where('debut','=',$debut);
        $query->delete();

        //supression soft des reservations qui ont ete faites lorsque le tpe a ete accorde
        $event = \App\Models\HourSlot::query();
        $event->where('d_o_w', '=', 'lundi');
        $event->where('semaine', '=', $this->semaine);
        $event->where('annee', '=', $date->format('Y'));
        $event->where('classe_id', '=', $this->classe);

        if($debut_3 !=null){
            $event->where(function ($query) use ( $debut_1 , $debut_2 , $debut_3) {
                $query->where('debut', '=', $debut_1)
                    ->orWhere('debut', '=',$debut_2)
                    ->orWhere('debut', '=',$debut_3);
            });
        }else{
            $event->where(function ($query) use ( $debut_1 , $debut_2 ) {
                $query->where('debut', '=', $debut_1)
                    ->orWhere('debut', '=',$debut_2);
            });
        }
        $event = $event->get();
        foreach ($event as $e){
            DB::table('hour_slot_student')
                ->where('hour_slot_id','=', $e->id)
                ->update(['annulation' => true]);
            /*if ($firstIteration) {
                $user = Student::find($student);
                $book = \App\Models\HourSlot::find($book);
                $user->notify(new GetOutWaitListNotification($book));

                $firstIteration = false;
            }*/
        }
    }

    /** ADDITION PROPREMENT DITE DES TPE SELECTIONNES */
    public function add( array $selectedTimes)
    {
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $this->semaine)->isoWeekday(1)->day ;$mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4; $samedi = $lundi+5 ;

        foreach ($selectedTimes as $data){
            switch ($data)
            {
                case 1 :
                    $this->add_logic('lundi',$lundi,8,10,8,10);
                    break;
                case 2 :
                    $this->add_logic('mardi' ,$mardi,8,10,8,10);
                    break;
                case 3 :
                    $this->add_logic('mercredi',$mercredi,8,10,8,10);
                    break;
                case 4 :
                    $this->add_logic('jeudi',$jeudi,8,10,8,10);
                    break;
                case 5 :
                    $this->add_logic('vendredi',$vendredi,8,10,8,10);
                    break;
                case 6 :
                    $this->add_logic('lundi',$lundi,13,17,12,14,16);
                    break;
                case 7 :
                    $this->add_logic('mardi',$mardi,13,17,12,14,16);
                    break;
                case 8 :
                    $this->add_logic('mercredi',$mercredi,13,17,12,14,16);
                    break;
                case 9 :
                    $this->add_logic('jeudi',$jeudi,13,17,12,14,16);
                    break;
                case 10 :
                    $this->add_logic('vendredi',$vendredi,13,17,12,14,16);
                    break;
                case 11 :
                    $this->add_logic('lundi',$lundi , 18 , 22,18,20);
                    break;
                case 12 :
                    $this->add_logic('mardi',$mardi , 18 , 22,18,20);
                    break;
                case 13 :
                    $this->add_logic('mercredi',$mercredi , 18 , 22,18,20);
                    break;
                case 14 :
                    $this->add_logic('jeudi',$jeudi , 18 , 22,18,20);
                    break;
                case 15 :
                    $this->add_logic('vendredi',$vendredi , 18 , 22,18,20);
                    break;
                case 16 :
                    $this->add_logic('samedi',$samedi , 8 , 12,8,10);
                    break;
                case 17 :
                    $this->add_logic('samedi',$samedi , 13 , 17,12,14,16);
                    break;
            }
        }

    }

    /** SUPPRESSION PROPREMENT DITE DES TPE  */
    public function throw( array $todletes)
    {
        foreach ($todletes as $d)
        {
            switch ($d)
            {
                case 1 :
                    $this->throw_logic('lundi',8,8,10);
                    break;
                case 2 :
                    $this->throw_logic('mardi' ,8,8,10);
                    break;
                case 3 :
                    $this->throw_logic('mercredi',8,8,10);
                    break;
                case 4 :
                    $this->throw_logic('jeudi',8,8,10);
                    break;
                case 5 :
                    $this->throw_logic('vendredi',8,8,10);
                    break;
                case 6 :
                    $this->throw_logic('lundi',13,12,14,16);
                    break;
                case 7 :
                    $this->throw_logic('mardi',13,12,14,16);
                    break;
                case 8 :
                    $this->throw_logic('mercredi',13,12,14,16);
                    break;
                case 9 :
                    $this->throw_logic('jeudi',13,12,14,16);
                    break;
                case 10 :
                    $this->throw_logic('vendredi',13,12,14,16);
                    break;
                case 11 :
                    $this->throw_logic('lundi' , 18 , 18,20);
                    break;
                case 12 :
                    $this->throw_logic('mardi', 18 , 18,20);
                    break;
                case 13 :
                    $this->throw_logic('mercredi' , 18 , 18,20);
                    break;
                case 14 :
                    $this->throw_logic('jeudi', 18 , 18,20);
                    break;
                case 15 :
                    $this->throw_logic('vendredi',18 , 18,20);
                    break;
                case 16 :
                    $this->throw_logic('samedi', 8 ,8,10);
                    break;
                case 17 :
                    $this->throw_logic('samedi', 13 , 12,14,16);
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
        //$this->render();
    }
}
