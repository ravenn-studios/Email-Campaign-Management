<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Facebook;

class Instagram extends Model
{
    use HasFactory;

    private static $pageId = "253428933218834";
	// private static $redirectUri  = url('/') . '/';
	private static $clientId;
	private static $clientSecret;
	// private static $code         = 'AQC40XqKttiV1mj4M8Yg94NBd-_A32ibNMpvux1DWGYf3ypvNWMR19KXY8VIZt7hAaEcDsRvRBUYU1UlqMJcVzQNPmnhAGkLhMzeWp0MdS4BRRWRLRfHpA8l2Kvl4h1yZRbk4Jtda2Q7NQX6n6e0GtUzk40zuec3SOc2wRUDMMyVRNVYAOaI5l2sto2Li3F0Q2MhEy_mDQtRwzNQx9wIK1s14AfW9ZFuJvcTQizN5aocKIzdhC0cIUIbBpR7nFRpdgh8NPSks35AnffcCshkjuL0ov7QEE1rEY2YwIVN4Nmo5UEh96REqiD52qbcvJhVrsEPyO7dVwxfkrTJbJL1Su8LKg9ofzq27cGJkyX-hj6ff5OftXBhCh1GI9XNAj-mfCU'; //tmp
	private static $accessToken;
	private static $instagramId;
    
    public static function post($imageUrl, $caption)
    {

    	if ( empty(Facebook::active()->first()->access_token) )
    	{
    		return ['success' => false, 'message' => 'Please connect with facebook.'];
    	}
    	else
    	{
    		self::setFacebookCredentials();
    	}

    	if ( empty($imageUrl) )
    	{
    		return ['success' => false, 'message' => 'Please connect with facebook.'];
    	}


		// self::$accessToken = self::getAccessToken()['access_token']; // catch
		self::$accessToken = \App\Models\Facebook::active()->first()->access_token; // catch
		self::$instagramId = self::getInstagramId()['instagram_business_account']['id'];
		// $containerId       = self::createPhotoContainer($imageUrl, 'Hello World '.rand(1,30).'!!')['id'];

		$photoContainer = self::createPhotoContainer($imageUrl, $caption);
		if ( isset($photoContainer['error']) )
		{
			return ['success' => false, 'message' => $photoContainer['error']['message']];
		}
		else
		{
			$containerId  = $photoContainer['id'];
		}

		$publishPhoto = self::publishPhoto($containerId);

		if ( isset($publishPhoto['error']) )
		{
			return ['success' => false, 'message' => 'Please connect with facebook.'];
		}


		return ['success' => true, 'message' => 'Successfully published a post!'];

    }

    public static function getInstagramFeeds()
    {

    	if ( empty(Facebook::active()->first()->access_token) )
    	{
    		return ['success' => false, 'message' => 'Please connect with facebook.'];
    	}

    	self::$accessToken = \App\Models\Facebook::active()->first()->access_token; // catch
		self::$instagramId = self::getInstagramId()['instagram_business_account']['id'];

		$getMediaEndPoint = 'https://graph.facebook.com/' .self::$instagramId. '/media';
    	$params = Array(
			'fields'  => 'id,caption,media_url,permalink,timestamp',
			'access_token' => self::$accessToken,
		);

		return self::makeApiCall($getMediaEndPoint, 'GET', $params);

    }

    public static function setFacebookCredentials()
    {

    	$fb = Facebook::active()->first();

    	if ( $fb->count() )
    	{
			static::$clientId     = $fb->client_id;
			static::$clientSecret = $fb->client_secret;
			static::$accessToken  = $fb->access_token;
    	}

    }

    public static function checkImageMediaObjectStatus($containerId)
    {
    	$checkImageMediaObjectStatusEndPoint = 'https://graph.facebook.com/' .$containerId;
    	$params = Array(
			'fields'       => 'status_code',
			'access_token' => self::$accessToken,
		);

		return self::makeApiCall($checkImageMediaObjectStatusEndPoint, 'GET', $params);
    }

    public static function photoContainerStatus($containerId)
    {
		$photoContainerStatusEndPoint = 'https://graph.facebook.com/v5.0/' .$containerId;
		$params = Array(
			'fields'       => 'status_code',
			'access_token' => self::$accessToken,
		);

		return self::makeApiCall($photoContainerStatusEndPoint, 'GET', $params);
    }

    public static function publishPhoto($containerId)
    {
    	$publishPhotoEndPoint = 'https://graph.facebook.com/' .self::$instagramId. '/media_publish';
    	$params = Array(
			'creation_id'  => $containerId,
			'access_token' => self::$accessToken,
		);

		return self::makeApiCall($publishPhotoEndPoint, 'POST', $params);
    }

    public static function createPhotoContainer($imageUrl, $caption)
    {
    	$createPhotoContainerEndPoint = 'https://graph.facebook.com/v12.0/' .self::$instagramId. '/media';
    	$params = Array(
			'image_url'    => $imageUrl,
			'caption'      => $caption,
			'access_token' => self::$accessToken,
		);

		return self::makeApiCall($createPhotoContainerEndPoint, 'POST', $params);
    }

    public static function getAccessToken()
    {
    	$getAccessTokenEndpoint = "https://graph.facebook.com/v12.0/oauth/access_token";
    	$params = Array(
			'client_id'     => self::$clientId,
			'redirect_uri'  => "https://phplaravel-370483-2014726.cloudwaysapps.com/",
			'client_secret' => self::$clientSecret,
			'code'          => self::$code,
			'grant_type'    => 'client_credentials'
		);


		return self::makeApiCall($getAccessTokenEndpoint, 'GET', $params);

    }

    public static function getInstagramId()
    {
    	$getInstagramIdEndpoint = 'https://graph.facebook.com/v12.0/' . self::$pageId;
    	$params = Array(
			'fields'       => 'instagram_business_account',
			'access_token' => self::$accessToken
		);

		return self::makeApiCall($getInstagramIdEndpoint, 'GET', $params);

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

	/*public static function oauth($redirectUri)
	{
		$oAuthEndPoint = 'https://www.facebook.com/v12.0/dialog/oauth';
    	$params = Array(
			'client_id'    => self::$clientId,
			'redirect_uri' => $redirectUri,
			'scope'        => 'instagram_basic,pages_show_list,instagram_content_publish,pages_read_engagement,public_profile,business_management,instagram_manage_insights,instagram_manage_comments',
		);

		dump($oAuthEndPoint);
		dump($params);

		dd( self::getAuthorizationCode($oAuthEndPoint, $params) );
	}*/

	public static function getAuthorizationUrl() {

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.facebook.com/v12.0/dialog/oauth?client_id=286170696342185&redirect_uri=https://phplaravel-370483-2014726.cloudwaysapps.com/&scope=instagram_basic,pages_show_list,instagram_content_publish,pages_read_engagement,public_profile,business_management,instagram_manage_insights,instagram_manage_comments',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_RETURNTRANSFER => true,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

		dd();

	}

}
