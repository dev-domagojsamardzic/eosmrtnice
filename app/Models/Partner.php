<?php

namespace App\Models;

use App\Enums\UserType;
use App\Models\Scopes\PartnerScope;
use App\Models\User as BaseUserModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

/**
 * @property        int         id
 * @property        string      first_name
 * @property        string      last_name
 * @property        string      email
 * @property        UserType    type
 * @property        string      sex
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
class Partner extends BaseUserModel
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
        $attributes = $this->getAttributes();
        $attributes['type'] = UserType::PARTNER;
        $this->attributes = $attributes;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new PartnerScope);
    }

}
