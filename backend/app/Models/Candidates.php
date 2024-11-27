<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experiences',
        'skills',
        'phone',
        'social_media',
        'CEP',
        'house_number',
        'profile_picture',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
