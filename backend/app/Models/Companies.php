<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'CNPJ',
        'localization',
];

public function recruiter()
{
    return $this->belongsTo(Recruiter::class);
}

}
