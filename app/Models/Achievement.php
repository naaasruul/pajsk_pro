<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['achievement_name'];

    public function involvements()
    {
        return $this->belongsToMany(InvolvementType::class, 'achievement_involvement')->withPivot('score');
    }

    public function placements()
    {
        return $this->belongsToMany(Placement::class, 'achievement_placement')->withPivot('score');
    }

    public function nilams()
    {
        return $this->hasMany(Nilam::class, 'achievement_id');
    }

    public function tiers()
    {
        return $this->belongsToMany(Tier::class, 'nilams', 'achievement_id', 'tier_id')
                    ->withPivot('point'); // Include the pivot column 'point'
    }
    
}
