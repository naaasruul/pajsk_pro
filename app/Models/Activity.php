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
        'status',
    ];

    public function teachers() {
        return $this->belongsToMany(Teacher::class);
    }

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }

    public function involvement()
    {
        return $this->belongsTo(InvolvementType::class, 'involvement_id')
            ->select(['id', 'type', 'description']); // Ensure we get the type field
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class)
            ->with(['involvements' => function($query) {
                $query->withPivot(['score']);
            }]);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }

    public function club(){
        return $this->belongsTo(Club::class); // Reference the club_id column
    }

    public function createdBy()
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }
}
