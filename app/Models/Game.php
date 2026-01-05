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

    /**
     * @var list<string>
     */
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

    /**
     * @var list<string>
     */
    protected $fillable = [
        'opponent_id',
        'opponent_formation',
        'date',
        'time',
        'location',
        'notes',
        'user_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Opponent, $this>
     */
    public function opponent(): BelongsTo
    {
        return $this->belongsTo(Opponent::class);
    }

    /**
     * @return HasMany<Rating, $this>
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
