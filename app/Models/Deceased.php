<?php

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read       int             id
 * @property            string          first_name
 * @property            string          last_name
 * @property            string          maiden_name
 * @property            string          slug
 * @property            Gender          gender
 * @property            Carbon          date_of_birth
 * @property            Carbon          date_of_death
 * @property            int             county_id
 * @property            int             city_id
 * @property            string          image
 *
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
}
