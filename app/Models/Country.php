<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class Country extends Model
{
    use AddEdit, Logs;

    public static $page_title = 'Страны';
    public static $page_icon = '<i class="bi bi-geo-alt"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
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
            'title'          => 'Название',
            'created_at'     => 'Дата',
        ];
    }

//    public static function pars_data()
//    {
//        $response = Http::get('https://art-torg.com/get_countries');
//        if ($response->failed()) {
//            dd($response->body());
//        }
//        foreach ($response->json() as $item) {
//            $new_item = Country::where('id', $item['id'])
//                ->first();
//            if (!$new_item) {
//                $new_item = new Country();
//            }
//            $new_item->id             = $item['id'];
//            $new_item->is_active      = $item['is_active'];
//            $new_item->delivery_group = $item['delivery_group'];
//            $new_item->created_at     = $item['created_at'];
//            $new_item->updated_at     = $item['updated_at'];
//
//            try {
//                $new_item->save();
//            } catch (Exception $e) {
//                dd($e->getMessage());
//            }
//
//            $locales = Locale::pluck('short');
//            foreach ($locales as $locale) {
//                $new_item_translation = CountryTranslation::where('locale', $locale)
//                    ->where('country_id', $item['id'])
//                    ->first();
//                if (!$new_item_translation) {
//                    $new_item_translation             = new CountryTranslation();
//                    $new_item_translation->locale     = $locale;
//                    $new_item_translation->country_id = $new_item->id;
//                }
//                $new_item_translation->title = $item['title_' . $locale] ?? null;
//                try {
//                    $new_item_translation->save();
//                } catch (Exception $e) {
//                    dd($e->getMessage());
//                }
//            }
//        }
//    }
}
