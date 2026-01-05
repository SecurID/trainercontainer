<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
        'description',
    ];

    /**
     * @return HasMany<Player, $this>
     */
    public function playersAsMain(): HasMany
    {
        return $this->hasMany(Player::class, 'main_position_id');
    }

    /**
     * @return BelongsToMany<Player, $this>
     */
    public function playersAsSub(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_position');
    }
}
