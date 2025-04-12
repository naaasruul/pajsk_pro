<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvolvementType extends Model
{
    protected $fillable = ['name', 'description'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_involvement')->withPivot('score');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}