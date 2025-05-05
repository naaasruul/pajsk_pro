<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    protected $fillable = ['name'];

    public function nilams()
    {
        return $this->hasMany(Nilam::class, 'tier_id');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'nilams', 'tier_id', 'achievement_id')
                    ->withPivot('point'); // Include the pivot column 'point'
    }
}
