<?php

namespace App\Models;

use App\Enums\PaintingStatus;
use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Painting extends Model
{
    use AddEdit, Logs;
    use SoftDeletes;

    public static $page_icon = '<i class="bi bi-images"></i>';

    public const NEW = 1;
    public const DELIVERY = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'warehouse_id',
        'status',
        'title',
        'url',
        'track_number',
        'description',
        'condition',
        'lot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status'      => PaintingStatus::class,
        'tracking_at' => 'datetime',
        'created_at'  => 'datetime',
    ];

    /**
     * Name of fields
     * @return array {param => label}
     */
    public static function aliases(): array
    {
        return [
            'status'       => 'Статус',
            'user_id'      => 'Кладовщик',
            'warehouse_id' => 'Склад',
            'painting_id'  => 'Картина',
            'auction_id'   => 'Аукцион',
            'code'         => 'Код',
            'title'        => 'Название',
            'url'          => 'Ссылка на аукцион',
            'track_number' => 'Причина отправки и трекинговый номер доставки',
            'description'  => 'Описание',
            'condition'    => 'Состояние',
            'note'         => 'Примечание',
            'lot'          => 'Лот',
            'tracking_at'  => 'Дата отправки',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function sync_images($ids = [])
    {
        $this->images()->sync($ids);
    }
}
