<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'description',
    ];

    public function playersAsMain(): HasMany
    {
        return $this->hasMany(Player::class, 'main_position_id');
    }

    public function playersAsSub(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_position');
    }
}
