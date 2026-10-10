<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use AddEdit, Logs;

    public static $page_icon = '<i class="bi bi-file-earmark-break"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'path',
    ];

    use Translatable;
    public $translatedAttributes = [
        'title',
    ];
}
