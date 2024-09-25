<?php

namespace App\Models;

use App\Enums\UserType;
use App\Models\Scopes\MemberScope;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property        int         id
 * @property        string      first_name
 * @property        string      last_name
 * @property        string      email
 * @property        UserType    type
 * @property        string      gender
 * @property        Carbon      email_verified_at
 * @property        string      password
 * @property        string      remember_token
 * @property        bool        active
 * @property        Carbon      created_at
 * @property        Carbon      updated_at
 * @property        Carbon      deleted_at
 * ----------------------------------------------------
 * @property-read   string      full_name
 * ----------------------------------------------------
 * @property        Collection<Company>     companies
 */

#[ScopedBy([MemberScope::class])]
class Member extends User
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
        $this->attributes['type'] = UserType::MEMBER;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new MemberScope);
    }
}
