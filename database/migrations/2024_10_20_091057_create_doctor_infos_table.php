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
        Schema::create('doctor_infos', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->integer('doctor_id')->unique()->nullable();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('designation_id')->constrained('designations');
            $table->string('speciality', 55);
            $table->string('fee')->default('0');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_infos');
    }
};
