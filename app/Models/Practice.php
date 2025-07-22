<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Practice extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'topic',
        'notes',
        'user_id',
    ];

    public function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->HasMany(Schedule::class);
    }

}
