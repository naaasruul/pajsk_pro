<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'home_number',
        'class'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_student')
                    ->withPivot('club_position_id') // Include position in the pivot table
                    ->withTimestamps();
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}