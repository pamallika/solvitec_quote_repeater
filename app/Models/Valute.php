<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valute extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'num_code',
        'char_code',
        'name',
        'value',
        'vunit_rate',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }
}
