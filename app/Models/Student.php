<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'home_number',
        'class',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_student')
                    ->withPivot('club_position_id') // Include position in the pivot table
                    ->withTimestamps();
    }

    public function uniformedBodies()
    {
        return $this->belongsToMany(UniformedBody::class, 'club_student')
                    ->withPivot('uniformed_body_position_id') // Include position in the pivot table
                    ->withTimestamps();
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_student')
                    ->withPivot(['achievement_id', 'placement_id'])
                    ->withTimestamps();
    }
}