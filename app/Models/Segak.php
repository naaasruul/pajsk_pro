<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segak extends Model
{
    //

    protected $fillable = [
        'classroom_id',
        'student_id',
        'session',
        'date',
        'weight',
        'height',
        'step_test_steps',
        'step_test_score',
        'push_up_steps',
        'push_up_score',
        'sit_up_steps',
        'sit_up_score',
        'sit_and_reach',
        'sit_and_reach_score',
        'total_score',
        'gred',
        'bmi_status',
    ];

}
