<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property        int         id
 * @property        int         user_id
 * @property        string      title
 * @property        string      address
 * @property        string      zipcode
 * @property        string      town
 * @property        string      oib
 * @property        string      email
 * @property        string      phone
 * @property        string      mobile_phone
 * @property        string      active
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * @property        Carbon      deleted_at
 * -------------------------------------------
 * @property        Partner     user
 * @property        County      county
 *
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
     * Company's county
     * @return BelongsTo
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
