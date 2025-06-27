<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    public function ratings(): HasMany
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function getFullname(): string
    {
        return $this->prename . ' ' . $this->lastname;
    }
}
