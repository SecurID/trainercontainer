<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}
