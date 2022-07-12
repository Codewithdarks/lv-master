<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'track_page_name',
        'track_code'
    ];
}
