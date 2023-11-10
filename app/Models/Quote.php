<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
    ];

    protected $casts = [
        'date' => 'date:d.m.Y',
    ];

    public function valutes()
    {
        return $this->hasMany(Valute::class);
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getDate(): string
    {
        return $this->getAttribute('date');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }
}
