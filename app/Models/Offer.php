<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read       int         id
 * @property            string      number
 * @property            Carbon      for_date
 * @property            int         user_id
 * @property            float       net_total
 * @property            float       taxes
 * @property            float       total
 * @property            Carbon      created_at
 * @property            Carbon      updated_at
 */
class Offer extends Model
{
    protected $casts = [
        'net_total' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the parent offerable model (ad).
     */
    public function offerable(): MorphTo
    {
        return $this->morphTo();
    }
}
