<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\Offer;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Offer $offer;

    public Ad|Post $offerable;

    protected string $mailableMarkdown;

    public string $actionKey;
    /**
     * Create a new message instance.
     */
    public function __construct(Offer $offer, bool $edited = false)
    {
        $this->offer = $offer;
        $this->offerable = $offer->offerables()->first()->offerable;
        if ($this->offerable instanceof Ad) {
            $this->mailableMarkdown = 'mail/partials.ad-offer-created';
        }
        elseif ($this->offerable instanceof Post) {
            $this->mailableMarkdown = 'mail/partials.post-offer-created';
        }
        $this->actionKey = $edited ? 'offer_edited' : 'offer_created';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.$this->actionKey.subject", ['offer' => $this->offer->number]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: $this->mailableMarkdown);
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
