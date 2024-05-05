<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Facebook extends Model
{

	use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    public    $table = 'facebook';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'client_id',
        'client_secret',
        'access_token',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    private static $pageId = "253428933218834";
	private static $clientId;
	private static $clientSecret;
	private static $accessToken;
	private static $pageAccessToken;


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function post($caption = '')
    {
    	
    	$hasAccess = self::setFacebookCredentials();

    	if ( $hasAccess && !empty($caption) )
    	{

    		$publishPost = self::publishPost($caption);

    		if ( isset($publishPost['error']) )
			{
				return ['success' => false, 'message' => $publishPost['error']['message']];
			}

    	}
    	else
    	{
    		//check access credentials, caption
    	}


    	return ['success' => true, 'message' => 'Successfully published a post!'];

    }

    public static function publishPhoto($caption = '', $imageUrl)
    {

    	// $hasAccess = self::setFacebookCredentials();

		$publishPhotoEndPoint = 'https://graph.facebook.com/v12.0/'.self::$pageId.'/photos';
    	$params = Array(
			'url'       => $imageUrl,
			'message'       => $caption,
			'access_token' => self::$pageAccessToken,
		);

    	$publishPhoto = self::makeApiCall($publishPhotoEndPoint, 'POST', $params);

    	if ( isset($publishPhoto['error']) )
		{
			return ['success' => false, 'message' => $publishPhoto['error']['message']];
		}

    	return ['success' => true, 'message' => 'Successfully published a post!'];

    }

    public static function publishPost($caption)
    {

    	$publishPostEndPoint = 'https://graph.facebook.com/v12.0/feed';
    	$params = Array(
			'message'       => $caption,
			'access_token' => self::$pageAccessToken,
		);

    	return self::makeApiCall($publishPostEndPoint, 'POST', $params);

    }

    public static function getPageTimeline()
    {
        $hasAccess = self::setFacebookCredentials();
 
        if ( $hasAccess )
        {

            $getPageTimelineEndPoint = 'https://graph.facebook.com/v12.0/'.self::$pageId.'/feed';
            $params = Array(
                'fields' => 'permalink_url',
                'access_token' => self::$pageAccessToken,
            );

            $getPageTimeline = self::makeApiCall($getPageTimelineEndPoint, 'GET', $params);

            if ( isset($getPageTimeline['error']) )
            {
                return ['success' => false, 'message' => $getPageTimeline['error']['message']];
            }

            return $getPageTimeline;

        }
    }

    public static function setPageAccessToken()
    {

    	$getPageAccessTokenEndPoint = 'https://graph.facebook.com/v12.0/253428933218834';
    	$params = Array(
			'fields'       => 'access_token',
			'access_token' => self::$accessToken,
		);

    	self::$pageAccessToken = self::makeApiCall($getPageAccessTokenEndPoint, 'GET', $params)['access_token'];

    }

    public static function setFacebookCredentials()
    {

    	$fb = self::active()->first();

    	if ( $fb->count() )
    	{

			self::$clientId     = $fb->client_id;
			self::$clientSecret = $fb->client_secret;
			self::$accessToken  = $fb->access_token;

			self::setPageAccessToken();

			return true;

    	}
    	else
    	{
    		return false;
    	}

    }

    public static function makeApiCall($endpoint, $type, $params)
	{

		$ch = curl_init();

		if ( 'POST' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
		} elseif ( 'GET' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );

	}

}
