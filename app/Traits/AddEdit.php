<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * @property-read string $prefix
 * @property $page_title string
 * @property $page_icon string
 * @mixin Model
 * @method fill($fields)
 */
trait AddEdit
{
//    public static function add($fields): static // Добавление
//    {
//        $add = new static;
//        $add->fill($fields);
//
//        return $add;
//    }


    /**
     * Форматирование даты
     * @param string $attribute
     * @param string $format
     * @return string|null
     */
    public function date_format(string $attribute = 'created_at', string $format = 'Y.m.d'): ?string
    {
        return $this->$attribute instanceof Carbon
            ? $this->$attribute->format($format)
            : null;
    }

    /**
     * Форматирование даты и времени
     * @param string $attribute
     * @param string $separator
     * @param string $format
     * @return string|null
     */
    public function date_time_format(string $attribute = 'created_at', string $separator = '<br>', string $format = 'Y.m.d'): ?string
    {
        return $this->$attribute instanceof Carbon
            ? $this->$attribute->format($format) . $separator . $this->$attribute->format('H:i:s')
            : null;
    }

    public function edit($fields): static // Изменение
    {
        $this->fill($fields);
        return $this;
    }

    public function views($key, $time = 3600)
    {
        if (!Cache::has($key)) {
            Cache::put($key, 'true', $time);
            $this->increment('views');
            return true;
        }
        return false;
    }

    public function get_i_image($i = 0): string
    {
        if (is_array($this->images) && count($this->images)) {
            $images = $this->images;
        }
        return $images[$i] ?? 'admin/assets/images/no_image.jpg';
    }

    public function get_images(): array
    {
        return (is_array($this->images) && count($this->images))
            ? $this->images
            : [];
    }

    /**
     * Данные для меню
     * @param int|null $count
     * @return array
     */
    public static function menu($count = null): array
    {
        return [
            'titles' => static::titles(),
            'title'  => static::title(),
            'route'  => static::route(),
            'icon'   => static::icon(),
            'count'  => $count,
        ];
    }

    /**
     * Заголовок модели
     * @return string
     */
    protected static function title(): string
    {
        return static::$page_title ?? Str::of(static::class())
            ->snake()
            ->ucfirst()
            ->replace('_', ' ');
    }

    /**
     * Заголовок модели
     * @return string
     */
    protected static function titles(): string
    {
        return Str::of(static::title())->plural();
    }

    /**
     * Иконка модели
     * @return string
     */
    protected static function icon(): string
    {
        return static::$page_icon ?? '<i class="bi bi-dot"></i>';
    }

    /**
     * Префикс маршрутов
     * @return string
     */
    protected static function prefix(): string
    {
        return static::$prefix ?? 'admin';
    }

    /**
     * Имя класса без неймспейса
     * @return string
     */
    protected static function class(): string
    {
        return Str::afterLast(static::class, '\\');
    }

    /**
     * Имя класса без неймспейса
     * @return string
     */
    protected static function name(): string
    {
        return Str::of(static::class())
            ->snake();
    }

    /**
     * ???Человекочитаемое название во множественном числе
     * @return string
     */
    protected static function names(): string
    {
        return Str::of(static::name())
            ->plural();
    }

    /**
     * Путь к директории с представлениями
     * @param string|null $suffix
     * @return string
     */
    protected static function folder(?string $suffix = null): string
    {
        $base = static::prefix() . '.' . Str::of(static::names())->lower();
        return $suffix ? $base . '.' . $suffix : $base;
    }

    /**
     * Имя маршрута
     * @param string|null $suffix
     * @return string
     */
    public static function route(?string $suffix = null): string
    {
        $base = static::prefix() . '.' . Str::of(static::names())->lower();
        return $suffix ? $base . '.' . $suffix : $base;
    }

    /**
     * Имя переменной в представлениях
     * @return string
     */
    public static function var(): string
    {
        return Str::of(static::class())->lower();
    }

    /**
     * @param string $key
     * @return string
     */
    public static function alias(string $key): string
    {
        return (static::aliases())[$key] ?? '';
    }

    /**
     * Массив алиасов (должен быть переопределен в модели)
     * @return array {
     *     param: label
     * }
     */
    protected static function aliases(): array
    {
        return [];
    }

    protected static function cell_headers($key): string
    {
        return match ($key) {
            '№' => '№',
            '#' => '#ID',
            'actions' => '<span class="text-primary mx-2" data-bs-toggle="tooltip" title="Действия"><i class="bi bi-gear"></i></span>',
            'position' => '<span class="text-primary mx-2" data-bs-toggle="tooltip" title="Позиция"><i class="bi bi-arrow-down-up"></i></span>',
            'langs' => '<span class="text-primary mx-2" data-bs-toggle="tooltip" title="Языки"><i class="bi bi-translate"></i></span>',
            default => $key
        };
    }
}
