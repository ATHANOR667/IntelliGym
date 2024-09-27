<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Campus;
use App\Models\Classe;
use App\Models\Ecole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Campus::create([
            'nom' => 'CDP Yaounde',
            'quartier' => 'Titi Garage',
            'ville'=> 'yaounde',
            'pays' => 'cameroun' ,
            'capacite' => 7
        ]);

        Ecole::create([
            'nom' => 'Keyce',
            'campus_id'=> 1
        ]);

        Ecole::create([
            'nom' => 'Digital',
            'campus_id'=> 1
        ]);

        Admin::create([
            'matricule' => 'matricule 1',
            'delete' => false ,
            'nom' => 'Ngoue' ,
            'prenom' => 'Je suis le salaud que je pense etre',
            'ecole_id' => 1
        ]);
        /**
         *          KEYCE
         */
        Classe::create([
            'niveau' => 'B1',
            'numero' => 'A',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B1',
            'numero' => 'B',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B2',
            'numero' => 'A',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B2',
            'numero' => 'B',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
        'niveau' => 'B3',
        'numero' => 'Jour',
        'c_d_s' => false,
        'specialite' => 'IABD' ,
        'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'ASI' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'CYBER' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'Block-chain' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'IABD' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'ASI' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'CYBER' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Block-chain' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'IABD' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'ASI' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'CYBER' ,
            'ecole_id' => 1 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Block-chain' ,
            'ecole_id' => 1 ,
        ]);




        /**
         *          DIGITAL
         */
        Classe::create([
            'niveau' => 'B1',
            'numero' => 'A',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B1',
            'numero' => 'B',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B2',
            'numero' => 'A',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B2',
            'numero' => 'B',
            'c_d_s' => false,
            'specialite' => 'tronc commun' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'Marketing' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'Design' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'CYBER' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'B3',
            'numero' => 'Jour',
            'c_d_s' => false,
            'specialite' => 'Management' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Marketing' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Design' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Gestion et compta' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M1',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Management' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Marketing' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Design' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Gestion et compta' ,
            'ecole_id' => 2 ,
        ]);

        Classe::create([
            'niveau' => 'M2',
            'numero' => 'Soir',
            'c_d_s' => true,
            'specialite' => 'Management' ,
            'ecole_id' => 2 ,
        ]);
    }
}
