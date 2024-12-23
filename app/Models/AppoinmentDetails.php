<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppoinmentDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    //doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    //patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
