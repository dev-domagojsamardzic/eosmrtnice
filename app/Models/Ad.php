<?php

namespace App\Models;

use App\Enums\AdType;
use App\Enums\CompanyType;
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
 * @property            int                     city_id
 * @property            int                     type
 * @property            int                     company_type
 * @property            string                  title
 * @property            bool                    approved
 * @property            bool                    active
 * @property            int                     months_valid
 * @property            string                  company_title
 * @property            string                  company_address
 * @property            string                  company_phone
 * @property            string                  company_mobile_phone
 * @property            string                  company_website
 * @property            string                  logo
 * @property            string                  banner
 * @property            string                  caption
 * @property            Carbon                  valid_from
 * @property            Carbon                  valid_until
 * @property            Carbon                  expired_at
 * @property            Carbon                  created_at
 * @property            Carbon                  updated_at
 * @property            Carbon                  deleted_at
 * --------------------------------------------------------
 * @property-read       string                  fallbackTitle
 * @property-read       string                  alternative_logo
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
        'company_type' => CompanyType::FUNERAL,
        'months_valid' => 1,
        'approved' => false,
        'active' => false,
        'expired_at' => null,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => AdType::class,
        'company_type' => CompanyType::class,
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'expired_at' => 'datetime',
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
     * City the ad company is located
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
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
            ->where('valid_until', '>=', now()->toDateString())
            ->whereNull('expired_at');
    }

    /**
     * Get alternative logo based on company type
     */
    protected function alternativeLogo(): Attribute
    {
        return Attribute::make(
            get: fn() => match($this->company_type) {
                CompanyType::FUNERAL => 'graphics/company_symbol/coffin-outline.svg',
                CompanyType::MASONRY => 'graphics/company_symbol/tomb-outline.svg',
                CompanyType::FLOWERS => 'graphics/company_symbol/flowers-outline.svg',
                default => 'graphics/company_symbol/cross-outline.svg',
            },
        );
    }
}
