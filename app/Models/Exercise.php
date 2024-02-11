<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'focus',
        'material',
        'procedure',
        'coaching',
        'duration',
        'image',
        'intensity',
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
}
