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

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_student');
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

    // Involvement scoring methods
    public function getInvolvementScore(): int
    {
        $maxScore = 0;
        $activities = $this->activities()
            ->with(['involvement', 'achievement'])
            ->get();

        foreach ($activities as $activity) {
            if (!$activity->involvement || !$activity->achievement) {
                \Log::debug('Missing relationship', [
                    'activity_id' => $activity->id,
                    'has_involvement' => (bool)$activity->involvement,
                    'has_achievement' => (bool)$activity->achievement
                ]);
                continue;
            }

            // Use involvement type instead of ID
            $score = \DB::table('achievement_involvement')
                ->where([
                    'achievement_id' => $activity->achievement_id,
                    'involvement_type_id' => $activity->involvement->type // Use type here
                ])
                ->value('score');

            \Log::debug('Score calculation', [
                'activity_id' => $activity->id,
                'achievement_id' => $activity->achievement_id,
                'involvement_type' => $activity->involvement->type,
                'score' => $score
            ]);

            $maxScore = max($maxScore, (int)$score);
        }

        return min($maxScore, 20);
    }

    // Placement scoring methods
    public function getPlacementScore(): int
    {
        $maxScore = 0;
        $activities = $this->activities()
            ->with(['achievement', 'placement'])
            ->whereNotNull('placement_id')
            ->get();

        foreach ($activities as $activity) {
            if (!$activity->achievement || !$activity->placement) {
                continue;
            }

            $score = \DB::table('achievement_placement')
                ->where([
                    'achievement_id' => $activity->achievement_id,
                    'placement_id' => $activity->placement_id
                ])
                ->value('score');

            \Log::debug('Placement Score', [
                'activity_id' => $activity->id,
                'achievement_id' => $activity->achievement_id,
                'placement_id' => $activity->placement_id,
                'score' => $score
            ]);

            $maxScore = max($maxScore, (int)$score);
        }

        return min($maxScore, 20);
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