<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class UsersUpdate extends Component
{
    public array $classes;
    public Student $user;
    protected $rules = [
        'user.matricule' => '',//'unique:students,matricule,'.$this->user->id.',id',
        'user.classe' => 'in:B1A,B1B,B2A,B2B,B3JOUR,B3SOIR,M1,M2',
        'user.nom' => '',
        'user.prenom' => '',
        'user.date_naiss' => 'date|before_or_equal:2008-12-31',
        'user.sexe' => 'in:M,F',
    ];


    public function save()
    {
        $this->validate();
        $this->user->save();
        session()->flash('success','modification enregistree');
        $this->dispatch('userUpdated');
    }
    public function test()
    {
        dump('jhgfjhfjghfjgjghvjhgfjhhjbkhgkjviyjf');
    }

    public function render()
    {
        return view('livewire.users-update',['user'=>$this->user ]);
    }
}
