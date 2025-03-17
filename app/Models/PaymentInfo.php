<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'transaction_id',
        'amount',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(AppoinmentDetails::class, 'appoinment_id', 'id');
    }

    //patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
