<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'prename',
        'lastname',
        'notes'
    ];


    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }
}
