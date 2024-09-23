<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property        int             id
 * @property        string          title
 * @property        float           price
 * @property        Carbon          created_at
 * @property        Carbon          updated_at
 * @property        Carbon          deleted_at
 */
class CondolenceAddon extends Model
{
    use SoftDeletes;

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
        'price' => 0.00,
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
