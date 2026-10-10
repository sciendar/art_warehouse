<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use AddEdit, Logs;

    public static $page_icon = '<i class="bi bi-file-earmark-break"></i>';

    public const STOREKEEPER = 3;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name'
    ];
}
