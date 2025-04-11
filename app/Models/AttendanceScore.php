<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceScore extends Model
{
    protected $fillable = [
        'attendance_count',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];
}
