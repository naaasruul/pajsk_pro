<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
     protected $fillable = [
        'name',
        'code',
    ];

    //
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }

    public function classroomSubjectAssignments()
{
    return $this->hasMany(ClassroomSubjectTeacher::class);
}
}
