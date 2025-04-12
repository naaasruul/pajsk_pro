<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubPosition extends Model
{
    protected $fillable = [
        'position_name',
        'point',
    ];

    public function student(){
        return $this->belongsToMany(Student::class);
    }
}
