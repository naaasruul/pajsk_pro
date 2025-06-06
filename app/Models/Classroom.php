<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\User;

class Classroom extends Model
{
    protected $fillable = [
        'year',
        'class_name',
        'active_status',
    ];

    /**
     * Get the students for the classroom.
     */
    public function students()
    {
        return $this->hasMany(Student::class,'class_id');
    }

    /**
     * Get the user for the classroom.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function segaks()
    {
        return $this->hasMany(\App\Models\Segak::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function classroomSubjectAssignments()
{
    return $this->hasMany(ClassroomSubjectTeacher::class);
}
}
