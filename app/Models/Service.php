<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read       int         id
 * @property            string      title
 * @property            float       price
 * @property            Carbon      created_at
 * @property            Carbon      updated_at
 */
class Service extends Model
{
    use HasFactory;
}
