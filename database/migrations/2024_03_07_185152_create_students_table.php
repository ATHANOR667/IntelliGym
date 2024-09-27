<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naiss');
            $table->char('sexe');
            $table->integer('taille')->nullable();
            $table->integer('masse')->nullable();
            $table->boolean('adherant');
            $table->boolean('active');
            $table->boolean('delete');
            $table->string('password')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('hour_slot_student',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\HourSlot::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Student::class);
            $table->primary(['hour_slot_id','student_id']);
            $table->boolean('annulation');
            $table->boolean('presence');
            $table->boolean('attente');
            $table->integer('niveau_attente');

        });


    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('hour_slot_student');
    }
};
