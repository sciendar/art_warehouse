<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitDaysStat extends Model
{
    protected $fillable = [
        'page_id',
        'date',
        'hour',
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
