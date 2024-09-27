<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    protected $fillable = ['nom','pays','ville', 'quartier'];



    public function ecoles()
    {
        return $this->hasMany(Ecole::class);
    }


}
