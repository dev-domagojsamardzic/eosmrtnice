<?php

namespace App\Models;

use App\Enums\AdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * @property-read       int         id
 * @property            int         company_id
 * @property            int         type
 * @property            bool        approved
 * @property            bool        active
 * @property            int         months_valid
 * @property            Carbon      valid_from
 * @property            Carbon      valid_until
 * @property            string      banner
 * @property            string      caption
 * @property            bool        expired
 * @property            Carbon      expired_at
 * @property            Carbon      created_at
 * @property            Carbon      updated_at
 * @property            Carbon      deleted_at
 * --------------------------------------------
 * @property            Company|null    company
 * @property            User|null       user
 * @property            Offer|null      offer
 */
class Ad extends Model
{
    use HasFactory;

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
     * @return MorphOne
     */
    public function offer(): MorphOne
    {
        return $this->morphOne(Offer::class, 'offerable');
    }
}
