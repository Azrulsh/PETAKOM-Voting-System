<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'manage_candidates';

    protected $guarded = ['id'];

    protected $casts = [
        'criteria_rate' => 'array',
    ];
}
