<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFeedback extends Model
{
    protected $table = 'news_feedback';

    protected $fillable = [
        'user_id',
        'scope',
        'target_key',
        'action',
        'categories',
        'sources',
    ];

    protected function casts(): array
    {
        return [
            'categories' => 'array',
            'sources' => 'array',
        ];
    }
}
