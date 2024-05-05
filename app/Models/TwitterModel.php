<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Platform;
use App\Models\SmmPost;
use App\Models\File;
use App\Models\Instagram;
use App\Models\Facebook;
use App\Models\PostRepeat;
use App\Models\PostRepeatAction;
use Atymic\Twitter\Facade\Twitter;

class TwitterModel extends Model
{

    use HasFactory;

    public static function processPost($caption, $file)
    {

		if ( $file )
        {
            $path      = 'public/attachments/' . $file->name;
            $full_path = \Storage::path($path);
            $_file     = \Storage::get($path);

            $uploaded_media = Twitter::uploadMedia(['media' => $_file]);

            $result = Twitter::postTweet(['status' => $caption, 'media_ids' => $uploaded_media->media_id_string, 'response_format' => 'object']);
        }
        else
        {
            $result = Twitter::postTweet(['status' => $caption, 'response_format' => 'object']);
        }

        return $result;

    }
}
