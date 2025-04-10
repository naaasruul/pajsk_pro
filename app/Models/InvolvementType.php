<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Involvement extends Model
{
    protected $fillable = ['name', 'description'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_involvement')->withPivot('score');
    }
}