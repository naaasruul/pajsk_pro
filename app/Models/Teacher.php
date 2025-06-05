<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'club_id',
        'address',
        'phone_number',
        'home_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function students()
    {
        return $this->hasMany(Student::class, 'mentor_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id'); // Reference the club_id column
    }

    public function uniformedBody()
    {
        return $this->belongsTo(UniformedBody::class, 'uniformed_body_id'); // Reference the club_id column
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function createdActivities()
    {
        return $this->hasMany(Activity::class, 'created_by');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function classroomSubjectAssignments()
{
    return $this->hasMany(ClassroomSubjectTeacher::class);
}
}
