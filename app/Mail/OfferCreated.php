<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Offer $offer;
    public bool $edited;
    /**
     * Create a new message instance.
     */
    public function __construct(Offer $offer, bool $edited = false)
    {
        $this->offer = $offer;
        $this->key = $edited ? 'offer_edited' : 'offer_created';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.$this->key.subject", ['offer' => $this->offer->number]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.offer-created',
            with: ['key' => $this->key],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->offer->toRawPdf(), $this->offer->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
