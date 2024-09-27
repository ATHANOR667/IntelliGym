<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Classe;
use App\Models\Ecole;
use App\Models\User;
use App\Models\Student;

use Livewire\Component;
use Illuminate\Support\Collection;

class UsersUpdate extends Component
{
    public $users;
    public Admin $admin ;
    public Student $user;
    public Collection $classes;
    public string $classe;
    public $editId;
    public string $search;
    public string $column;
    public string $direction;
    public array $selection = [];
    public $admin_key;

    #[validate('required')]
    public $matricule = '';

    #[validate('required')]
    public $classe_id = '';

    #[validate('required')]
    public $nom ='';

    #[validate('required')]
    public $prenom = '';

    #[validate('required|date|before_or_equal:2008-12-31')]
    public $date_naiss = '';

    #[validate('required|in:M,F')]
    public $sexe = '';

    #[On('column-updated')] 
    public function updatedColumn($col)
    {
        $this->column = $col;
    }


    public function save()//
    {
       // dump($this->user);
        $this->user->update([
            'classe_id' => $this->classe_id,
            'matricule' => $this->matricule,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naiss' => $this->date_naiss,
            'sexe' => $this->sexe
        ]);
        session()->flash('success', 'modification enregistree');
        $this->dispatch('user-updated'); 
    }

    public function mount()
    {
        //$this->editId = (int)$id;

        //$this->user = Student::find($id);

        $this->matricule = $this->user->matricule;
 
        $this->classe_id = $this->user->classe_id;
 
        $this->nom = $this->user->nom;

        $this->prenom = $this->user->prenom;

        $this->date_naiss = $this->user->date_naiss;

        $this->sexe = $this->user->sexe;    
    }

    public function render()
    {
        return view('livewire.users-update',['user'=>$this->user , 'column'=> $this->column]);
    }
}
