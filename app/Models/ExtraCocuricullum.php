<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraCocuricullum extends Model
{
    //
     protected $fillable = [
        'student_id', // Add student_id to the fillable attributes
        'service_point',
        'special_award_point',
        'community_service_point',
        'nilam_point',
        'timms_and_pisa_point',
        'total_point',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
