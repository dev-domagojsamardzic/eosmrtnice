<?php

namespace App\Models;

use App\Enums\AdType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read       int                     id
 * @property            int                     company_id
 * @property            string                  title
 * @property            int                     type
 * @property            bool                    approved
 * @property            bool                    active
 * @property            int                     months_valid
 * @property            Carbon                  valid_from
 * @property            Carbon                  valid_until
 * @property            string                  banner
 * @property            string                  caption
 * @property            bool                    expired
 * @property            Carbon                  expired_at
 * @property            Carbon                  created_at
 * @property            Carbon                  updated_at
 * @property            Carbon                  deleted_at
 * --------------------------------------------------------
 * @property-read       string                  fallbackTitle
 * --------------------------------------------------------
 * @property            Company                 company
 * @property            Offer                   offers
 * --------------------------------------------------------
 * @method                                      forDisplay
 */
class Ad extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => AdType::STANDARD,
        'months_valid' => 1,
        'approved' => false,
        'active' => false,
        'expired' => false,
        'expired_at' => null,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => AdType::class,
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Get fallback ad title
     */
    protected function fallbackTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => __('models/ad.ad') . ' ' . $this->type?->name
        );
    }

    /**
     * Company that Ad belongs to
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Owner of company owning the ad
     *
     * @return HasOneThrough
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Company::class, 'id', 'id', 'company_id', 'user_id');
    }

    /**
     * Get the ad's offer
     *
     * @return HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(AdsOffer::class, 'ad_id', 'id');
    }

    /**
     * Scope a query to only include posts that can be displayed
     */
    public function scopeForDisplay(Builder $query): void
    {
        $query->where('active', 1)
            ->where('approved', 1)
            ->where('valid_from', '<=', now()->toDateString())
            ->where('valid_until', '>=', now()->toDateString());
    }
}
