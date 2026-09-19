<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartupIdea extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
    ];
}
