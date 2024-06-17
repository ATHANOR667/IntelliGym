<?php

namespace App\Livewire;

use App\Events\Classupdate;
use App\Events\Weekupdate;
use Carbon\Carbon;
use Livewire\Component;

class SelectClassAndWeek extends Component
{
    public $admin ;
    public array |string $classes ;
    public array |string $weeks ;
    public $classe;
    public $semaine;
    public $jours;

    public function mount()
    {
        $this->classes = ['B1A', 'B1B', 'B2A', 'B2B', 'B3JOUR','B3SOIR','M1','M2'];
        $this->weeks = [Carbon::now()->weekOfYear , Carbon::now()->weekOfYear +1 ];
        $this->semaine = Carbon::now()->weekOfYear;
        $this->classe = 'B1A';
        $this->jours = $this->getJoursSemaine($this->semaine);
        $this->dispatch('classUpdated', $this->classe);
        $this->dispatch('weekUpdated', $this->semaine, $this->jours);
    }

    public function setClass($class)
    {
        $this->classe = $class;
        $this->dispatch('classUpdated', new Classupdate($this->classe));
    }

    public function setWeek($week,)
    {
        $this->semaine = $week;
        $this->jours =$this->getJoursSemaine($week);
        $this->dispatch('weekUpdated', new Weekupdate($this->semaine,$this->jours));
    }

    public function render()
    {
        return view('livewire.select-class-and-week',[
            'classes'=>$this->classes,
            'weeks'=>$this->weeks,
            'jours'=>$this->jours
        ]);
    }


    public  function getJoursSemaine($numeroSemaine) {

        $date = Carbon::now();
        $annee = $date->format('Y');
        $date->setISODate($annee, $numeroSemaine);

        $premierJour = $date->startOfWeek()->format('Y-m-d');
        $dernierJour = $date->endOfWeek()->format('Y-m-d');

        return array($premierJour, $dernierJour);
    }
}
