<?php

namespace App\Models;

use App\Enums\UserType;
use App\Models\Scopes\PartnerScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

/**
 * @property        int         id
 * @property        string      first_name
 * @property        string      last_name
 * @property        string      email
 * @property        UserType    type
 * @property        Carbon      birthday
 * @property        string      gender
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
 * @property        Company     $companies
 */

#[ScopedBy([PartnerScope::class])]
class Partner extends User
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Override type attribute
        $this->attributes['type'] = UserType::PARTNER;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new PartnerScope);
    }

}
