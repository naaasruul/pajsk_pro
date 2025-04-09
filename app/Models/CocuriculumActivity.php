<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CocuriculumActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'no_maktab',
        'class',
        'activity',
        'marks'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
