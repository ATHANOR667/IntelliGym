<?php

namespace App\Models;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\GetOutWaitListNotification;
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

   public function wait_list_put_out()
   {
        // Définir les dates actuelles et de demain
        $currentDate = Carbon::now()->format('Y-m-d');
        $nextDate = Carbon::now()->addDay()->format('Y-m-d');
        $days = [$currentDate,$nextDate];

        //etudiant ayant une reservation en attente pour le  jour et le lendemain
        $student_on_wait_list = DB::table('hour_slot_student')
            ->join('hour_slots','hour_slots.id','=','hour_slot_student.hour_slot_id')
            ->where('hour_slot_student.attente','=',true)
            ->distinct('hour_slot_student.student_id')
            ->where(function($query) use ($currentDate, $nextDate) {
                $query->where('hour_slots.date', '=', $currentDate)
                    ->orWhere('hour_slots.date', '=', $nextDate);
            })->pluck('hour_slot_student.student_id');


        foreach($student_on_wait_list as $student){


            $query_campus  = DB::table('campuses')
                ->join('ecoles','campuses.id','=','ecoles.campus_id')
                ->join('classes','ecoles.id','=','classes.ecole_id')
                ->join('students','students.classe_id','classes.id')
                ->where('students.id','=', $student)
                ->first(['campuses.capacite','campuses.id']);




            foreach ($days as $day)
            {
                //reservation en attente  de l'etudiant (multiple)
                $wait_list = DB::table('hour_slot_student')
                    ->join('hour_slots', 'hour_slots.id', '=', 'hour_slot_student.hour_slot_id')
                    ->where('hour_slot_student.student_id','=',$student)
                    ->where('hour_slot_student.attente','=',true)
                    ->where('hour_slots.date', '=', $day)
                    ->where('hour_slots.campus_id', '=', $query_campus->id)
                    ->pluck('hour_slot_student.hour_slot_id');


                $firstIteration = true;
                foreach($wait_list as $book)
                {

                    $n= DB::table('hour_slot_student')
                            ->where([
                                'hour_slot_student.hour_slot_id'=> $book ,
                                'hour_slot_student.attente' => true
                            ])->count();

                    if ($n < $query_campus->capacite){
                        DB::table('hour_slot_student')
                            ->where('hour_slot_student.student_id','=',$student)
                            ->where('hour_slot_student.hour_slot_id','=',$book)
                            ->update([
                                'attente'=> false,
                                'niveau_attente' => 0
                            ]);


                        if ($firstIteration) {
                            $user = Student::find($student);
                            $book = \App\Models\HourSlot::find($book);
                            $user->notify(new GetOutWaitListNotification($book));

                            $firstIteration = false;
                        }


                    }
                }
            }
        }

   }

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
