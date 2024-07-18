<?php

namespace App\Models;

use App\Enums\CondolenceMotive;
use App\Enums\CondolencePackageAddon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
 * @property            string          sender_address
 * @property            string          sender_additional_info
 * @property            array           package_addon
 * @property            array           addons
 * @property            string          number
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
        'package_addon' => 'array',
        'paid_at' => 'datetime',
    ];

    protected $attributes = [
        'motive' => CondolenceMotive::CROSS,
        'paid_at' => null,
    ];

    /**
     * Casting attribute as array
     * @return Attribute
     */
    public function addons(): Attribute
    {
        return Attribute::make(
            get: function() {
                $return = [];
                $addons = CondolencePackageAddon::options();
                foreach ($this->package_addon as $key) {
                    $return[] = $addons[$key];
                }
                return $return;
            }
        );
    }

    /**
     * Return condolence number
     * @return Attribute
     */
    public function number(): Attribute
    {
        return Attribute::make(
            get: fn() => str_pad($this->id, 5, '0', STR_PAD_LEFT)
        );
    }
}
