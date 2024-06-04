<?php

namespace App\Observers;

use App\Models\Deceased;
use Illuminate\Support\Str;

class DeceasedObserver
{
    /**
     * Handle the Deceased "saving" event.
     */
    public function saving(Deceased $deceased): void
    {
        if ($deceased->isDirty(['first_name', 'last_name', 'maiden_name'])) {
            // generate slug from first_name and last_name
            $slug = Str::slug($deceased->first_name.' '.$deceased->last_name.' '.$deceased->maiden_name);
            // find deceaseds with similar slugs
            $similar = Deceased::query()->where('slug', $slug)->count();
            // If there are similar names in DB, add counter as slug suffix
            $slug = ($similar === 0) ? $slug : $slug.'-'.($similar + 1);
            // update slug property
            $deceased->slug = $slug;
        }
    }
}
