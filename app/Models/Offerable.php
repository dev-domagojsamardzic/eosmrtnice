<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Offerable extends Pivot
{
    use HasFactory;

    protected $table = 'offerables';

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
    public function offerables(): MorphTo
    {
        return $this->morphTo();
    }
}
