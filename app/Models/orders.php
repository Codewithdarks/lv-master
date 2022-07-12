<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'product_info',
        'billing_address',
        'shipping_address',
        'subtotal_price',
        'shipping',
        'shipping_detail',
        'discount',
        'tax',
        'total_price',
        'payment_gateway',
        'shopify_order_id',
        'shopify_order_name',
        'shopify_order_number',
		'shopify_customerid',
        'orders_status',
        'fulfillment_status',
        'cancel_reason',
        'cancelled_at',
        'refunded_amount',
        'refunded_date',
    ];
}
