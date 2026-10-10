<?php

namespace App\Helpers;

use App\Mail\MyMail;
use App\Mail\SendError;
use App\Mail\SendErrorText;
use App\Models\SendEmail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Errors
{
    public function __construct(string $error, string $dop = null, $is_send = false)
    {
        try {
            throw new Exception($error);
        } catch (Exception $e) {
            $trace = $e->getTrace()[1] ?? null;

            // Формируем текст для лога
            $message = sprintf(
                'ERROR: %s<br> %s<br>class: %s<br>function: %s<br>line: %s',
                $error,
                $dop ?? null,
                $trace['class'] ?? '???',
                $trace['function'] ?? '???',
                $trace['line'] ?? '???'
            );

            Log::error($message);

            // Отправка email с обработкой ошибок
            $this->send_error_email($error, $message, $is_send);
        }
    }

    public function send_error_email(string $error, string $message, $is_send): void
    {
        if ($is_send) {
            try {
                (new MyMail())
                    ->to(config('mail.error_recipient', 'demy2@ukr.net'))// TODO изменить на нужное
                    ->send(new SendErrorText($error, $message));
            } catch (Exception $e) {
                Log::error('Failed to send error email: ' . $e->getMessage());
            }
        }
    }
}
