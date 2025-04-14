<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PajskAssessment extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id', 
        'attendance_score',
        'position_score',
        'involvement_score',
        'commitment_score',
        'service_score',
        'achievement_score',
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
}
