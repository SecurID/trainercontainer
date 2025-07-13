<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'prename',
        'lastname',
        'notes',
        'main_position_id',
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function mainPosition(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'main_position_id');
    }

    public function subPositions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'player_position');
    }

    public function getFullname(): string
    {
        return $this->prename . ' ' . $this->lastname;
    }

    public function getFullnameLastFirst(): string
    {
        return $this->lastname . ', ' . $this->prename;
    }
}
