<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read       int         id
 * @property            int         company_id
 * @property            int         type
 * @property            bool        approved
 * @property            Carbon      valid_from
 * @property            Carbon      valid_until
 * @property            Carbon      created_at
 * @property            Carbon      updated_at
 * @property            Carbon      deleted_at
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
        // TODO: Add default type when you create Enum class
        'approved' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // TODO: Add cats to Enum class for type attr
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];
}
