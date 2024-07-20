<?php

namespace App\Models;

use App\Models\Scopes\CondolencesOfferScope;

class CondolencesOffer extends Offer
{
    protected string $pdfView = 'pdf.condolences-offer';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CondolencesOfferScope);
    }
}
