<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read       int                 id
 * @property            int                 company_id
 * @property            string              number
 * @property            float               net_total
 * @property            float               taxes
 * @property            float               total
 * @property            Carbon              valid_from
 * @property            Carbon              valid_until
 * @property            bool                confirmed
 * @property            Carbon              sent_at
 * @property            Carbon              created_at
 * @property            Carbon              updated_at
 * @property            Carbon              deleted_at
 *  ------------------------------------------------------------
 * @property-read       bool                is_valid
 *  ------------------------------------------------------------
 * @property            Company             company
 */
class AdsOffer extends Model
{
    use SoftDeletes;

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'sent_at' => 'datetime',
        'net_total' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected $attributes = [
        'number' => 'P',
    ];

    /**
     * Return company related to offer
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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
     * Is offer valid
     */
    protected function isValid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->valid_from->startOfDay()->lt(now()) &&
                $this->valid_until->endOfDay()->gt(now())
        );
    }
}
