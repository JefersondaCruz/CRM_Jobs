<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'Pendente';
    const STATUS_APPROVED = 'Aprovado';
    const STATUS_REJECTED = 'Rejeitado';


    protected $fillable = [
        'job_opening_id',
        'candidate_id',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    public function jobOpening()
    {
        return $this->belongsTo(JobOpening::class, 'job_opening_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidates::class, 'candidate_id');
    }
}


