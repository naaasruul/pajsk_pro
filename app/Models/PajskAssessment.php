<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PajskAssessment extends Model
{
    // Updated fillable to reflect new fields and aggregated totals
    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_ids',
        'club_ids',
        'club_position_ids',
        'service_contribution_ids',
        'attendance_ids',
        'commitment_ids',
        // 'involvement_ids',
        // 'activity_ids',
        'achievement_ids',
        'achievements_activity_ids',
        'placement_ids',
        'placements_activity_ids',
        // 'service_ids',
        'total_scores',
        'percentages',
    ];

    // Updated casts for new fields
    protected $casts = [
        'student_id'                =>'integer',
        'class_id'                  =>'integer',
        'teacher_ids'               =>'array',
        'club_ids'                  =>'array',
        'club_position_ids'         =>'array',
        'service_contribution_ids'  =>'array',
        'attendance_ids'            =>'array',
        'commitment_ids'            =>'array',
        // 'involvement_ids'           =>'array',
        // 'activity_ids'              =>'array',
        'achievement_ids'           =>'array',
        'achievements_activity_ids' =>'array',
        'placement_ids'             =>'array',
        'placements_activity_ids'   =>'array',
        // 'service_ids'               =>'array',
        'total_scores'              =>'array',
        'percentages'               =>'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Accessor for teacher models remains unchanged.
    public function getTeachersAttribute()
    {
        $ids = $this->teacher_ids ?? [];
        return \App\Models\Teacher::whereIn('id', $ids)->get();
    }

    public function getTeacherAttribute()
    {
        return optional($this->teachers->first());
    }

    public function serviceContribution(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ServiceContribution::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Classroom::class, 'class_id');
    }

    // Accessor for clubs using stored club_ids
    public function getClubsAttribute()
    {
        $ids = $this->club_ids ?? [];
        return \App\Models\Club::whereIn('id', $ids)->get();
    }
    
    // Accessor for club positions using club_position_ids
    public function getClubPositionsAttribute()
    {
        $ids = $this->club_position_ids ?? [];
        return \App\Models\ClubPosition::whereIn('id', $ids)->get();
    }

    // New relationship: Attendances (stored as JSON array)
    public function attendances()
    {
        return \App\Models\Attendance::whereIn('id', $this->attendance_ids ?? []);
    }
    
    // New relationship: Involvement (singular)
    public function involvement()
    {
        return \App\Models\InvolvementType::find('id', $this->involvement_ids ?? []);
    }
    
    // New relationship: Commitments
    public function commitments()
    {
        $ids = is_array($this->commitment_ids) ? \Illuminate\Support\Arr::flatten($this->commitment_ids) : [];
        return \App\Models\Commitment::whereIn('id', $ids);
    }
    
    // New relationship: Services 
    public function services()
    {
        return \App\Models\ServiceContribution::whereIn('id', $this->service_ids ?? []);
    }
    
    // New relationship: Placement (singular)
    public function placement()
    {
        return \App\Models\Placement::find('id', $this->placement_ids ?? []);
    }
}
