<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use AddEdit, Logs;

    public static $page_icon = '<i class="bi bi-router"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'country',
        'region',
        'city',
        'lat',
        'lon',
        'is_active',
        'is_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_admin'  => 'boolean',
        'lat'       => 'float',
        'lon'       => 'float',
    ];
}
