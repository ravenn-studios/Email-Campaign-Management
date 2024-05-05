<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\SmmPost;
use App\Models\File;
use App\Models\Instagram;
use App\Models\Facebook;
use App\Models\PostRepeat;
use App\Models\PostRepeatAction;
use App\Models\TwitterModel;
use Atymic\Twitter\Facade\Twitter;
use Log;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class SchedulePost extends Model
{

	use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    public    $table = 'scheduled_posts';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'smm_post_id',
        'post_at',
        'is_posted',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logAttributes = ['smm_post_id','post_at','is_posted'];
    
    protected static $recordEvents = ['created', 'updated', 'deleted', 'restored'];
    
    protected static $logOnlyDirty = true;

    protected static $logName = 'Schedule Post';

    public static function getDescriptionForEvent(string $eventName): string
    {
       return "You have {$eventName} a post";
    }

    public function tapActivity(Activity $activity, string $eventName)
    {

        if ($eventName === 'created')
        {
            $activity->properties = $activity->properties->merge([
                'action' => 'scheduled_post_created',
            ]);
        }

    }

    public function scopeActive($query)
    {
        return $query->where('is_posted', 0);
    }

    public function post()
    {
        return $this->belongsTo(SmmPost::class, 'smm_post_id');
    }


    public function checkPendingPosts()
    {

        $scheduledPosts = $this->where('is_posted', false)->get();

        foreach( $scheduledPosts as $scheduledPost )
        {

            if ( (\Carbon\Carbon::now()->gt($scheduledPost->post_at)) ) // datetime now is greater or equal the set scheduled post.
            {

                $smmPost     = SmmPost::find( $scheduledPost->smm_post_id );
                $platformIds = explode(',', $smmPost->platform_id);
                $file        = ($smmPost->file_id == 0) ? 0 : File::where('id', $smmPost->file_id)->first();

                foreach( $platformIds as $platformId )
                {

                    if ( $platformId == Platform::TWITTER)
                    {

                        $result = TwitterModel::processPost($smmPost->caption, $file);

                        if ( $result )
                        {
                            $scheduledPost->is_posted = $smmPost->is_posted = true;
                            $scheduledPost->save();
                            $smmPost->save();
                        }

                    }


                    if ( $platformId == Platform::INSTAGRAM)
                    {

                        // https://phplaravel-370483-2014726.cloudwaysapps.com/storage/attachments/2023004fe25d.png

                         //if post has image
                        if ( $file )
                        {
                            $imageUrl  = url('/') .'/storage/attachments/' . $file->name;
                            $instagram = Instagram::post($imageUrl, $smmPost->caption);

                            if ( $instagram['success'] )
                            {

                            }
                            else
                            {
                                // return response()->json(['success' => false, 'message' => $instagram['message']]);
                                Log::info($instagram['message']);
                            }
                        }
                        else
                        {
                            // return response()->json(['success' => false, 'message' => 'Image for instagram post is required!']);
                            Log::info('Image for instagram post is required!');
                        }

                    }

                    if ( $platformId == Platform::FACEBOOK)
                    {

                        if ( $file )
                        {
                            $imageUrl = url('/') .'/storage/attachments/' . $file->name;
                            $facebook = Facebook::publishPhoto($smmPost->caption, $imageUrl);
                        }
                        else
                        {
                            $facebook = Facebook::post($$smmPost->caption);
                        }

                    }

                }

            }

        }

    }

    public function checkPostRepeat()
    {

        $postsRepeat = PostRepeat::active()->get();

        foreach($postsRepeat as $postRepeat)
        {
            $this->publishPostRepeat( $postRepeat->smm_post_id );
        }

    }

    /**
     * This function will do a re-post if postRepeat condition is met.
     * For new / first re-post/reminder, it will check first the smm_post's created_at and check if interval is met through post_repeat type(Daily,Weekly etc.)
     * after that, it will now check first the post_repeat_actions' created_at and check if interval is met through post_repeat type(Daily,Weekly etc.)
     */
    public function publishPostRepeat($smmPostId)
    {
        // dump($smmPostId); //29
        $schedulePost = $this->where('smm_post_id', $smmPostId)->get();

        $postRepeat = PostRepeat::where('smm_post_id', $smmPostId)->first();

        // do not re-post if theres pending schedulePost
        if ( !$schedulePost->count() || ( $schedulePost->count() && $schedulePost->first()->is_posted ) )
        {

            if ( $postRepeat->postRepeatActions->count() )
            {

                //check if there is a postRepeatAction record then use the last record's created_at and check if the postRepeat(time/name) >= last postRepeatAction's created_at
                $recentPostRepeatAction = $postRepeat->postRepeatActions->last();

                //date now is greater tahn or equal the interval date?
                $intervalDate = self::checkIntervalDate( $postRepeat->name, $recentPostRepeatAction->created_at );
                $now          = \Carbon\Carbon::now();

                /*dump($intervalDate);
                dump($now);
                dd($now->gt($intervalDate));*/

                if ( $now->gt($intervalDate) )
                {
                    //post
                    $smmPost = SmmPost::find($smmPostId);

                    $this->processPost($smmPost);

                    $this->createPostRepeatAction($postRepeat->id);
                }

            }
            else
            {
                //check if there is no postRepeatAction record then use the smm_post created_at and check if the postRepeat(time/name) >= last smm_post's created_at

                $smmPost      = SmmPost::find($smmPostId);
                $intervalDate = self::checkIntervalDate( $postRepeat->name, $smmPost->created_at );
                $now          = \Carbon\Carbon::now();

                if ( $now->gt($intervalDate) )
                {
                    //post
                    $this->processPost($smmPost);

                    $this->createPostRepeatAction($postRepeat->id);
                }

            }

        }

        //check if there is a postRepeatAction record then use the last record's created_at and check if the postRepeat(time/name) >= last postRepeatAction's created_at

    }

    public function createPostRepeatAction($postRepeatId)
    {
        PostRepeatAction::create([
            'post_repeat_id' => $postRepeatId,
        ]);
    }

    public function checkIntervalDate($postRepeatName, $intervalDate)
    {

        if ( $postRepeatName == 'Daily')
        {
            $intervalDate = $intervalDate->addDays();
        }
        elseif ( $postRepeatName == 'Weekly')
        {
            $intervalDate = $intervalDate->addWeeks();
        }
        elseif ( $postRepeatName == 'Biweekly')
        {
            $intervalDate = $intervalDate->addWeeks(2);
        }
        else
        {
            $intervalDate = $intervalDate->addMonths();
        }

        return $intervalDate->format('Y-m-d H:i:s');

    }

    public function processPost($smmPost)
    {

        $platformId = $smmPost->platform_id;
        $file       = ($smmPost->file_id == 0) ? 0 : File::where('id', $smmPost->file_id)->first();

        if ( $platformId == Platform::TWITTER)
        {

            $result = TwitterModel::processPost($smmPost->caption, $file);

        }


        if ( $platformId == Platform::INSTAGRAM)
        {

            // https://phplaravel-370483-2014726.cloudwaysapps.com/storage/attachments/2023004fe25d.png

             //if post has image
            if ( $file )
            {
                $imageUrl  = url('/') .'/storage/attachments/' . $file->name;
                $instagram = Instagram::post($imageUrl, $smmPost->caption);

                if ( $instagram['success'] )
                {

                }
                else
                {
                    // return response()->json(['success' => false, 'message' => $instagram['message']]);
                    Log::info($instagram['message']);
                }
            }
            else
            {
                return response()->json(['success' => false, 'message' => 'Image for instagram post is required!']);
                Log::info('Image for instagram post is required!');
            }

        }

        if ( $platformId == Platform::FACEBOOK)
        {

            if ( $file )
            {
                $imageUrl = url('/') .'/storage/attachments/' . $file->name;
                $facebook = Facebook::publishPhoto($smmPost->caption, $imageUrl);
            }
            else
            {
                $facebook = Facebook::post($smmPost->caption);
            }

        }

    }

    public function tweet()
    {

    }

    public function instagramPost()
    {
        
    }

}
