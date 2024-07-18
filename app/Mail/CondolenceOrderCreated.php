<?php

namespace App\Mail;

use App\Models\Condolence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CondolenceOrderCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Condolence $condolence;

    /**
     * Create a new message instance.
     */
    public function __construct(Condolence $condolence)
    {
        $this->condolence = $condolence;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.condolence_order_created.subject", [
                'number' => $this->condolence->number,
            ]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail/partials.condolence-order-created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
