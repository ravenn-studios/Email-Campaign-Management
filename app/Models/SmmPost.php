<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use App\Models\User;
use App\Models\Platform;
use App\Models\PostRepeat;

class SmmPost extends Model
{

	use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    public    $table = 'smm_posts';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'platform_id',
        'file_id',
        'user_id',
        'priority_id',
        'caption',
        'is_posted',
        'schedule_post_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logAttributes = ['platform_id','file_id','user_id','caption','is_posted','schedule_post_id'];
    
    protected static $recordEvents = ['created', 'updated', 'deleted', 'restored'];
    
    protected static $logOnlyDirty = true;

    protected static $logName = 'Post';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function platform()
    {
        return $this->hasOne(Platform::class, 'id', 'platform_id');
    }


    public function postRepeat()
    {
        return $this->hasOne(PostRepeat::class, 'id', 'smm_post_Id');
    }

    public static function getDescriptionForEvent(string $eventName): string
    {
       return "You have {$eventName} a post";
    }

    public function tapActivity(Activity $activity, string $eventName)
    {

        if ($eventName === 'created')
        {
            $activity->properties = $activity->properties->merge([
                'action' => 'post_created',
            ]);
        }

    }

}
