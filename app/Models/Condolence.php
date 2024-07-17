<?php

namespace App\Models;

use App\Enums\CondolenceMotive;
use App\Enums\CondolencePackageAddon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property            int             id
 * @property            string          motive
 * @property            string          message
 * @property            string          recipient_full_name
 * @property            string          recipient_address
 * @property            string          sender_full_name
 * @property            string          sender_email
 * @property            string          sender_phone
 * @property            string          sender_additional_info
 * @property            int             package_addon
 * @property            Carbon          paid_at
 * @property            Carbon          created_at
 * @property            Carbon          updated_at
 * @property            Carbon          deleted_at
 *
 */
class Condolence extends Model
{
    use SoftDeletes;

    protected $casts = [
        'motive' => CondolenceMotive::class,
        'package_addon' => CondolencePackageAddon::class,
        'paid_at' => 'datetime',
    ];

    protected $attributes = [
        'motive' => CondolenceMotive::CROSS,
        'package_addon' => CondolencePackageAddon::LANTERNS_1,
        'paid_at' => null,
    ];
}
