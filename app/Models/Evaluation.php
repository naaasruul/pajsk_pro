<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluation extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'club_id',
        'attendance_score',
        'position_score',
        'commitment_score',
        'service_contribution_score',
        'total_score',
    ];

    protected $casts = [
        'attendance_score' => 'decimal:2',
        'position_score' => 'decimal:2',
        'commitment_score' => 'decimal:2',
        'service_contribution_score' => 'decimal:2',
        'total_score' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function commitments(): BelongsToMany
    {
        return $this->belongsToMany(CommitmentScore::class, 'commitment_score_evaluation')
            ->withTimestamps();
    }
}