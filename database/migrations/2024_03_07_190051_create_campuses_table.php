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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('pays');
            $table->string('ville');
            $table->string('quartier');
            $table->integer('capacite');
            $table->timestamps();
        });

        Schema::table('ecoles',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Campus::class)->constrained();
        });

        Schema::table('hour_slots',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Campus::class)->constrained();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
        Schema::table('ecoles',function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Campus::class);
        });
    }
};
