<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upsellfunnel_downsellproducts extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'funnelid',
        'upsellid',
        'dntype',
		'dnshopify_productid',
        'dnshopify_productname',
		'dnshopify_producthandle',
		'dndiscounttype',
		'dndiscountamount',
        'dnstatus'
    ];
}
