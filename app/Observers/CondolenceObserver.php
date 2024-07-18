<?php

namespace App\Observers;

use App\Mail\CondolenceOrderCreated;
use App\Mail\CondolenceOrderReceived;
use App\Models\Condolence;
use Illuminate\Support\Facades\Mail;

class CondolenceObserver
{
    /**
     * Handle the Condolence "created" event.
     */
    public function created(Condolence $condolence): void
    {
        // Mail for user that created condolence
        $email = trim($condolence->sender_email);
        Mail::to($email)->queue(new CondolenceOrderReceived($condolence));

        // Send mail to admin that new condolence order has arrived
        Mail::to(admin()->email)->queue(new CondolenceOrderCreated($condolence));
    }
}
