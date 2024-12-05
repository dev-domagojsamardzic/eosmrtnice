<?php

namespace App\Observers;

use App\Models\Offer;
use Illuminate\Support\Str;

class OfferObserver
{
    /**
     * Handle the Offer "created" event.
     */
    public function created(Offer $offer): void
    {
        $offer->number = Str::padLeft($offer->id, 5, '0') . '/web1/' . now()->format('m-Y');
        $offer->save();
    }
}
