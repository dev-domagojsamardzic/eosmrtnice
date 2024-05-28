<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read       int         id
 * @property            int         offer_id
 * @property            string      offerable_type
 * @property            int         offerable_id
 * @property            int         quantity
 * @property            float       price
 */
class Offerable extends Pivot
{
    use HasFactory;

    protected $table = 'offerables';

    public $timestamps = false;

    protected $attributes = [
        'quantity' => 1,
    ];
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    /**
     * Define polymorphic relationship
     * @return MorphTo
     */
    public function offerable(): MorphTo
    {
        return $this->morphTo();
    }
}
