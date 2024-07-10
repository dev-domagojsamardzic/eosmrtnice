<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\AdsOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdsOfferCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public AdsOffer $ads_offer;

    public Ad $ad;

    public string $actionKey;
    /**
     * Create a new message instance.
     */
    public function __construct(AdsOffer $ads_offer, bool $edited = false)
    {
        $this->ads_offer = $ads_offer;
        $this->actionKey = $edited ? 'offer_edited' : 'offer_created';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.$this->actionKey.subject", ['offer' => $this->ads_offer->number]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: 'mail/partials.ad-offer-created');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->ads_offer->toRawPdf(), $this->ads_offer->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
