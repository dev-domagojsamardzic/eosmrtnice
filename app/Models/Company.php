<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * -------------------------------------------
 * @property-read   string      full_name
 * -------------------------------------------
 * @property        Company     $companies
 */

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'user_id',
        'address',
        'zipcode',
        'town',
        'oib',
        'email',
        'phone',
        'mobile_phone',
    ];

    /**
     * Company's user (owner, representative)
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
