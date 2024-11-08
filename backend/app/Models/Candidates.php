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
        'CEP',
        'house_number',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
