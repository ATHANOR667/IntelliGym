<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeHour extends Model
{
    protected $fillable = [
        'd_o_w',
        'jour',
        'mois',
        'annee',
        'semaine',
        'debut',
        'fin',
        'classe_id',
        'delete',
        'date',
        'admin_id'
    ];
    use HasFactory;
}
