<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class PaymentGateways extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_name',
        'status',
        'gateway_settings'
    ];
}
