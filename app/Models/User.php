<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'creator_id');
    }

    public function appointmentsAsParticipant()
    {
        return $this->belongsToMany(Appointment::class, 'user_appointment');
    }
}
