<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;
    protected $fillable =['nom','campus_id'];


    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function classes_by_ecole()
    {

        $ecoles = Ecole::all() ;
        $classes = [];
        foreach ($ecoles as $ecole){
            $classes[$ecole->nom] = $ecole->classes ;
        }
        // Retourner les classes associées à cette école
        return  $classes;
    }

    public function classes_by_admin_ecole($id)
    {
        // Trouver l'admin avec l'ID donné
        $admin = Admin::findOrFail($id);

        // Accéder à l'école de l'admin
        $ecole = $admin->ecole;

        // Retourner les classes associées à cette école
        return $ecole->classes;
    }



}
