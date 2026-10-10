<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property $prefix string
 * @property $page_title string
 * @property $page_icon string
 * @method fill($fields)
 */
trait Logs
{
    // Logging changes
    use LogsActivity;

    /**
     * Logging changes
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->logExcept([
                'created_at',
                'updated_at',
            ]);
    }
}
