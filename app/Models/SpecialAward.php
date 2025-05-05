<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialAward extends Model
{
    protected $fillable = [
        'name',
        'point',
    ];
}
