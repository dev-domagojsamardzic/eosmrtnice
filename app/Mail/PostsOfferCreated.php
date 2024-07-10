<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\AdsOffer;
use App\Models\Post;
use App\Models\PostsOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostsOfferCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public PostsOffer $posts_offer;

    public Post $post;

    public string $actionKey;
    /**
     * Create a new message instance.
     */
    public function __construct(PostsOffer $posts_offer, bool $edited = false)
    {
        $this->posts_offer = $posts_offer;
        $this->actionKey = $edited ? 'offer_edited' : 'offer_created';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('eosmrtnice.mail_from_address'),
            subject: __("mail.$this->actionKey.subject", ['offer' => $this->posts_offer->number]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: 'mail/partials.post-offer-created');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->posts_offer->toRawPdf(), $this->posts_offer->number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
