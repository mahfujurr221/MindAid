<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInfo extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relationship
    public function userInfo()
    {
        return $this->belongsTo(User::class);
    }
}
