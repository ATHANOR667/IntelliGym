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
        Schema::create('ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });


        Schema::table('classes',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Ecole::class)->constrained()->onDelete('cascade');
        });

        Schema::table('admins',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Ecole::class)->constrained();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecoles');


        Schema::table('classes',function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Ecole::class);
        });

    }
};
