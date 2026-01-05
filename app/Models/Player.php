<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'prename',
        'lastname',
        'notes',
        'main_position_id',
    ];

    /**
     * @return HasMany<Rating, $this>
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Position, $this>
     */
    public function mainPosition(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'main_position_id');
    }

    /**
     * @return BelongsToMany<Position, $this>
     */
    public function subPositions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'player_position');
    }

    public function getFullname(): string
    {
        return $this->prename.' '.$this->lastname;
    }

    public function getFullnameLastFirst(): string
    {
        return $this->lastname.', '.$this->prename;
    }
}
