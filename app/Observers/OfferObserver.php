<?php

namespace App\Observers;

use App\Models\Offer;

class OfferObserver
{
    /**
     * Handle the Offer "created" event.
     */
    public function created(Offer $offer): void
    {
        $offerNo = $offer->generateOfferNumber();
        $offer->number = $offerNo;
        $offer->save();
    }
}
