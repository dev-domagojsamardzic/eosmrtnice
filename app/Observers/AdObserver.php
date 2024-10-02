<?php

namespace App\Observers;

use App\Mail\AdCreated;
use App\Models\Ad;
use Illuminate\Support\Facades\Mail;

class AdObserver
{
    /**
     * Handle the Ad "created" event.
     */
    public function created(Ad $ad): void
    {
        Mail::to(admin())->queue(new AdCreated($ad));
    }

    /**
     * @param Ad $ad
     * @return void
     */
    public function saving(Ad $ad): void
    {
        // This executes only first time when approved var is changed
        if ($ad->approved && is_null($ad->valid_from)) {
            $ad->valid_from = now();
            $ad->valid_until = now()->addMonths($ad->months_valid);
        }

        // If valid_from exists, means it is approved
        // recalculate valid_to variable
        if (!is_null($ad->valid_from)) {
            $ad->valid_until = $ad->valid_from->addMonths($ad->months_valid);
        }
    }
}
