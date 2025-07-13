<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'focus',
        'material',
        'procedure',
        'coaching',
        'duration',
        'intensity',
        'image',
        'playerCount',
        'goalkeeperCount',
        'level',
        'age',
        'user_id',
    ];

    public function practices(): BelongsToMany
    {
        return $this->belongsToMany('App\Roles\Practice');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
