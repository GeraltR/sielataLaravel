<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'] ?? 'Wiadomość z sielata.com.pl',
            replyTo: [$this->data['email']],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
            with: $this->data,
        );
    }
}