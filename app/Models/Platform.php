<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Platform extends Model
{

    use HasFactory;
    use SoftDeletes;

	public    $table = 'platforms';
	protected $dates = ['deleted_at'];
	
	CONST TWITTER    = 1;
	CONST INSTAGRAM  = 2;
	CONST FACEBOOK   = 3;

}
