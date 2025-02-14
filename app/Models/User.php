<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserType;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property        int         id
 * @property        string      first_name
 * @property        string      last_name
 * @property        string      email
 * @property        UserType    type
 * @property        Gender      gender
 * @property        Carbon      email_verified_at
 * @property        string      password
 * @property        string      remember_token
 * @property        bool        active
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * @property        Carbon      deleted_at
 * -------------------------------------------
 * @property-read   string      full_name
 * -------------------------------------------
 * @property        Company                 companies
 * @property        Ad<Collection>          ads
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => UserType::MEMBER,
        'active' => 1,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserType::class,
    ];

    /**
     * Get the user's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }

    /**
     * user's companies
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Return ads of a user (for partner)
     * @return HasManyThrough
     */
    public function ads(): HasManyThrough
    {
        return $this->hasManyThrough(Ad::class, Company::class);
    }

    /**
     * Scope a query to only include partners (type=ADMIN)
     */
    public function scopeAdmins(Builder $query): void
    {
        $query->where('type', UserType::ADMIN);
    }

    /**
     * Scope a query to only include partners (type=PARTNER)
     */
    public function scopePartners(Builder $query): void
    {
        $query->where('type', UserType::PARTNER);
    }

    /**
     * Scope a query to only include members (type=MEMBER).
     */
    public function scopeMembers(Builder $query): void
    {
        $query->where('type', UserType::MEMBER);
    }

    /**
     * Scope a query to only include active users
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }
}
