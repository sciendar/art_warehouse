<?php

namespace App\Services;

use App\Helpers\Errors;
use DeepL\DeepLClient;
use DeepL\DeepLException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class DeeplTranslate
{
    public mixed $deepl_client;

    /**
     * @throws DeepLException
     */
    public function __construct()
    {
        $authKey            = config('app.DEEPL_AUTH_KEY');
        $this->deepl_client = new DeepLClient($authKey);
    }

    public function translate_text($text, $lang)
    {
        return is_string($text) && Str::length($text) > 1
            ? $this->deepl_client->translateText($text, null, $lang)->text
            : $text;
    }

    public function item_translate($params, $item, $class_translation, $lang_translation)
    {
        $parent_id = $class_translation::PARENT_ID;

        $item_us = $class_translation::where($parent_id, $item->$parent_id)
            ->where('locale', 'en-us')
            ->first();
        if ($params == null) {
            return $this->get_response('error', 'No data found for translation. id: ' . $item->$parent_id);
        }
        if ($item_us) {
            foreach ($params as $key => $param) {
                if (is_array($param)) {
                    if (is_array($item_us->$key)) {
                        foreach ($item_us->$key as $k => $v) {
                            try {
                                if (is_array($v)) {
                                    foreach ($v as $k2 => $v2) {
                                        $datas[$k][$k2] = $this->translate_or_param($param, $lang_translation, $k2, $v2);
                                    }
                                } else {
                                    $datas[$k] = $this->translate_or_param($param, $lang_translation, $k, $v);
                                }
                            } catch (\Exception $e) {
//                    dd($e->getMessage(), $key, $param, $item_us->$key, $item->$key);
                                return $this->get_response('error', $e->getMessage() . '. ' . $class_translation . '. ' .  $parent_id. ': ' . $item->$parent_id);
                            }
                        }
                        $item->$key = $datas ?? [];
                    } else {
                        $item->$key = $item_us->$key; // TODO !!!!!!!!
                    }
                } else {
                    try {
                        $item->$param = (new DeeplTranslate())->translate_text($item_us->$param, $lang_translation);
                    } catch (\Exception $e) {
//                    dd($e->getMessage(), $key, $param, $item_us->$key, $item->$key);
                        return $this->get_response('error', $e->getMessage() . '. id: ' . $item->$parent_id);
                    }
                }
            }

            if ($item->isDirty()) {
                $item->translate_at = now();
                $item->save();
                return $this->get_response('success', 'Information saved');
            }
        }
        return $this->get_response('success', 'Successful, but nothing updated');
    }

    public function mass_translate($class_translation, $lang_translation)
    {
        $parent_id = $class_translation::PARENT_ID;

        $parent_class = 'App\Models\\' . $class_translation::PARENT_MODEL;
        $max_id = $parent_class::max('id');
        $is_error = $class_translation::where($parent_id, '>', $max_id)
            ->exists();
        if ($is_error) {
            new Errors(get_class(), debug_backtrace(), 'В переводах есть варианты для несуществующих PARENT_ID. ' . $class_translation . '. ' . $lang_translation);
        }

        $items = $class_translation::where('locale', $lang_translation)
            ->where($parent_id, '<=', $max_id)
            ->where(function (Builder $query) {
                return $query->whereNull('translate_at')
                    ->orWhere('translate_at', '<', now()->subMonth());
            })
            ->get();
        $params = $class_translation::auto_translations();
        foreach ($items as $item) {
            $response = $this->item_translate($params, $item, $class_translation, $lang_translation);
            if ($response['status'] == 'error') {
                return $response;
            }
        }
        return $this->get_response('success', 'Information saved. Update ' . $items->count() . ' items');
    }

    public function translate_or_param($param, $lang, $k, $v)
    {
        return (in_array($k, array_keys($param)) || in_array($k, $param)) && is_string($v)
            ? (new DeeplTranslate())->translate_text($v, $lang)
            : $v;
    }

    public function get_response($status, $message): array
    {
        return [
            'status'  => $status,
            'message' => $message
        ];
    }
}
