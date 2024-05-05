<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class PostRepeatAction extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    public    $table = 'post_repeat_actions';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'post_repeat_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
