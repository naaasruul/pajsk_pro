<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceContribution extends Model
{
    protected $fillable = [
        'service_name',
        'score',
        'description'
    ];
}
