<?php

namespace App\Models;

use App\Models\Scopes\AdsOfferScope;
use App\Models\Scopes\PostsOfferScope;

class PostsOffer extends Offer
{
    protected string $pdfView = 'pdf.posts-offer';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new PostsOfferScope);
    }
}
