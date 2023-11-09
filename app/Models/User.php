<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'api_token'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getApiToken(): string
    {
        return $this->getAttribute('api_token');
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public static function generateApiToken(): string
    {
        do {
            $key = Str::random(32);
        } while (self::where('api_token', $key)->exists());

        return $key;
    }
}
