<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorInfo extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relationship
    public function userInfo()
    {
        return $this->belongsTo(User::class);
    }

    //Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    //Designation
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    
}
