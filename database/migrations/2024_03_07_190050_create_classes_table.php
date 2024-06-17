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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('niveau');
            $table->string('numero')->nullable();
            $table->string('c_d_s');
            $table->string('specialite');
            $table->timestamps();
        });

        Schema::table('students',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Classe::class)->constrained();
        });

        Schema::table('hour_slots',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Classe::class)->constrained();
        });

        Schema::table('free_hours',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Classe::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
