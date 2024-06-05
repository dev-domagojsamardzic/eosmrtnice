<?php

namespace App\Models;

use App\Enums\PostType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read       int             id
 * @property            PostType        type
 * @property            Carbon          starts_at
 * @property            Carbon          ends_at
 * @property            string          symbol
 * @property            bool            is_framed
 * @property            string          image
 * @property            string          intro_message
 * @property            string          main_message
 * @property            string          signature
 * @property            string          size
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
        'type' => PostType::DEATH_NOTICE,
        'is_framed' => false,
    ];
}
