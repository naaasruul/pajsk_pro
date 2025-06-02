<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubjectTeacher extends Model
{
    function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
