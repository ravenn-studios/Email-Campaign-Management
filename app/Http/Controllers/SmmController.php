<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Platform;
use App\Models\SmmPost;
use App\Models\Instagram;
use App\Models\Priority;
use App\Models\PostRepeat;
use App\Models\SchedulePost;

class SmmController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $platforms      = Platform::all();
        $instagramFeed  = (!empty( Instagram::getInstagramFeeds() ) ) ? array_slice( Instagram::getInstagramFeeds()['data'], 0, 14 ) : [];
        $priorities     = Priority::all();

        foreach($instagramFeed as $key => $post)
        {
            $instagramFeed[$key]['timestamp'] = \Carbon\Carbon::parse( $post['timestamp'] )->timezone('Australia/Sydney')->diffForHumans();
        }

        return view('post.index', compact('platforms', 'instagramFeed', 'priorities'));

    }


    public function activePosts()
    {

        $postRepeat     = PostRepeat::active()->get('smm_post_id')->toArray();
        $smmPostIds     = array_column( $postRepeat, 'smm_post_id' );
        $scheduledPosts = SchedulePost::active()->get();
        $postsRepeat    = PostRepeat::active()->get();
        
        $smmPosts = SmmPost::whereIn('id', $smmPostIds)->get();

        return view('post.active-posts', compact('smmPosts', 'scheduledPosts', 'postsRepeat'));

    }

}
