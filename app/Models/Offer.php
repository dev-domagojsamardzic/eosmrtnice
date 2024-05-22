<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read       int                     id
 * @property            string                  number
 * @property            int                     company_id
 * @property            float                   net_total
 * @property            float                   taxes
 * @property            float                   total
 * @property            Carbon                  valid_from
 * @property            Carbon                  valid_until
 * @property            Carbon                  created_at
 * @property            Carbon                  updated_at
 * ------------------------------------------------------------
 * ------------------------------------------------------------
 * @property            Collection|Ad               ads
 * @property            Collection|Offerable        offerables
 */
class Offer extends Model
{
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'net_total' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Return (offerables) ads that belong to single offer
     * @return MorphToMany
     */
    public function ads(): MorphToMany
    {
        return $this->morphedByMany(Ad::class, 'offerable')->withPivot(['quantity', 'price']);
    }

    /**
     * Return offerables that belong to
     * @return HasMany
     */
    public function offerables(): HasMany
    {
        return $this->hasMany(Offerable::class)->with('offerables');
    }


    /**
     * Scope a query to only include valid offers
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid_from', '<=', now()->toDateString())
            ->where('valid_until', '>=', now()->toDateString());
    }
}
