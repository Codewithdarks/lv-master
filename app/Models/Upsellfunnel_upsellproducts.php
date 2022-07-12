<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upsellfunnel_upsellproducts extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'funnelid',
        'uptype',
		'upshopify_productid',
        'upshopify_productname',
		'upshopify_producthandle',
		'updiscounttype',
		'updiscountamount',
        'upstatus'
    ];
}
