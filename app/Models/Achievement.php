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
}
