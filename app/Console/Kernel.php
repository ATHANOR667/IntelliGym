<?php

namespace App\Console;

use App\Models\Ecole;
use App\Models\FreeHour;
use App\Models\HourSlot;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */


    public function create_hour_slot_logic(){}


    protected function schedule(Schedule $schedule): void
    {

        $schedule->call(function () {
            $query = HourSlot::query();
            $w = Carbon::now()->weekOfYear;
            $past_week = $query->where('semaine','=',$w-1);$past_week = [$past_week->get(),$w-1];
            $current_week =  $query->where('semaine','=',$w);$current_week = [$current_week->get(),$w];
            $next_week_1 =  $query->where('semaine','=',$w+1) ;$next_week_1 = [ $next_week_1->get(),$w+1];
            $next_week_2 = $query->where('semaine','=',$w+2);$next_week_2 = [$next_week_2->get(),$w+2];
            $weeks = [$past_week,$current_week,$next_week_1,$next_week_2];//


            foreach ($weeks as $week) {
                $query = HourSlot::query();

                $weekRecords = $query->where('semaine', '=', $week[1])->get(); // Récupérer les enregistrements de la semaine

                //on verifie si il manque les heures d'une classe ou d'une semaine
                if ($weekRecords->isEmpty()) {
                    $ecoles = (new Ecole())->classes_by_ecole();

                    foreach ($ecoles as $ecole => $key){
                        foreach ($key as $class){

                            (new HourSlot())->create_logic($week[1],'lundi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'lundi',20,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'mardi',20,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'mercredi',20,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'jeudi',20,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'vendredi',20,$class->id);

                            (new HourSlot())->create_logic($week[1],'samedi',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'samedi',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'samedi',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'samedi',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'samedi',16,$class->id);

                            /**
                            (new HourSlot())->create_logic($week[1],'dimanche',8,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',10,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',12,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',14,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',16,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',18,$class->id);

                            (new HourSlot())->create_logic($week[1],'dimanche',20,$class->id);
                             */

                        }

                    }
                }
            }
        })->everyFifteenSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
