<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPreference extends Model
{
    protected $fillable = [
        'user_id',
        'categories',
        'min_importance',
    ];

    protected function casts(): array
    {
        return [
            'categories' => 'array',
            'min_importance' => 'float',
        ];
    }
}
