<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Translates
{
    public static function trans($name = 'title')
    {
        $lang = array_key_exists(App::getLocale(), config('app.locales'))
            ? App::getLocale()
            : config('app.locale');
        $name .= '_' . $lang;
        return $name;
    }

    public function lang($name = 'title')
    {
        $lang_name = $this->trans($name);

        $lang_name = isset($this->$lang_name)
            ? $lang_name
            : ($name . '_' . 'en');

        return $this->$lang_name;
    }
}
