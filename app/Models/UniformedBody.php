<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniformedBody extends Model
{
    // jadual 4/5/6
    protected $fillable = [
        'club_name',
        'category',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'uniformed_body_id'); // Reference the club_id column
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_uniformed_body')
            ->withPivot('body_position_id') // Include position in the pivot table
            ->withTimestamps();
    }
}
