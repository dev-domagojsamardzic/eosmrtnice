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
}
