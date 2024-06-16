<?php

namespace App\Models;

use App\Enums\PostSize;
use App\Enums\PostSymbol;
use App\Enums\PostType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read       int             id
 * @property            int             user_id
 * @property            int             deceased_id
 * @property            PostType        type
 * @property            PostSize        size
 * @property            Carbon          starts_at
 * @property            Carbon          ends_at
 * @property            PostSymbol      symbol
 * @property            bool            is_framed
 * @property            string          image
 * @property            string          deceased_full_name_lg
 * @property            string          deceased_full_name_sm
 * @property            string          lifespan
 * @property            string          intro_message
 * @property            string          main_message
 * @property            string          signature
 * @property            Carbon          created_at
 * @property            Carbon          updated_at
 * @property            Carbon          deleted_at
 * -------------------------------------------------
 * -------------------------------------------------
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => PostType::class,
        'size' => PostSize::class,
        'symbol' => PostSymbol::class,
        'starts_at' => 'date',
        'ends_at' => 'date',
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
        'size' => PostSize::SMALL,
        'symbol' => PostSymbol::NONE
    ];

    /**
     * Return post's deceased relationship
     *
     * @return BelongsTo
     */
    public function deceased(): BelongsTo
    {
        return $this->belongsTo(Deceased::class, 'deceased_id');
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
}
