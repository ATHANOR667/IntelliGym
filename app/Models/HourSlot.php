<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class HourSlot extends Model
{
    public function students()
    {
        return $this->belongsToMany(Student::class, 'hour_slot_student', 'hour_slot_id', 'student_id');
    }
    use HasFactory;
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
        'admin_id',
        'full',
        'campus_id'

    ];
    public function create_logic($week ,$d_o_w , $debut ,$classe_id )
    {
        $campus_id = DB::table('campuses')
            ->join('ecoles','campuses.id','=','ecoles.campus_id')
            ->join('classes','ecoles.id','=','classes.ecole_id')
            ->where('classes.id','=',$classe_id)
            ->first('campuses.id')->id;
        $duree = 2 ;
        $fin = $debut + $duree ;
        $date = Carbon::now()->setISODate(Carbon::now()->year, $week);
        $mois = $date->format('F');
        $lundi =  Carbon::now()->setISODate(Carbon::now()->year, $week)->isoWeekday(1)->day ;
        $mardi = $lundi+1; $mercredi = $lundi+2;$jeudi = $lundi+3;$vendredi = $lundi+4;$samedi = $lundi+5 ; $dimanche = $lundi+6;
        $jours = ['lundi' => $lundi, 'mardi' => $mardi, 'mercredi' => $mercredi, 'jeudi' => $jeudi, 'vendredi' => $vendredi, 'samedi' => $samedi, 'dimanche' => $dimanche];

        \App\Models\HourSlot::create([
            'date'=> $date->format('Y').'-'.$date->format('m').'-'.$jours[$d_o_w],
            'd_o_w'=> $d_o_w  ,
            'jour'=> $jours[$d_o_w] ,
            'semaine'=> $week,
            'mois'=> $mois,
            'annee'=> $date->format('Y') ,
            'debut'=> $debut,
            'fin' => $fin ,
            'classe_id'=> $classe_id,
            'campus_id'=> $campus_id,
            'delete'=>false,
            'full'=>false
        ]);
    }
}
