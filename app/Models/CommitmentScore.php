<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommitmentScore extends Model
{
    protected $fillable = [
        'commitment_name',
        'description',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function evaluations(): BelongsToMany
    {
        return $this->belongsToMany(Evaluation::class, 'commitment_evaluation')
            ->withTimestamps();
    }
}
