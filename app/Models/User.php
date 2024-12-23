<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'password',
        'branch_id',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    //full name attribute
    public function fullName()
    {
        return $this->fname . ' ' . $this->lname;
    }


    // relations

    public function doctorInfo()
    {
        return $this->hasOne(DoctorInfo::class, 'doctor_id');
    }

    public function patientInfo()
    {
        return $this->hasOne(PatientInfo::class, 'patient_id');
    }

    //full name
    public function fullName()
    {
        return $this->fname . ' ' . $this->lname;
    }

    // boot method for handling delete() method
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            if ($user->hasRole('Doctor')) {
                $user->doctorInfo()->delete();
            } elseif ($user->hasRole('Patient')) {
                $user->patientInfo()->delete();
            }
        });
    }
}
