<?php

namespace App\Models;

use App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'api_customer_id',
		'status',
		'company',
		'email',
		'first_name',
		'last_name',
		'notes',
		'phone',
		'registration_ip_address',
		'created_at',
		'updated_at',
	];

	public function campaigns()	{
	    return $this->belongsToMany(Customer::class, 'campaign_customer', 'campaign_id', 'customer_id')
	                ->withPivot('is_sent', 'sent_at')
	                ->withTimestamps();
	}
	
}
