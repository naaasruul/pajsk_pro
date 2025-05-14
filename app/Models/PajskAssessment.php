<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PajskAssessment extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'club_id',
        'club_position_id',
        'attendance_score',
        'position_score',
        'involvement_score',
        'commitment_score',
        'service_score',
        'placement_score', // Add this line
        'total_score',
        'percentage',
        'commitment_ids',
        'service_contribution_id'
    ];

    protected $casts = [
        'commitment_ids' => 'array',
        'percentage' => 'decimal:2'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function serviceContribution(): BelongsTo
    {
        return $this->belongsTo(ServiceContribution::class);
    }

    public function classroom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Classroom::class, 'class_id');
    }

    public function club(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Club::class, 'club_id');
    }

    public function clubPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ClubPosition::class, 'club_position_id');
    }
}
