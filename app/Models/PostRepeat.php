<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use App\Models\SmmPost;

class PostRepeat extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    public    $table = 'post_repeat';
    protected $dates = ['deleted_at'];

    CONST ACTIVE   = 1;
    CONST INACTIVE = 0;

    protected $fillable = [
        'id',
        'smm_post_id',
        'name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function post()
    {
        return $this->belongsTo(SmmPost::class, 'smm_post_id');
    }

    public function postRepeatActions()
    {
        return $this->hasMany(PostRepeatAction::class, 'post_repeat_id');
    }

}
