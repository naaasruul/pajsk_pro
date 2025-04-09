<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'involvement_id',
        'achievement_id',
        'teacher_activityID',
        'student_activityID',
        'activity_place',
        'levels',
        'category',
        'datetime_start',
        'datetime_end',
    ];

    public function teachers() {
        return $this->belongsToMany(Teacher::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
