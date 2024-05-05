<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Platform;
use App\Models\SmmPost;
use App\Models\SchedulePost;
use App\Models\File;
use App\Models\Facebook;
use App\Models\Instagram;
use App\Models\TwitterModel;
use App\Models\PostRepeat;
use App\Models\Priority;
use Atymic\Twitter\Facade\Twitter;

class AjaxController extends Controller
{

    public function cancelPost(Request $request)
    {

        $postId = $request->postId;
        $model  = '\App\Models\\'.$request->model.'';

        if ( !class_exists($model) )
        {
            return response()->json(['success' => false, 'message' => 'Class/Model not found.']);
        }


        $post   = $model::where('smm_post_id', $postId);

        $result = $post->delete();

        if ( !$result )
        {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.']);
        }

        return response()->json(['success' => true, 'message' => 'Scheduled post has been cancelled.']);


        // return view('users.user_ticket_limit', compact(['users']))->render();

    }

    public function saveAccessToken(Request $request)
    {

        $facebook = Facebook::active()->first();
        $facebook->access_token = $request->authResponse['accessToken'];

        $facebook->save();

    }

    public function savePost(Request $request)
    {

        $strPostToPlatformIds = implode(',', $request->postTo);
        $arrPostToPlatformIds = $request->postTo;
        $postCaption          = $request->postCaption;
        $fileName             = $request->fileName;
        $userId               = 1; //tmp
        $scheduledPost        = $request->scheduledPost;

        // dd($scheduledPost);
        if ( empty($strPostToPlatformIds) || ( empty($postCaption) && empty($fileName) ))
        {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.']);
        }
        else
        {

            $file   = File::where('name', $fileName)->first();
            $fileId = ( $file ) ? $file->id : 0;

            foreach ( $arrPostToPlatformIds as $platformId)
            {

                $platform = Platform::where('id', $platformId)->first();

                //check if the selected social media platform exists
                if ( $platform )
                {

                    //if post is scheduled
                    if ( $scheduledPost )
                    {

                        $post = SmmPost::create([
                            'platform_id' => $strPostToPlatformIds,
                            'file_id'     => ( $file ) ? $file->id : '',
                            'user_id'     => $userId,
                            'priority_id' => $request->postPriority,
                            'caption'     => $postCaption,
                            'is_posted'   => false,
                        ]);

                        $_scheduledPost = SchedulePost::create([
                            'smm_post_id' => $post->id,
                            'post_at'     => $scheduledPost,
                            'is_posted'   => false,
                        ]);

                        $this->create_post_repeat($post->id, $request->postRepeat);

                    }
                    else
                    {

                        if ( $platform->id == Platform::TWITTER)
                        {

                                $result = TwitterModel::processPost($postCaption, $file);

                                if ( $result )
                                {
                                    $this->createSmmPost($strPostToPlatformIds, $fileId, $userId, $postCaption, true, $request->postRepeat, $request->postPriority);
                                }

                            /*}*/

                        }

                        if ( $platform->id == Platform::INSTAGRAM)
                        {

                            //if post has image
                            if ( $file )
                            {
                                // $instagram = Instagram::post('https://phplaravel-370483-2014726.cloudwaysapps.com/storage/attachments/' . $file->name);

                                $imageUrl = url('/') .'/storage/attachments/' . $file->name;
                                $instagram = Instagram::post($imageUrl, $postCaption);

                                $this->createSmmPost($strPostToPlatformIds, $fileId, $userId, $postCaption, true, $request->postRepeat, $request->postPriority);

                                return response()->json($instagram);
                            }
                            else
                            {
                                return response()->json(['success' => false, 'message' => 'Image for instagram post is required!']);
                            }

                        }

                        if ( $platform->id == Platform::FACEBOOK)
                        {

                            if ( $file )
                            {
                                $imageUrl = url('/') . '/storage/attachments/' . $file->name;
                                $facebook = Facebook::publishPhoto($postCaption, $imageUrl);
                            }
                            else
                            {
                                $facebook = Facebook::post($postCaption);
                            }

                            $this->createSmmPost($strPostToPlatformIds, $fileId, $userId, $postCaption, true, $request->postRepeat, $request->postPriority);

                        }

                    }

                }

            }

            return response()->json(['success' => true, 'message' => 'Success!']);

        }

    }

    public function createSmmPost($platformIds, $fileId, $userId, $postCaption, $isPosted, $postRepeat, $postPriority)
    {

        $post = SmmPost::create([
                    'platform_id' => $platformIds,
                    'file_id'     => $fileId,
                    'user_id'     => $userId,
                    'priority_id' => $postPriority,
                    'caption'     => $postCaption,
                    'is_posted'   => true,
                ]);

        $this->create_post_repeat($post->id, $postRepeat);

        return $post;

    }

    public function create_post_repeat($smmPostId, $repeatName)
    {
        if ( $repeatName != 'never')
        {
            PostRepeat::create([
                'smm_post_id' => $smmPostId,
                'name'        => ucfirst($repeatName),
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
