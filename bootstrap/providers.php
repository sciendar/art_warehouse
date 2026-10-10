<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider::class,
];
