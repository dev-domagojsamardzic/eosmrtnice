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
        $offer->number = $offer->id . '/web1/' . now()->format('Y');
        $offer->save();
    }
}
