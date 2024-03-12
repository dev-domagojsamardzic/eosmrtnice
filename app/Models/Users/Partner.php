<?php

namespace App\Models\Users;

use App\Enums\UserType;
use App\Models\Company;
use App\Models\User as BaseUserModel;
use Carbon\Carbon;

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

class Partner extends BaseUserModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Override type attribute
        $attributes = $this->getAttributes();
        $attributes['type'] = UserType::PARTNER;
        $this->attributes = $attributes;
    }

}
