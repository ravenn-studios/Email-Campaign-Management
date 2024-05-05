<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model {
    use HasFactory;

    protected $fillable = [
        'url',
        'campaign_id',
        'customer_id',
        'user_agent',
        'referrer',
        'ip_address',
        'click_type',
        'country',
        'device_type',
        'action',
        'page_title',
    ];
}
