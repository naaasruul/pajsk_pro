<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PajskReport extends Model
{
    protected $fillable = [
        'student_id',
        'class_id', // determine the year of the report and classroom
        'extra_cocuricullum_id', // take extra cocu report for the current year and points
        'pajsk_assessment_id', // take club ids and marks
        'gpa', // GPA calculation: (highest total marks + second highest total marks for each organization) / 2 [automatically set to cgpa if first year]
        'cgpa', // CGPA calculation: (past year + current year cgpa)
        'cgpa_pctg', // take CGPA and 10% it, eg: 67.5 = 6.75
        'report_description', // report desc determined by the cgpa accumulated
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        //
    ];

    public function pajskAssessment()
    {
        return $this->belongsTo(PajskAssessment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function extraCocuricullum()
    {
        return $this->belongsTo(ExtraCocuricullum::class, 'extra_cocuricullum_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
