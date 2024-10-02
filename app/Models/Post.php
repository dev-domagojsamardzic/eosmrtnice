<?php

namespace App\Models;

use App\Enums\PostSize;
use App\Enums\PostSymbol;
use App\Enums\PostType;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property-read       int             id
 * @property            int             user_id
 * @property            PostType        type
 * @property            int             size
 * @property            int             funeral_county_id
 * @property            int             funeral_city_id
 * @property            Carbon          starts_at
 * @property            Carbon          ends_at
 * @property            PostSymbol      symbol
 * @property            bool            is_framed
 * @property            string          image
 * @property            string          deceased_full_name_lg
 * @property            string          slug
 * @property            string          deceased_full_name_sm
 * @property            string          lifespan
 * @property            string          intro_message
 * @property            string          main_message
 * @property            string          signature
 * @property            bool            is_active
 * @property            bool            is_approved
 * @property            int             candles
 * @property            Carbon          created_at
 * @property            Carbon          updated_at
 * @property            Carbon          deleted_at
 * -------------------------------------------------
 * @property            int             words_count
 * -------------------------------------------------
 * @property            User                user
 * @property            Collection<Offer>   offers
 * -------------------------------------------------
 * @method                              forDisplay
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => PostType::class,
        'symbol' => PostSymbol::class,
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_framed' => 'boolean',
    ];

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
        'is_framed' => false,
        'type' => PostType::DEATH_NOTICE,
        'size' => 40,
        'symbol' => PostSymbol::NONE,
        'candles' => 0,
        'is_active' => false,
        'is_approved' => false,
    ];


    /**
     * Get total post words count
     *
     * @return Attribute
     */
    protected function wordsCount(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->intro_message)->wordCount() + Str::of($this->main_message)->wordCount(),
        );
    }

    /**
     * Get posts url
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => route('posts.show', [$this->id, $this->slug])
        );
    }

    /**
     * Return post's user (creator, owner)
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post's offer
     *
     * @return HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(PostsOffer::class, 'post_id', 'id');
    }

    /**
     * Scope a query to only include posts that can be displayed
     */
    public function scopeForDisplay(Builder $query): void
    {
        $query->where(function (Builder $query) {
            $query->where('starts_at', '<=', now()->format('Y-m-d'))
                ->where('ends_at', '>', now()->format('Y-m-d'));
        })
        ->where('is_active', true)
        ->where('is_approved', true);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'deceased_full_name_lg'
            ]
        ];
    }
}
