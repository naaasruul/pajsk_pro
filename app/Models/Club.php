<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'club_name',
        'category',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'club_id'); // Reference the club_id column
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'club_student')
            ->withPivot('club_position_id') // Include position in the pivot table
            ->withTimestamps();
    }
}
