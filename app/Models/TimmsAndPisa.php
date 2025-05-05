<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimmsAndPisa extends Model
{
    protected $table = 'timms_and_pisa'; // Corrected table name

    protected $fillable = [
        'name',
        'point',
    ];
}
