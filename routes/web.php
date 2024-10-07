<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



/** ROUTES RESERVEES A L'AUTHENTIFICATION ADMINISTRATEUR
 *
 *
 *
 *
 *
 * PARTIE 1 ( ROUTES LIEES A L'AUTHENTIFICATION UTILISEES LORSQUE L'ADMINISTRATEUR N'EST PAS CONNECTE)
 *
 *
 *
 *
 *
 * */
Route::controller(\App\Http\Controllers\AuhtController::class)
    ->name('admin.')->group(function (){

        /**
         *  SIGNIN
         *
         */

        Route::get('/otp_request_signin','otp_request_signin')->name('otp_request_signin');
        Route::post('/otp_request_signin','otp_request_signin_process')->name('otp_request_signin');
        Route::get('/signin','signin')->name('signin');
        Route::post('/signin','signin_process')->name('signin');


        /** LOGIN
         *
         */

        Route::get('/','login')->name('login');
        Route::post('/','login_process')->name('login_process');

        /** LOGOUT
         *
         */
        Route::delete('/logout','logout')->name('logout');



        /** PASSWORD-RESET-WHILE-IS-NOT-CONNECTED
         *
         * (modifier le mot de passse sans etre connecte)
         */
        Route::get('/password_reset_init_while_disconnected','password_reset_init_while_disconnected')->name('password_reset_init_while_disconnected');
        Route::post('/password_reset_init_while_disconnected','password_reset_init_while_disconnected_process')->name('password_reset_init_while_disconnected');
        Route::get('/password_reset_while_disconnected','password_reset_while_disconnected')->name('password_reset_while_disconnected');
        Route::post('/password_reset_while_disconnected','password_reset_process_while_disconnected')->name('password_reset_while_disconnected');



        /** PASSWORD-RESET-WHILE-IS-CONNECTED
         *
         * (modifier lemot de passse etant deja connecte)
         */
        Route::get('/password_reset_init-{admin}', 'password_reset_init')->name('password_reset_init');
        Route::get('/password_reset-{admin}', 'password_reset')->name('password_reset');
        Route::post('/password_reset-{admin}', 'password_reset_process')->name('password_reset');


        /** EMAIL - RESET
         *
         * (pour modifier l'adresse mail associee au compte  )
         */
        Route::get('/email_reset_otp_request-{admin}', 'email_reset_otp_request')->name('email_reset_otp_request');
        Route::post('/email_reset_otp_request-{admin}', 'email_reset_otp_request_process')->name('email_reset_otp_request');
        Route::get('/email_reset-{admin}', 'email_reset')->name('email_reset');
        Route::post('/email_reset-{admin}', 'email_reset_process')->name('email_reset');


    });


/** ROUTES RESERVEES AUX ADMINISTRATEURS
 *
 *
 *ADMINISTRATION: membre de l'administration de l'ecole en charge de fournir les programmes
 * */
Route::controller(\App\Http\Controllers\AdminController::class)
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function (){


    /** ACCEUIL
     *
     *
     */
    Route::get('/accueil-{admin}','accueil')->name('accueil');

    /** ACCEUIL
     *
     *
     */
     Route::get('/profil-{admin}','profil')->name('profil');



        /** ADD STUDENT
     *
     * route redirigeant vers le formulaire d'ajout d'eleves
     */

    Route::get('/add-student-{admin}','add_student')->name('add_student');
    Route::post('/add-student-{admin}','add_student_process')->name('add_student');

    /** ADD FREE HOURS
     *
     * route redirigeant l'admin vers la page d'ajout des heures libres de la semaine pour une classe de son ecole
     */

    Route::get('/add-free-hour-{admin}','add_free_hour')->name('add_free_hour');
    Route::post('/add-free-hour-{admin}','add_free_hour_process')->name('add_free_hour');

    /** ADD HOUR SLOT
     *
     *route redirigeant vers la page pour ajouter les tranches horaires d'ouverture de la salle pour les eleves d'une ecole
     */

    Route::get('/add-hour-slot-{admin}','hour_slot')->name('hour_slot');
    Route::post('/add-hour-slot-{admin}','hour_slot')->name('hour_slot');

      /** BOOK - LIST
     *
     *route redirigeant vers la page affichant la liste des etudiants ayant reserve une seance
     */

     Route::get('/booking-list-{admin}','list')->name('list');
     Route::post('/booking-list-{admin}','list')->name('list');

    /**DASHBOARD
     *
     * route redirigeant vers le tableau de bord affichant les statisti
     */

     Route::get('/dasboard','')->name('');


});



/** ROUTES RESERVEES A LA MODIFICATION DES IDENTIFIANTS DES UTILISTEURS
 **
 *
 *
 *
 *
 * */
Route::controller(\App\Http\Controllers\AuhtController::class)
    ->prefix('/user')
    ->name('user.')->group(function (){


        Route::get('/success-{user}', 'success')->name('success');


        /** PASSWORD-RESET-WHILE-IS-CONNECTED
         *
         * (modifier lemot de passse etant deja connecte)
         */
        Route::get('/reset_password-{user}', 'password_reset_user')->name('password_reset');
        Route::post('/reset_password-{user}', 'password_reset_user_process')->name('password_reset');

    });

