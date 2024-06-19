<?php

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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
 * @property-read       string          full_name
 * @property-read       string          lifespan
 * ------------------------------------------------------
 * @property            User                user
 * @property            City                city
 * @property            County              county
 * @property            Collection<Post>    posts
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

    /**
     * Return deceased related posts
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the deceased's full name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function() {
                if ($this->gender === Gender::FEMALE && $this->maiden_name) {
                    return "$this->first_name $this->last_name ".__('models/deceased.maiden_name_prefix')." $this->maiden_name";
                }
                return "$this->first_name $this->last_name";
            }
        );
    }

    /**
     * Return from when to when a person lived
     *
     * @return Attribute
     */
    protected function lifespan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->date_of_birth->format('d.m.Y.') . ' - ' . $this->date_of_death->format('d.m.Y.')
        );
    }
}
