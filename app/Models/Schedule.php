<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'coaches',
        'playerCount',
        'goalkeeperCount',
        'exercise_id',
        'practice_id',
        'time',
    ];

    public function exercise(): HasOne
    {
        return $this->hasOne('App\Models\Exercise');
    }

    public function practice(): HasOne
    {
        return $this->hasOne('App\Models\Practice');
    }
}
