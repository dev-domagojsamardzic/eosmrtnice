<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read   int         id
 * @property        int         county_id
 * @property        string      title
 * ------------------------------------------
 * @property        County      county
 */

class City extends Model
{
    use HasFactory;

    /**
     * City's county
     * @return BelongsTo
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
