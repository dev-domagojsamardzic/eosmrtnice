<?php

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read       int             id
 * @property            int             user_id
 * @property            string          first_name
 * @property            string          last_name
 * @property            string          maiden_name
 * @property            string          slug
 * @property            Gender          gender
 * @property            Carbon          date_of_birth
 * @property            Carbon          date_of_death
 * @property            int             death_county_id
 * @property            int             death_city_id
 * @property            string          image
 * @property            Carbon          created_at
 * @property            Carbon          updated_at
 * @property            Carbon          deleted_at
 * ------------------------------------------------------
 * ------------------------------------------------------
 * @property            User            user
 * @property            City            city
 * @property            County          county
 */
class Deceased extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = [
        'gender' => Gender::MALE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gender' => Gender::class,
        'date_of_birth' => 'date',
        'date_of_death' => 'date',
    ];

    /**
     * Return model's user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return model's city
     *
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'death_city_id');
    }

    /**
     * Return model's county
     *
     * @return BelongsTo
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'death_county_id');
    }
}
