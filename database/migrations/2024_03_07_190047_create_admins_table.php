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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('password')->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('delete');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('students',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Admin::class)->nullable()->constrained();
        });

        Schema::table('free_hours',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Admin::class)->nullable()->constrained();
        });

        Schema::table('hour_slots',function (Blueprint $table){
            $table->foreignIdFor(\App\Models\Admin::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');

        Schema::table('student',function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Admin::class);
        });

        Schema::table('free_hour',function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Admin::class);
        });

        Schema::table('hour_slot',function (Blueprint $table){
            $table->dropForeignIdFor(\App\Models\Admin::class);
        });
    }
};
