<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Classe;
use App\Models\Ecole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

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

    #[On('user-updated')] 
    public function updatedUser()
    {
        $this->editId = 0 ;
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
        $this->mount($this->admin);
    }


    public function mount(Admin $admin)
    {
        //$this->admin = $this->admin[0] == null ? $this->admin : $this->admin[0];
        $this->search = '';
        $this->column = 'nom';
        $this->direction = 'ASC';
        //$this->editId = (int)0;
        $this->classes = (new Ecole())->classes_by_admin_ecole($admin->id);

    }

    public function render()
    {
        $query = Student::query();
        $query->whereIn('classe_id', array_column($this->classes->toArray(), 'id'));
        $query->where($this->column, 'LIKE', "%{$this->search}%");
        $query->orderBy($this->column, $this->direction);
        if (!empty($this->classe)) {
            $query->where('classe_id', $this->classe);
        }
        $this->users = $query->get();
        return view('livewire.users-table', ['users' => $this->users, 'classes' => $this->classes, 'column' => $this->column, 'admin_key' => $this->admin_key, 'editId' => $this->editId]);
    }


    /**
     *
     *FONCTIONS DE TRI DES ETUDIANTS
     */

    public function setClasse($class)
    {
        $this->classe = $class;
        //$this->editId = (int)0;
       // $this->render();
    }


    public function setColumn($col)
    {
        if ($this->column == $col) {
            $this->direction = ($this->direction == 'ASC') ? 'DESC' : 'ASC';
        } else {
            $this->column = $col;
        }
        $this->dispatch('column-updated', col: $col ); 

        //$this->editId = (int)0;
        //$this->render();
    }

    /**
     * FONCTIONS D'EDITION DES ETUDIANTS
     * */

    public function startEdit($id)
    {

        $this->editId = (int)$id;

        $this->user = Student::find($id);

        $this->matricule = $this->user->matricule;
 
        $this->classe_id = $this->user->classe_id;
 
        $this->nom = $this->user->nom;

        $this->prenom = $this->user->prenom;

        $this->date_naiss = $this->user->date_naiss;

        $this->sexe = $this->user->sexe;    
    }




    public function deleteUsers(array $ids)
    {
        foreach ($ids as $id) {
            $user = Student::find($id);
            if ($user) {
                $user->delete();
            }
            $this->selection = [];
        }

    }

}
