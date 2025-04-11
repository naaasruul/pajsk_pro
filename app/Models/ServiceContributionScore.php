<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceContributionScore extends Model
{
    protected $fillable = [
        'service_name',
        'description',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];
}
