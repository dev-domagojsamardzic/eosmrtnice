<?php

namespace App\Models;

use App\Observers\OfferObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 *
 * ---------------------------------------------------------------
 * !IMPORTANT
 * Example on how to get the collection of offerables no matter the type
 * $offer->offerables->pluck('offerable');
 */

#[ObservedBy([OfferObserver::class])]
class Offer extends Model
{
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'net_total' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected $attributes = [
        'number' => 'O',
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
     * Return company related to offer
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Return offerables that belong to an offer
     * @return HasMany
     */
    public function offerables(): HasMany
    {
        return $this->hasMany(Offerable::class)->with('offerable');
    }

    /**
     * Scope a query to only include valid offers
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid_from', '<=', now()->toDateString())
            ->where('valid_until', '>=', now()->toDateString());
    }

    /**
     * Generate offer number
     *
     * @return string
     */
    public function generateOfferNumber(): string
    {
        $prefix = "O";

        if ($this->ads->isNotEmpty()) {
            $prefix = "OA";
        }

        return $prefix . "-" . str_pad($this->id + 1, 5, '0', STR_PAD_LEFT) . "-" . $this->created_at->format("m/Y");
    }
}
