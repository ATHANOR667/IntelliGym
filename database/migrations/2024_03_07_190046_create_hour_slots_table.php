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
        Schema::create('hour_slots', function (Blueprint $table) {
            $table->id();
            $table->string('d_o_w');
            $table->integer('jour');
            $table->string('mois');
            $table->string('annee');
            $table->integer('semaine');
            $table->date('debut');
            $table->date('fin');
            $table->date('date');
            $table->boolean('delete');
            $table->boolean('full');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hour_slots');
    }
};
