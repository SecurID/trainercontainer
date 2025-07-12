<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'practice_id',
        'player_id',
        'user_id',
        'rating',
        'attended',
    ];

    protected $casts = [
        'attended' => 'boolean',
        'date' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function practice(): BelongsTo
    {
        return $this->belongsTo('App\Models\Practice');
    }
}
