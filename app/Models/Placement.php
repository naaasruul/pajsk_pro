<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    protected $fillable = ['name', 'description'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_placement')->withPivot('score');
    }
}