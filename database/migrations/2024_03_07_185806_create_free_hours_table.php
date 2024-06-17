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
        Schema::create('free_hours', function (Blueprint $table) {
            $table->id();
            $table->string('d_o_w');
            $table->integer('jour');
            $table->string('mois');
            $table->string('annee');
            $table->integer('semaine');
            $table->date('date');
            $table->date('debut');
            $table->date('fin');
            $table->boolean('delete');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_hours');
    }
};
