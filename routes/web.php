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

/** ROUTES RESERVEES AUX USERS
 *
 *
 * USER: eleve d'une ecole du campus de titi garage
 * */
Route::prefix('/')->controller(\App\Http\Controllers\UserController::class)->name('user.')->group(function (){
    /** ACCEUIL */
    Route::get('/','accueil_guest')->name('accueil_guest');
    Route::get('/accueil-{student}','accueil')->name('accueil');

    /** ABOUT */
    Route::get('/about','about')->name('about');

    /**  EmailCheck
     *
     * on verifie que l'email est valie en lui envoyant un email avec le lien pour l'inscription
     * */
    Route::get('/email-check','email_check')->name('mailcheck');
    Route::post('/email-check','email_check_process')->name('mailcheck');


    /**  SIGNIN
     *
     * page d'inscription (dans les faits on comparera les informations entrees avec celles
     *                     renseignees par le ou les admins de l'ecole afin de verifier l'appartennance a l'ecole)
     * */
    Route::get('/signin','student_signin')->name('signin');
    Route::post('/signin','student_signin_process')->name('signin_process');

    /**  LOGIN
     *
     * l'eleve enregistre prealablement par un admin de son ecole et ayant confirme son identite  en ajoutant au
     * passage son mote de passe entrera ses informations de connection
     * */
    Route::get('/login','student_login')->name('login');
    Route::post('/login','student_login_process')->name('login_process');

    /** LOGOUT
     *
     *l'eleve se desconnecte
     *
     */
    Route::delete('/logout','logout')->name('logout');


    /** RESET PASSWORD
     *
     *
     */
    Route::get('/reset-init','reset_init')->name('reset_init');
    Route::post('/reset-init','reset_init_exec')->name('reset_init_process');
    Route::get('/reset-{student}','reset')->name('reset');
    Route::post('/reset-{student}','reset_process')->name('reset_process');


    /** BOOKING L'ELEVE PEUT RESERVER OU ANNULER UN RESERVATION
     *
     *
     */
    Route::get('/booking-{student}','booking')->name('booking');
    Route::post('/booking-{student}','booking_process')->name('booking');

    /** PROFIL
     *
     *
     */
    Route::get('/profil-{student}','profil')->name('profil');





});





/** ROUTES RESERVEES AUX ADMINISTRATEURS
 *
 *
 *ADMINISTRATION: membre de l'administration de l'ecole en charge de fournir les programmes
 * */
Route::prefix('/aaa')->controller(\App\Http\Controllers\AdminController::class)->name('admin.')->group(function (){


    /**CHECKMAIL
     *
     */

    Route::get('/checkmail','admin_checkmail')->name('checkmail');
    Route::post('/checkmail','admin_checkmail_process')->name('checkmail_process');

    /** SIGNIN
     *
     *
     */

    Route::get('/admin_signin','admin_signin')->name('signin');
    Route::post('/admin_signin','admin_signin_process')->name('signin_process');

    /** LOGIN
     *
     */

    Route::get('/','admin_login')->name('login');
    Route::post('/','admin_login_process')->name('login_process');

    /** LOGOUT
     *
     *
     */
    Route::delete('/admin-logout','admin_logout')->name('logout');

    /** PASSWORD RESET
     *
     *
     */

    Route::get('/admin-reset-init','admin_reset_init')->name('reset_init');
    Route::post('/admin-reset-init','admin_reset_init_exec')->name('reset_init_process');
    Route::get('/admin-reset-{admin}','admin_reset')->name('reset');
    Route::post('/admin-reset-{admin}','admin_reset_process')->name('reset_process');

    /** ACCEUIL
     *
     *
     */
    Route::get('/accueil-{admin}','accueil')->name('accueil');



    /** ADD STUDENT
     *
     * route redirigeant vers le formulaire d'ajout d'eleves
     */

    Route::get('/add-student-{admin}','add_student')->name('add_student');
    Route::post('/add-student-{admin}','add_student_process')->name('add_student_process');

    /** ADD FREE HOURS
     *
     * route redirigeant l'admin vers la page d'ajout des heures libres de la semaine pour une classe de son ecole
     */

    Route::get('/add-free-hour-{admin}','add_free_hour')->name('add_free_hour');
    Route::post('/add-free-hour-{admin}','add_free_hour_process')->name('add_free_hour_process');

    /** ADD HOUR SLOT
     *
     *route redirigeant vers la page pour ajouter les tranches horaires d'ouverture de la salle pour les eleves d'une ecole
     */

    Route::get('/add-hour-slot-{admin}','hour_slot')->name('hour_slot');
    Route::post('/add-hour-slot-{admin}','hour_slot')->name('hour_slot');

    /**DASHBOARD
     *
     * route redirigeant vers le tableau de bord affichant les statisti
     */

     Route::get('/dasboard','')->name('');


});
