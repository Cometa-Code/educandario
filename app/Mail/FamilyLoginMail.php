<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class FamilyLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $magicLink;
    public $responsableName;
    /**
     * Create a new message instance.
     */
    public function __construct($responsableName, $magicLink)
    {
        $this->responsableName = $responsableName;
        $this->magicLink = $magicLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: env('MAIL_SUBJECT_TITLE'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.family-mail-login',
            with: [
                'responsableName' => $this->responsableName,
                'magicLink' => $this->magicLink
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
