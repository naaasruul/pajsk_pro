<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Classroom;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'home_number',
        'class_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_student')
                    ->withPivot('club_position_id')
                    ->withTimestamps();
    }

    // Remove or comment out the old relationship:
//     public function activities()
//     {
//         return $this->belongsToMany(Activity::class, 'activity_student');
//     }

    // New accessor that returns activities using the JSON field in the activities table
    public function getActivitiesAttribute()
    {
        return \App\Models\Activity::whereJsonContains('activity_students_id', (string)$this->id)->get();
    }

    public function mentor()
    {
        return $this->belongsTo(Teacher::class, 'mentor_id');
    }

    public function extraCocuriculum()
    {
        return $this->hasOne(ExtraCocuricullum::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    // Replace existing getInvolvementScore() with:
    public function getInvolvementScore(): int
    {
        $teacherClub = $this->getCurrentClubAttribute();
        if (!$teacherClub) return 0;
        $teacherClubActivities = $this->activities->filter(function ($activity) use ($teacherClub) {
            return (int)$activity->club_id === (int)$teacherClub->id;
        });
        $teacherActivity = $teacherClubActivities->first();
        $involvementScoreForTeacher = 0;
        if ($teacherActivity && $teacherActivity->achievement) {
            $involvementScoreForTeacher = $teacherActivity->achievement->involvements()
                ->where('involvement_type_id', $teacherActivity->involvement_id)
                ->first()?->pivot->score ?? 0;
        }
        return $involvementScoreForTeacher;
    }
    
    // Replace existing getPlacementScore() with:
    public function getPlacementScore(): int
    {
        $teacherClub = $this->getCurrentClubAttribute();
        if (!$teacherClub) return 0;
        $teacherClubActivities = $this->activities->filter(function ($activity) use ($teacherClub) {
            return (int)$activity->club_id === (int)$teacherClub->id;
        });
        $teacherActivity = $teacherClubActivities->first();
        $placementScoreForTeacher = 0;
        if ($teacherActivity && $teacherActivity->achievement) {
            if ($teacherActivity->placement_id) {
                $placementScoreForTeacher = $teacherActivity->achievement->placements()
                    ->where('placement_id', $teacherActivity->placement_id)
                    ->first()?->pivot->score ?? 0;
            }
        }
        return $placementScoreForTeacher;
    }

    public function getCurrentClubAttribute()
    {
        return $this->clubs()->first();
    }

    public function clubPosition()
    {
        return $this->clubs()
            ->wherePivot('club_position_id', '!=', null)
            ->first()?->pivot?->club_position_id;
    }

    public function getCurrentPositionAttribute()
    {
        $positionId = $this->clubPosition();
        return $positionId ? ClubPosition::find($positionId) : null;
    }

    // Calculate total PAJSK score
    public function calculatePajskScore($attendanceScore, $commitmentScore, $serviceScore)
    {
        $positionScore = $this->getCurrentPosition()?->point ?? 0;
        $involvementScore = $this->getInvolvementScore();
        
        $total = $attendanceScore + // Max 40
                $positionScore + // Max 10
                $involvementScore + // Max 20
                $commitmentScore + // Max 10
                $serviceScore; // Max 10
                // Achievement (20) to be added later

        return [
            'total' => $total,
            'percentage' => round(($total / 110) * 100, 2),
            'breakdown' => [
                'attendance' => $attendanceScore,
                'position' => $positionScore,
                'involvement' => $involvementScore,
                'commitment' => $commitmentScore,
                'service' => $serviceScore
            ]
        ];
    }
}