<?php

namespace App\Models;

use App\Models\Scopes\AdsOfferScope;

class AdsOffer extends Offer
{
    protected string $pdfView = 'pdf.ads-offer';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new AdsOfferScope);
    }
}
