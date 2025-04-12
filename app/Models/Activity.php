<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'represent',
        'placement_id',
        'involvement_id',
        'achievement_id',
        'club_id',
        'category',
        'activity_place',
        'date_start',
        'time_start',
        'date_end',
        'time_end',
        'activity_teachers_id',
        'activity_students_id',
        'leader_id',
        'created_by',
    ];

    public function teachers() {
        return $this->belongsToMany(Teacher::class);
    }

    public function placement() {
        return $this->hasOne(Placement::class);
    }

    public function involvement() {
        return $this->belongsTo(InvolvementType::class);
    }

    public function achievement() {
        return $this->belongsTo(Achievement::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }

    public function club(){
        return $this->belongsTo(Club::class); // Reference the club_id column
    }
}
