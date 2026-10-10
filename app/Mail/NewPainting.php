<?php

namespace App\Mail;

use App\Models\Painting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPainting extends Mailable
{
    use Queueable, SerializesModels;

    public Painting $painting;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @param Painting $painting
     * @param User $user
     */
    public function __construct(Painting $painting, User $user)
    {
        $this->painting = $painting;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address(config('app.MAIL_FROM_ADDRESS'), config('app.APP_NAME')),
            subject: ($this->user)->name . ' добавил новую картину',
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
            view: 'emails.new_painting',
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
