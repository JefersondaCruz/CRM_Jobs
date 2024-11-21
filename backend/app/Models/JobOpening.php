<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JobOpening extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salaries',
        'categories',
        'recruiter_id',
    ];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
