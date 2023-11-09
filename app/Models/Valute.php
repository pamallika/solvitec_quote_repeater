<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valute extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'valutes'
    ];

    protected $casts = [
        'date' => 'date:d.m.Y',
        'valutes' => 'array',
    ];

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

    public function getValutes()
    {
        return $this->getAttribute('valutes');
    }
}
