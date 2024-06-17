<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    protected $fillable = ['nom','pays','ville', 'quartier', 'ville_quartier'];

    public function setVilleAttribute($value)
    {
        $this->attributes['ville'] = $value;
        $this->attributes['ville_quartier'] = $value . ' ' . ($this->attributes['quartier'] ?? '');
    }

    public function setQuartierAttribute($value)
    {
        $this->attributes['quartier'] = $value;
        $this->attributes['ville_quartier'] = ($this->attributes['ville'] ?? '') . ' ' . $value;
    }

    public function ecoles()
    {
        return $this->hasMany(Ecole::class);
    }


}
