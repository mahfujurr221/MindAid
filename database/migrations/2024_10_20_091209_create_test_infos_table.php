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
        Schema::create('test_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appoinment_id'); 
            $table->dateTime('date'); 
            $table->string('test_name', 255); 
            $table->string('test_result', 255); 
            $table->string('test_note', 255);
            $table->string('test_link', 255); 
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_infos');
    }
};
