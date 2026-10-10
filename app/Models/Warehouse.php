<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use AddEdit, Logs;

    public static $page_icon = '<i class="bi bi-building"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'title',
        'city',
        'address'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    /**
     * Name of fields
     * @return array {param => label}
     */
    public static function aliases(): array
    {
        return [
            'code'       => 'Уникальный код',
            'title'      => 'Название',
            'country_id' => 'Страна',
            'city'       => 'Город',
            'address'    => 'Адрес'
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function paintings()
    {
        return $this->hasMany(Painting::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
