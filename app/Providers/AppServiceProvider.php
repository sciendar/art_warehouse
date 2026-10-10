<?php

namespace App\Providers;

use App\Models\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->fix_send_emails();

        $DEF_IMAGE = 'admin/assets/images/no_image.jpg';
        $NO_DATA = '<span class="text-danger">Нет данных</span>';

        View::share(compact('DEF_IMAGE', 'NO_DATA'));
    }

    public function fix_send_emails()
    {
        Mail::macro('send_email', function ($mailable, array|string $emails) {
            $emails = is_array($emails)
                ? implode(',', $emails)
                : $emails;

            // Сохраняем в БД перед отправкой
            $send = SendEmail::fix(get_class($mailable), $emails, $mailable->render());

            try {
                // Отправляем письмо
                $send->is_sent = true;
                $send->save();

                return Mail::to($emails)->send($mailable);
            } catch (\Exception $exception) {
                $send->is_sent = false;
                $send->save();
            }
        });
    }
}
