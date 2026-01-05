<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    public const FORMATIONS = [
        '4-4-2',
        '4-3-3',
        '4-2-3-1',
        '3-5-2',
        '5-3-2',
        '4-1-4-1',
        '3-4-3',
        '4-5-1',
        '5-4-1',
        '3-4-2-1',
    ];

    protected $fillable = [
        'opponent_id',
        'opponent_formation',
        'date',
        'time',
        'location',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function opponent(): BelongsTo
    {
        return $this->belongsTo(Opponent::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
