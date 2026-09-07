<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ModelsConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array $ownModels lista nazw modeli właściciela konta
     * @param array $learners lista [ 'name' => string, 'models' => array<string> ] dla uczniów z niepotwierdzonymi modelami
     */
    public function __construct(
        public array $ownModels,
        public array $learners,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potwierdzamy rejestrację modeli na twoim koncie',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.models-confirmation',
            with: [
                'ownModels' => $this->ownModels,
                'learners' => $this->learners,
            ],
        );
    }
}
