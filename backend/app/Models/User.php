<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_RECRUITER = 'recruiter';
    const TYPE_CANDIDATE = 'candidate';

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',

    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function recruiter()
    {
        return $this->hasOne(Recruiter::class);
    }

    public function candidate()
    {
        return $this->hasOne(Candidates::class, 'user_id');
    }
}
