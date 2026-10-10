<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class LocaleMiddleware
{
    public static function mainLanguage() // основной язык, который не должен отображаться в URl
    {
        return config('app.locale');
    }

    public static function languages() // Указываем, какие языки будем использовать в приложении.
    {
        return array_keys(config('translatable.locales'));
    }

    /*
     * Проверяет наличие корректной метки языка в текущем URL
     * Возвращает метку или значеие null, если нет метки
     */
    public static function getLocale()
    {
        $uri = Request::path(); //получаем URI

        $segmentsURI = explode('/', $uri); //делим на части по разделителю "/"
        // Проверяем метку языка - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::languages())) {
            if ($segmentsURI[0] != self::mainLanguage()) {
                return $segmentsURI[0];
            }
        }
        return null;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function get_name(string $name = 'title'): string
    {
        $lang = self::getLocale() ?? self::mainLanguage();
        return $name . '_' . $lang;
    }

    /*
    * Устанавливает язык приложения в зависимости от метки языка из URL
    */
    public function handle($request, Closure $next)
    {
        $locale = self::getLocale();
        if ($locale) {
            App::setLocale($locale);
        } else {
            App::setLocale(self::mainLanguage()); //если метки нет - устанавливаем основной язык $mainLanguage
        }

        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }

}
