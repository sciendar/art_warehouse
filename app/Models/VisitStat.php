<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitStat extends Model
{
    protected $fillable = [
        'date',
        'hour',
        'path',
        'visits_count',
        'unique_visitors',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'hour' => 'integer',
            'visits_count' => 'integer',
            'unique_visitors' => 'integer',
        ];
    }
}
