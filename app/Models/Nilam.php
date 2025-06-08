<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilam extends Model
{
    protected $fillable = [
        'achievement_id',
        'tier_id',
        'name',
        'point',
    ];

    public function extra_cocu(){
        return $this->belongsTo(ExtraCocuricullum::class, 'nilam_id');
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}