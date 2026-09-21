<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function canEditIdeas(): bool
    {
        return in_array($this->role, ['admin', 'moderator'], true);
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'user' => 'Пользователь',
            default => 'Пользователь',
        };
    }
}
