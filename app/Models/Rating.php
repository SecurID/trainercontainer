<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    public function casts()
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo('App\Models\Player');
    }
}
