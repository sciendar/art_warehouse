<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class Author extends Model
{
    use AddEdit, Logs;

    public static $page_icon = '<i class="bi bi-bounding-box-circles"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

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
            'text' => 'Состояние',
        ];
    }

    public static function pars_data()
    {
        $data = Http::get('https://art-torg.com/get_conditions');
        if ($data->failed()) {
            dd($data->body());
        }
        foreach ($data->json() as $item) {
            $new_item = Author::where('id', $item['id'])->first();
            if (!$new_item) {
                $new_item = new Author();
            }
            $new_item->is_active  = $item['status'];
            $new_item->created_at = $item['created_at'];
            $new_item->updated_at = $item['updated_at'];
            $new_item->save();

            try {
                $new_item->save();
            } catch (Exception $e) {
                dd($e->getMessage());
            }

            $locales = Locale::pluck('short');
            foreach ($locales as $locale) {
                $new_item_translation = ConditionTranslation::where('locale', $locale)
                    ->where('condition_id', $item['id'])
                    ->first();
                if (!$new_item_translation) {
                    $new_item_translation               = new ConditionTranslation();
                    $new_item_translation->locale       = $locale;
                    $new_item_translation->condition_id = $new_item->id;
                }
                $new_item_translation->title = $item['title_' . $locale] ?? null;
                try {
                    if ($new_item_translation->title != null) {
                        $new_item_translation->save();
                    }
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
}
