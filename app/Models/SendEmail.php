<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendEmail extends Model
{
    protected $fillable = [
        'num',
        'class',
        'email',
        'code',
    ];

    public static function fix(string $class, string $email, string $code): self
    {
        return self::query()->create([
            'num' => random_int(111, 999),
            'class' => $class,
            'email' => $email,
            'code' => $code,
        ]);
    }
}
