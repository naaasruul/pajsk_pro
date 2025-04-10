<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'club_id',
        'address',
        'phone_number',
        'home_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id'); // Reference the club_id column
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
