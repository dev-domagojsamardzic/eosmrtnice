<?php

namespace App\Models;

use App\Enums\AdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read       int         id
 * @property            int         company_id
 * @property            int         type
 * @property            bool        approved
 * @property            int         days_valid
 * @property            Carbon      valid_from
 * @property            Carbon      valid_until
 * @property            Carbon      created_at
 * @property            Carbon      updated_at
 * @property            Carbon      deleted_at
 * --------------------------------------------
 * @property            Company     company
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
        'type' => AdType::STANDARD,
        'days_valid' => 30,
        'approved' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => AdType::class,
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Company that Ad belongs to
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
