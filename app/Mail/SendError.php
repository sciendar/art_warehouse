<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendError extends Mailable
{
    use Queueable, SerializesModels;

    public Exception $e;
    public string|null $place;
    public string|null $dop;

    /**
     * Create a new message instance.
     *
     * @param Exception $e
     */
    public function __construct(Exception $e, $place = null, $dop = null)
    {
        $this->e = $e;
        $this->place = $place;
        $this->dop = $dop;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Error in ArtTorg',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.send_error',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
