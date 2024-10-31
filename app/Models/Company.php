<?php

namespace App\Models;

use App\Enums\CompanyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property        int         id
 * @property        int         user_id
 * @property        string      title
 * @property        string      address
 * @property        string      town
 * @property        string      zipcode
 * @property        string      oib
 * @property        string      email
 * @property        string      phone
 * @property        string      mobile_phone
 * @property        string      active
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * @property        Carbon      deleted_at
 * -------------------------------------------
 * @method          static      active(Builder $query)
 * @method          static      availableForAd(Builder $query)
 * -------------------------------------------
 * @property        Partner     user
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
     * Company's ads
     * @return HasMany
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'company_id');
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
        $query->whereDoesntHave('ads', function (Builder $query) {
            $query->whereNull('expired_at')
                ->whereIn('company_type', CompanyType::values())
                ->groupBy('company_id')
                ->havingRaw('COUNT(DISTINCT company_type) = ?', [count(CompanyType::values())]);
        });
    }
}
