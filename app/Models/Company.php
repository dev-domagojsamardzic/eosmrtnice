<?php

namespace App\Models;

use App\Enums\CompanyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property        int         id
 * @property        int         type
 * @property        int         user_id
 * @property        string      title
 * @property        string      address
 * @property        string      town
 * @property        string      zipcode
 * @property        int         city_id
 * @property        int         county_id
 * @property        string      oib
 * @property        string      email
 * @property        string      phone
 * @property        string      mobile_phone
 * @property        string      website
 * @property        string      logo
 * @property        string      active
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * @property        Carbon      deleted_at
 * -------------------------------------------
 * @method          static      active(Builder $query)
 * @method          static      availableForAd(Builder $query)
 * -------------------------------------------
 * @property        string      alternative_logo
 * -------------------------------------------
 * @property        Partner     user
 * @property        County      county
 * @property        City        city
 * @property        Ad          ads
 */

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = [
        'active' => true,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => CompanyType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * Company's user (owner, representative)
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Company's county
     * @return BelongsTo
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    /**
     * Company's city
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    /**
     * IMPORTANT!
     * -----------------------------------------
     * Although relationship is one to one, keep the name in plural (ads)
     * because of implicit scope binding
     * -----------------------------------------
     * Ad that belongs to Company
     * @return HasOne
     */
    public function ads(): HasOne
    {
        return $this->hasOne(Ad::class);
    }

    /**
     * Scope a query to only include active companies.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    /**
     * Scope a query to only include companies available for ads
     */
    public function scopeAvailableForAd(Builder $query): void
    {
        $query->whereDoesntHave('ads', static function ($query) {
            $query->where('expired', false);
        });
    }


    /**
     * Get alternative logo based on company type
     */
    protected function alternativeLogo(): Attribute
    {
        return Attribute::make(
            get: fn() => match($this->type) {
                CompanyType::FUNERAL => 'graphics/svg/coffin-outline.svg',
                CompanyType::MASONRY => 'graphics/svg/tomb-outline.svg',
                CompanyType::FLOWERS => 'graphics/svg/flowers-outline.svg',
                default => 'graphics/svg/cross-outline.svg',
            },
        );
    }
}
