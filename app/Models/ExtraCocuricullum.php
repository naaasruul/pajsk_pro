<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom; // Add this import if not already present

class ExtraCocuricullum extends Model
{   
    // rename table
    protected $table = 'extra_cocuricculum';
    //
     protected $fillable = [
        'student_id',
        'class_id',
        'service_id',
        'special_award_id',
        'community_service_id',
        'nilam_id',
        'timms_pisa_id',
        'total_point',  
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function specialAward()
    {
        return $this->belongsTo(SpecialAward::class, 'special_award_id');
    }

    public function communityService()
    {
        return $this->belongsTo(CommunityServices::class, 'community_service_id');
    }

    public function timmsAndPisa()
    {
        return $this->belongsTo(TimmsAndPisa::class, 'timms_pisa_id');
    }

    public function nilam()
    {
        return $this->belongsTo(Nilam::class, 'nilam_id');
    }

    // Added classroom relationship
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
