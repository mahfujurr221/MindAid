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
        Schema::create('prescription_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appoinment_id');
            $table->string('prescription_link', 255);
            $table->string('description', 255);
            $table->dateTime('date');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_infos');
    }
};
