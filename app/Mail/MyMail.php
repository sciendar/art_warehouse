<?php

namespace App\Mail;

use App\Models\SendEmail;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use ReflectionException;

class MyMail extends Mail
{
    protected string $to;
    protected string $cc = '';
    protected string $bcc = '';

    public function __construct()
    {
    }

    /**
     * Set the recipients of the message.
     *
     * @param array|string $users
     * @return $this
     */
    public function to(array|string $users): static
    {
        $this->to = $this->emails($users);
        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param array|string $users
     * @return $this
     */
    public function cc(array|string $users): static
    {
        $this->cc = $this->emails($users);
        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param array|string $users
     * @return $this
     */
    public function bcc(array|string $users): static
    {
        $this->bcc = $this->emails($users);
        return $this;
    }

    /**
     * @param array|string $users
     * @return string
     */
    public function emails(array|string $users): string
    {
        return is_array($users)
            ? implode(',', $users)
            : $users;
    }

    /**
     * Send a new mailable message instance.
     * @param $class
     * @return bool
     * @throws ReflectionException
     * @throws ConnectionException
     */
    public function send($class): bool
    {
        $send = SendEmail::fix(get_class($class), $this->to, $class->render());
// TODO установить свой метод
        $data = [
            "From"          => $class->envelope()->from->name . '<' . $class->envelope()->from->address . '>',
            "To"            => $this->to,
            "Cc"            => $this->cc,
            "Bcc"           => $this->bcc,
            "Subject"       => $class->envelope()->subject,
            "HtmlBody"      => $class->render(),
            "ReplyTo"       => $class->envelope()->from->address,
            "TrackOpens"    => true,
            "TrackLinks"    => "HtmlOnly",
            "MessageStream" => "outbound"
        ];

        try {
            Mail::to($this->to)->send(new BidApproved($bid));

            $send->is_sent = true;
            $send->save();

            return true;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
