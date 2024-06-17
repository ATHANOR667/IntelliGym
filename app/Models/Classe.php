<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['niveau','numero','specialite','ecole_id','c_d_s'];

public function ecole()
{
    return $this->belongsTo(Ecole::class,'ecole_id','id');
}

}
