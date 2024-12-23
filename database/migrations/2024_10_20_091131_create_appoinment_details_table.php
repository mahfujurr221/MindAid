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
        Schema::create('appoinment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->dateTime('appoinment_date');
            $table->integer('duration');
            $table->string('appoinment_note', length: 100)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment_status')->default(0);
            $table->integer('session_status')->default(0);
            $table->string('comment', 255);
            $table->string('transaction_id', 255)->nullable();

            //zoom_meeting_id
            $table->string('zoom_meeting_id', 255)->nullable();
            // start_url
            $table->text('start_url', 255)->nullable();
            // join_url
            $table->string('join_url', 255)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appoinment_details');
    }
};
