<?php

namespace App\Models;

use App\Enums\CompanyType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property        Partner         user
 * @property        County          county
 * @property        City            city
 * @property        Collection|Ad   ads
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
     * Ads that belong to Company
     * @return HasMany
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
}
