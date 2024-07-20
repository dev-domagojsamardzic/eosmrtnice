<?php

namespace App\Mail;

use App\Models\Condolence;
use App\Models\CondolencesOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CondolencesOfferCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public CondolencesOffer $condolences_offer;

    public Condolence $condolence;

    public string $actionKey;
    /**
     * Create a new message instance.
     */
    public function __construct(CondolencesOffer $condolences_offer, bool $edited = false)
    {
        $this->condolences_offer = $condolences_offer;
        $this->actionKey = $edited ? 'offer_edited' : 'offer_created';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.$this->actionKey.subject", ['offer' => $this->condolences_offer->number]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: 'mail/partials.condolences-offer-created');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->condolences_offer->toRawPdf(), $this->condolences_offer->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
