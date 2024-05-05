<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instagram;
use App\Models\Facebook;
use App\Models\SchedulePost;
use App\Models\Customer;
use App\Models\Click;

use Mail;

use Jenssegers\Agent\Agent;
use Torann\GeoIP\Facades\GeoIP;


use App\Models\Campaign;
use App\Mail\BulkMail;
use App\Mail\MarchCampaignMadness;
// use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{

	private $pageId;
	private $redirectUri;
	private $clientId;
	private $clientSecret;
	private $code; //tmp
	private $accessToken;
	private $instagramId;

	//17934782254658886

	public function __construct() {
		$this->pageId = '253428933218834';
		$this->redirectUri  = URL('') . '/';;
		$this->clientId  = '286170696342185';
		$this->clientSecret = '581d7ec3d48c28802a2356718764443a';
		$this->code         = 'AQD-1T0gZwDOi9xTnI2HbCnwIYgidK60m02EVhCdQL5Bos1JBZxILRhHqcZ3VHKvVVqBsJ8xCsa-huR06ncE1uPgclENWTZnf15LpqTQbs-Mq6OH-M1ToKIpvg7feCJFolPEabxrneFpi96yMp6b4L35rNTYQSHZURN4CIBIK5_ix204A50fxaY17_CmX_5fdyciMZ9nhDaJYbfqxnFxj586-vYDYEAw4MaYr_Gy3Yp5GfDG4NzWa-nJUUdPLBnr1OFC0IJNVHRB50izgybfBLgKlJgHTQKjGXVMcXP7J59R5j8ZvXIdYJ3x3fRJBXJXNNJnF0bBA0gMZkTzGujXhKqY2aqqKmHvluSh9Xijo-3_nDknulmq6I0eWE74K7P0Luo'; //tmp
	}

    public function index() {

    	dd(Facebook::getPageTimeline());
    	// $sp = new \App\Models\SchedulePost;
    	// $sp->checkPostRepeat();
    	/*$post = new SchedulePost;
    	$post->publishPostRepeat(24);*/

    	// dd( Facebook::publishPhoto() );
    	// $instagram = Instagram::post('https://phplaravel-370483-2014726.cloudwaysapps.com/images/home-decor-2.jpg');
    	// https://phplaravel-370483-2014726.cloudwaysapps.com/images/home-decor-2.jpg

		// $this->accessToken = \App\Models\Facebook::active()->first()->access_token; // catch
		// dump($this->getInstagramId());
		// dd(88);
		// $this->instagramId = $this->getInstagramId()['instagram_business_account']['id'];

		// $containerId       = $this->createPhotoContainer('https://img.freepik.com/free-photo/pink-sofa-white-living-room-with-copy-space_43614-798.jpg?size=338&ext=jpg', 'Hello World '.rand(1,30).'!!')['id'];
		// $publishPhoto      = $this->publishPhoto($containerId);

		// if ( isset($publishPhoto['error']) )
		// {

		// 	//return error

		// }

    }

    public function checkImageMediaObjectStatus($containerId) {
    	$checkImageMediaObjectStatusEndPoint = 'https://graph.facebook.com/' .$containerId;
    	$params = Array(
			'fields' => 'status_code',
			'access_token' => $this->accessToken,
		);

		return $this->makeApiCall($checkImageMediaObjectStatusEndPoint, 'GET', $params);
    }

    public function photoContainerStatus($containerId) {
		$photoContainerStatusEndPoint = 'https://graph.facebook.com/v5.0/' .$containerId;
		$params = Array(
			'fields'       => 'status_code',
			'access_token' => $this->accessToken,
		);

		return $this->makeApiCall($photoContainerStatusEndPoint, 'GET', $params);
    }

    public function publishPhoto($containerId) {
    	$publishPhotoEndPoint = 'https://graph.facebook.com/' .$this->instagramId. '/media_publish';
    	$params = Array(
			'creation_id' => $containerId,
			'access_token' => $this->accessToken,
		);

		return $this->makeApiCall($publishPhotoEndPoint, 'POST', $params);
    }

    public function createPhotoContainer($imageUrl, $caption) {
    	$createPhotoContainerEndPoint = 'https://graph.facebook.com/v12.0/' .$this->instagramId. '/media';
    	$params = Array(
			'image_url'    => $imageUrl,
			'caption'      => $caption,
			'access_token' => $this->accessToken,
		);

		return $this->makeApiCall($createPhotoContainerEndPoint, 'POST', $params);
    }

    public function getAccessToken() {
    	$getAccessTokenEndpoint = 'https://graph.facebook.com/v12.0/oauth/access_token';
    	$params = Array(
			'client_id'     => $this->clientId,
			'redirect_uri'  => $this->redirectUri,
			'client_secret' => $this->clientSecret,
			'code'          => $this->code,
		);

		// return $this->makeApiCall($getAccessTokenEndpoint, 'GET', $params);
		dd( $this->makeApiCall($getAccessTokenEndpoint, 'GET', $params) );

    }

    public function getInstagramId() {

    	$getInstagramIdEndpoint = 'https://graph.facebook.com/v12.0/253428933218834';
    	$params = Array(
			'fields'       => 'instagram_business_account',
			'access_token' => $this->accessToken
		);

		return $this->makeApiCall($getInstagramIdEndpoint, 'GET', $params);

    }

    public function makeApiCall($endpoint, $type, $params) {

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

	public function unsubscribeSubmit(Request $request) {
    	$customer = Customer::findOrFail($request->cuid);
    	$customer->unsubscribe = 1;
    	$customer->save();

    	$agent = new Agent();

		$ip_address = $request->ip();
		$location = GeoIP::getLocation($ip_address);

		$referrer = $request->header('referer') ?: 'mail.google.com';
		$user_agent = $request->header('user-agent');

		if ($agent->isDesktop()) $device_type = 'Desktop';
		if ($agent->isMobile()) $device_type = 'Mobile';
		if ($agent->isTablet()) $device_type = 'Tablet';

		$payload = [
			'campaign_id' => $request->cid,
			'url'         => $request->url,
			'customer_id' => $request->cuid,
			'user_agent'  => $user_agent,
			'referrer'    => $referrer,
			'ip_address'  => $ip_address,
			'click_type'  => 0,
			'country'     => $location->country,
			'device_type' => $device_type,
			'action'      => 0,
			'page_title'  => 0,
		];
		Click::create($payload);

    	return response()->redirectTo('https://frankiesautoelectrics.com.au/thank-you');
	}

	public function click(Request $request) {
		return response()->redirectTo($request->url);
	}

	public function trackSpamReport(Request $request) {
		$customer = Customer::findOrFail($request->cuid);
    	$customer->unsubscribe = 1;
    	$customer->save();

    	$agent = new Agent();

		$ip_address = $request->ip();
		$location = GeoIP::getLocation($ip_address);

		$referrer = $request->header('referer') ?: 'mail.google.com';
		$user_agent = $request->header('user-agent');

		if ($agent->isDesktop()) $device_type = 'Desktop';
		if ($agent->isMobile()) $device_type = 'Mobile';
		if ($agent->isTablet()) $device_type = 'Tablet';

		$payload = [
			'campaign_id' => $request->cid,
			'url'         => 'https://frankiesautoelectrics.com.au/spam-report',
			'customer_id' => $request->cuid,
			'user_agent'  => $user_agent,
			'referrer'    => $referrer,
			'ip_address'  => $ip_address,
			'click_type'  => 0,
			'country'     => $location->country,
			'device_type' => $device_type,
			'action'      => 0,
			'page_title'  => 0,
		];
		Click::create($payload);

    	return response()->redirectTo('https://frankiesautoelectrics.com.au');
	}

	public function trackUnsubscribe(Request $request) {
		$campaign_id = $request->cid;
		$url         = $request->url;
		$customer    = Customer::findOrFail($request->cuid);
		return view('unsubscribe.index')->with(['campaign_id' => $campaign_id, 'URL' => $url, 'customer' => $customer]);
		return $request->all();
	}

	public function trackClick(Request $request) {
		$agent = new Agent();

		$ip_address = $request->ip();
		$location = GeoIP::getLocation($ip_address);
		$device_type = '';

		$referrer = $request->header('referer') ?: 'mail.google.com';
		$user_agent = $request->header('user-agent');

		if ($agent->isDesktop()) $device_type = 'Desktop';
		if ($agent->isMobile()) $device_type = 'Mobile';
		if ($agent->isTablet()) $device_type = 'Tablet';

		$payload = [
			'campaign_id' => $request->cid,
			'url'         => $request->url,
			'customer_id' => $request->cuid,
			'user_agent'  => $user_agent,
			'referrer'    => $referrer,
			'ip_address'  => $ip_address,
			'click_type'  => 0,
			'country'     => $location->country,
			'device_type' => $device_type,
			'action'      => 0,
			'page_title'  => 0,
		];

		Click::create($payload);

		return response()->redirectTo($request->url);
	}

	public function trackingPixel(Request $request) {
		$agent = new Agent();

		$ip_address = $request->ip();
		$location = GeoIP::getLocation($ip_address);

		$referrer = $request->header('referer') ?: 'mail.google.com';
		$user_agent = $request->header('user-agent');

		if ($agent->isDesktop()) $device_type = 'Desktop';
		else if ($agent->isMobile()) $device_type = 'Mobile';
		else if ($agent->isTablet()) $device_type = 'Tablet';
		else $device_type = 'Others';

		$payload = [
			'campaign_id' => $request->cid,
			'url'         => 'https://gmail.com',
			'customer_id' => $request->cuid,
			'user_agent'  => $user_agent,
			'referrer'    => $referrer,
			'ip_address'  => $ip_address,
			'click_type'  => 0,
			'country'     => $location->country,
			'device_type' => $device_type,
			'action'      => 0,
			'page_title'  => 0,
		];

		Click::create($payload);
	}

    // Test Function
    public function unsubscribe(Request $request) {
    	$customer = Customer::findOrFail($request->customer);
    	$customer->unsubscribe = 1;
    	$customer->save();
    	return response()->redirectTo('https://frankiesautoelectrics.com.au/thank-you');
    	// return $customer;
    } 

    public function mythicalmorning(Request $request) {
    	


    	$items = [
			'headers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/0d4f9b8591b6b55f7366e229060f7928&01&1709255394.jpg'
				]
			],
			'subheaders-1' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/a548fa538a8132bda653828da10c09d6&02&1709255394.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale#kenwood-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/ea9c7014275c82e231dec235b3b7c11f&03&1709255394.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-dmx5020s-6-8-apple-carplay-android-auto-bluetooth-digital-multimedia-receiver',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/48f5b61c8f59cc355454c5b3a32effa5&04&1709255394.jpg'
				],
			],
			'featured-products-1' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-dmx7522s-7-av-receiver-with-wireless-apple-carplay-wireless-android-auto',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/97edd2428fd44fd98e50d81aa5fe1f5b&05&1709255394.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-dmx7522dabs',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/4aba23268a0ffd8dd060ba53292b6de0&06&1709255394.jpg'
					],
				],
			],
			'subheaders-2' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale#pioneer-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/8e0d26833c45a20911ae956eda27b3cb&07&1709255394.jpg'
				],
			],
			'featured-products-2' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dmhz5350bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/b3747edbaa0d8db421f4d296d7b37ae4&08&1709255394.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dmha5450bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/bf7fae43c0fc3d1721aaaf0182ac860d&09&1709255394.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dmha4450bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/d76b8cb276c6109885084b5f053dc3e9&010&1709255394.jpg'
					],
				]
			],
			'subheaders-3' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale#pioneer-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/a7e536ec1fa391a9bb777d93e05105fd&011&1709255394.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale#deals-you-cant-miss',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/49ad87a9989a4954a92e9daa63e3d125&012&1709255394.jpg'
				],
			],
			'featured-products-3' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/jvc-kw-m560bt-6-8-apple-carplay-android-auto-usb-mirroring-bluetooth-av-receiver',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/223ac200616760ae05cf612fdc966f0d&013&1709255394.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/blaupunkt-bp800play',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/d1ca25983944f188fb2ab760872c6a1f&014&1709255394.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/sony-xav-ax8100-8-95-apple-carplay-android-auto-digital-media-receiver-with-weblink%ef%b8%8f-cast',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/f07cc8e8687f81e5b0347c84e1801932&015&1709255394.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dmha245bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/9f3d698cd5bf9ac0284f58d15ad4ddea&016&1709255394.jpg'
					],
				],
			],
			'subheaders-4' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/2b50ccad00450661570dbbf80a23c986&017&1709255394.jpg'
				],
			],
			'featured-products-4' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dehs5250bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/0408ec8b60104fcaea4a6259a4cd70ff&018&1709255394.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-kdc-bt560u-cd-receiver-with-bluetooth',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/933aa1ce1a45a82c6c1b211b5838cd93&019&1709255394.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/clarion-cz315au-cd-mp3-receiver-w-bluetooth-intelligent-tune',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/7cbf7172724be71cff0330dfd2675b5e&020&1709255394.jpg'
					],
				],
			],
			'footers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/march-madness-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/80516781d89c192f976c126cef023fbf&026&1708926213.jpg',
				]
			],
		];

    	$campaign = Campaign::findOrFail(6);

		Customer::where(['unsubscribe' => 0])
		// ->whereNotIn('email', ['079brian@gmail.com', '13brenton@gmail.com', '13corey9@gmail.com', '555combo@gmail.com', 'A_arey3@hotmail.com', 'a.harris003@gmail.com', 'aaron.mcgifford@gmail.com', 'aaron@sivadgroup.com.au', 'aaroncomben88@hotmail.com', 'aaronsheedy386@gmail.com', 'abad.nathaniel@hotmail.com', 'acampt@bigpond.com', 'ACCOUNTS@BARWONHEADSMOTORS.COM.AU', 'accounts@bdprofessionals.com.au', 'accounts@hcautos.com.au', 'ace_skaf@hotmail.com', 'ad.hallie@gmail.com', 'adam.leeds@hotmail.com', 'adamguilfoyle854@gmail.com', 'adammcpherson91@gmail.com', 'admenzies@mac.com', 'Admin@ACCERMaintenance.com.au', 'admin@dcpowersolutions.com.au', 'admin@performanceauto.com.au', 'admin@rcae.com.au', 'admin@torontoautoelectrics.com.au', 'admin@wiredupcustoms.com.au', 'admspk@gmail.com', 'ahwassat@gmail.com', 'aidangvms@gmail.com', 'aidanmb107@gmail.com', 'ajdunstan2017@gmail.com', 'albrooksy@yahoo.com.au', 'alex.afflick@gmail.com', 'allanbeato1124@msn.com', 'Alluring_nemesis@outlook.com', 'alpreet_singh@hotmail.com', 'alyssa.bailey17@outlook.com', 'amahaul@bigpond.com', 'amos@picknowl.com.au', 'andrew.kallio@gmail.com', 'andrew@barrasons.com.au', 'andrew@edgehill.net.au', 'andrewbiffin2020@gmail.com', 'andrewscm98@gmail.com', 'ange.browne78@gmail.com', 'ankeau@gmail.com', 'anmac75@bigpond.com', 'annasims26@gmail.com', 'anthonywolff@hotmail.com', 'antlee99@yahoo.com.au', 'anton.ballza@gmail.com', 'apatten@cva.org.au', 'apexelevatorservices@outlook.com', 'apv.alog@gmail.com', 'ararat4x4@hotmail.com', 'armankam@gmail.com', 'aron@arotechsec.com', 'ashleynunn@live.com.au', 'atchisonangus@gmail.com', 'awlrenovations@outlook.com', 'Badrubberpiggy@gmail.com', 'baiden.skarpona@gmail.com', 'baonitsass@gmail.com', 'bdtimberfloors@hotmail.com', 'beauhanrahan72@gmail.com', 'ben.baker@shadcivil.com.au', 'ben.sambucco@foxmowing.com.au', 'bengee130@gmail.com', 'benhall198695@gmail.com', 'benjamin_thompson1995@hotmail.com', 'benjaminatkinson406@gmail.com', 'benjaminr02@outlook.com', 'benjburke78@gmail.com', 'benpatrickhoran@gmail.com', 'benwyckelsma@gmail.com', 'Betto82@outlook.com.au', 'big_g92@outlook.com', 'bignelljamie@gmail.com', 'bikramshrestha721@gmail.com', 'billywithers1999@gmail.com', 'blueykalbar@gmail.com', 'bobbykohli302@yahoo.com', 'bones_alfaboi@hotmail.com', 'bones@arach.net.au', 'bprichardson1@live.com.au', 'bradjmiller1983@gmail.com', 'Bradl3ywatson02@gmail.com', 'bradp@iinet.net.au', 'brandyarmstrong2@gmail.com', 'brarraman786@gmail.com', 'braydenaudio@gmail.com', 'braydon.d@auswidecorporate.com.au', 'brennywa@gmail.com', 'brentonr13@gmail.com', 'brett.samuel68@bigpond.com', 'brianmai_1@hotmail.com', 'brianseaman@bigpond.com', 'brockbudz420@gmail.com', 'brodyfarrall06@gmail.com', 'bryan.teo@gmail.com', 'bryaninoz@gmail.com', 'brycenicolaou0@gmail.com', 'bswprecision@gmail.com', 'burboandnic@gmail.com', 'burgswelding@outlook.com', 'burke.tj@gmail.com', 'burtonaaron90210@gmail.com', 'buzz1101@gmail.com', 'cah0707@gmail.com', 'Calcal1354@gmail.com', 'calebmoto@gmail.com', 'callam1997@hotmail.com', 'cameronjn1@outlook.com', 'cameronmacfarlane01@gmail.com', 'camj1981@gmail.com', 'carsci@live.com', 'catchkamath@gmail.com', 'cd_lewis@westnet.com.au', 'celvin.shovelar@gmail.com', 'Chambersjai14@gmail.com', 'chandy21@gmail.com', 'charlotte.gulliver06@outlook.com', 'cheryl@carringtonbends.com', 'chewybarker@hotmail.com', 'chloe23599@gmail.com', 'chris_blake7@hotmail.com', 'Chris.axel.Hecht@gmail.com', 'chris.weddall@hotmail.com', 'chrisandrachellane@yahoo.com.au', 'christianrobinson78@bigpond.com', 'christophermarskoch@gmail.com', 'chrisvtss@hotmail.com', 'chunter38@gmail.com', 'cjbarrett06@gmail.com', 'clemo75@bigpond.net.au', 'clintonkenny@hotmail.com', 'cobbmate@gmail.com', 'Coldapplepie@hotmail.com', 'Con.Stasinos@optusnet.com.au', 'connect@calmbuddhi.com.au', 'contact@washgroup.com.au', 'contacteded@gmail.com', 'cooperlewis370@yahoo.com.au', 'cooperneal147@gmail.com', 'Corey.tindall@outlook.com', 'cqae@optusnet.com.au', 'craftechplumbing@gmail.com', 'craig.ntcc@gmail.com', 'craiggormley79@gmail.com', 'craigjohnson-@hotmail.com', 'cruising.customs@gmail.com', 'dac803@live.com.au', 'dale.cameron@universalcranes.com', 'dalecuevas06@yahoo.com', 'damonramma2005@gmail.com', 'dan_mx284@hotmail.com', 'dan.westsec@gmail.com', 'dann.evans19@gmail.com', 'dannyvlass@outlook.com', 'darrenlam2708@gmail.com', 'darrynjb@mac.com', 'david.hall86@bigpond.com', 'david.mirtschin@hotmail.com', 'Daviddoig89@outlook.com', 'davis.warren@hotmail.com', 'davowalcott@gmail.com', 'dbillo@optusnet.com.au', 'dborrowdale@hotmail.com', 'ddrssmith@gmail.com', 'dean.s@teakindustrial.com.au', 'deancook@live.com.au', 'dekota679@optusnet.com.au', 'delg.dlg@bigpond.com', 'deranged1973@gmail.com', 'Dermottlongley@outlook.com', 'dfendr@TPG.COM.AU', 'dhdp1@bigpond.com', 'dickson.sb.wu@gmail.com', 'dimensionhair@gmail.com', 'Divesparks@yahoo.com.au', 'dndcarpentry11@gmail.com', 'don2garcia@gmail.com', 'donna.white4@bigpond.com', 'dorlando_100@hotmail.com', 'dougtucker101@gmail.com', 'dr.john.hornbuckle@gmail.com', 'dt22615@gmail.com', 'duanebutler7@bigpond.com', 'duckteale@yahoo.com.au', 'dukulani@bigpond.com', 'dumont.ma5@gmail.com', 'duncan.eddy3@gmail.com', 'dylansberg@gmail.com', 'eazyvz182@hotmail.com', 'ecoelec@yahoo.com.au', 'ed@daveymotorgroup.com', 'embleton.trent@hotmail.com', 'emily.boag2@gmail.com', 'emmanueleboma@live.com.au', 'enwelsh@outlook.com', 'eric@evautoelectrical.com', 'erin.litherland@icloud.com', 'erin.powell2005@gmail.com', 'essjayb@gmail.com', 'ethantribe@outlook.com.au', 'f.baker98@hotmail.com', 'fabulous1@bigpond.com', 'farooqui.saad@gmail.com', 'feilimclarke@gmail.com', 'Flukes_360@hotmail.com', 'forbes_machine@hotmail.com', 'ford007@live.com.au', 'frasermhewitt@gmail.com', 'g_evans@live.com.au', 'g.n.x@live.com', 'gabiirvine4@gmail.com', 'garthobrien27@gmail.com', 'george.james7@hotmail.com', 'George@vitelectrical.com.au', 'gerhard_777@hotmail.com', 'gerritlaub@gmail.com', 'gilchrist.roy@gmail.com', 'gilmore.aeac@gmail.com', 'gnwattie@bigpond.com', 'goldenrob71@gmail.com', 'gorroickhouse@hotmail.com', 'grant@rkhtestandtag.com.au', 'grantbaird@bigpond.com', 'grapnell@hotmail.com', 'guselibikes@gmail.com', 'guyforsyth@gmail.com', 'hall.ashley@hotmail.com.au', 'hamish.mcmurdie@gmail.com', 'harro.1981@gmail.com', 'haydenmaunder@gmail.com', 'heath0818@gmail.com', 'hicks.michael79@gmail.com', 'hilift01@gmail.com', 'hippossuperwash@bigpond.com', 'hislux@hotmail.com', 'hornunga@live.com.au', 'howardbg1@bigpond.com', 'hrt_racer_1@hotmail.com', 'Htcalder@gmail.com', 'hugh.sherwood17@gmail.com', 'hurst.jay1@gmail.com', 'iansmail@bigpond.net.au', 'imamakbuksh@gmail.com', 'insidelane@gmail.com', 'insufficientdopamine@gmail.com', 'Ironizaac@hotmail.com', 'ismilekimura@gmail.com', 'izabella2013.kw@gmail.com', 'jackkiker0@gmail.com', 'jackkluske@hotmail.com', 'jacksprat_69@hotmail.com', 'jaivebarber1998@gmail.com', 'jake.battelley1@hotmail.com', 'Jake@wiredmobileautoelectrics.com', 'jakejohnson584@hotmail.com', 'james.booth@live.com.au', 'james.scattolin@hotmail.com', 'james@icounsel.com.au', 'jamescraiglawrence@gmail.com', 'jamesjeffcoat88@gmail.com', 'jameslbunt@hotmail.com', 'jamesmatch13@gmail.com', 'janepaul@adam.com.au', 'jarradlutz10@outlook.com', 'jarrodng8@gmail.com', 'jasetomada27@gmail.com', 'jasmoonee@gmail.com', 'jasonmccarthy518@gmail.com', 'Jay@allbids.com.au', 'jayden.marciano@gmail.com', 'jayden.work99@gmail.com', 'jaydoson98@gmail.com', 'jermsy111@gmail.com', 'jessmydog@outlook.com', 'jezstrt@gmail.com', 'jimmy.hampel@hotmail.com', 'jimmy.sculler@gmail.com', 'jimmyread9@gmail.com', 'jjalfred3@yahoo.com', 'jmmangubat13@gmail.com', 'jodi.breen@bigpond.com', 'jodie.marcelm@gmx.com', 'joe@tta.com.au', 'john.bugler2002@gmail.com', 'john.sanders12g@gmail.com', 'john.williamson@outlook.com.au', 'johnny.tran95@gmail.com', 'johnny1985@hotmail.com.au', 'johnnynguyen._@hotmail.com', 'jono.olivier@live.com.au', 'jordan@carroll.net.au', 'josh9932@hotmail.com', 'josieatt@optusnet.com.au', 'jrcdennehy@gmail.com', 'js@hm.com', 'jtmorey77@gmail.com', 'julietan50@gmail.com', 'Justin.finnigan@hotmail.com', 'Justinwtucker@bigpond.com', 'jwilligram@hotmail.com', 'jyhatchman@hotmail.com', 'k_nicolaou@hotmail.com', 'k.backhouse@hotmail.com', 'k.stargard@gmail.com', 'karapandzastefan@gmail.com', 'karen.mccusker@hotmail.com', 'katesheehan95@hotmail.com', 'kaydenjames2007@gmail.com', 'kearo6@hotmail.com', 'keblakre23@gmail.com', 'kendell.saffin5@gmail.com', 'kendonaldson@activ8.net.au', 'kenslatter@live.com.au', 'kial_morgan123@outlook.com', 'kienbuckman@hotmail.com', 'kim.bradd40@gmail.com', 'kimin.mccaffrey@gmail.com', 'kiranpokhreel1997@gmail.com', 'kleeh@hotmail.com', 'kmokhtar@hotmail.com', 'knighter58@outlook.com', 'kodie4@gmail.com', 'kody295@hotmail.com', 'kojo_hhh@hotmail.com', 'krissmaru195@gmail.com', 'kriszids@hotmail.com', 'kronos07@adam.com.au', 'kser.razon@gmail.com', 'kt.mouse@hotmail.com', 'kurtw85@gmail.com', 'kurvinr@gmail.com', 'kye.eggleton@outlook.com', 'lachlan.harburg@gmail.com', 'lachlanhh1745@gmail.com', 'laine.johnson26@gmail.com', 'laurencetrent@hotmail.com', 'lawriecatterson@hotmail.com', 'lawsonk_22@yahoo.com', 'leroy.lim98@yahoo.com', 'les67@live.com.au', 'Lewisglenister@hotmail.com', 'liambonsall@hotmail.com', 'Liamvalente@y7mail.com', 'lil_miss_rainbow89@hotmail.com', 'ljaeger1998@outlook.com', 'llihou@hotmail.com', 'lmeyers4@icloud.com', 'lnkz.cp@hotmail.com', 'lukeoc777@hotmail.com', 'luketelfordd@gmail.com', 'lynmark1@bigpond.com', 'macsel77@outlook.com', 'magpieridge@outlook.com', 'mahunt20@gmail.com', 'mailtristan@gmail.com', 'marco@ditrentodemolition.com.au', 'mark_20-6-1994@hotmail.com', 'matshaz7@bigpond.com', 'matt_hassett@hotmail.com', 'matt.roblockster@gmail.com', 'matthew.croese@hotmail.com', 'matthewmikejames@gmail.com', 'Matthughes4489@gmail.com', 'mattwgilroy@yahoo.com.au', 'maxgawler6@gmail.com', 'maxharis6299@gmail.com', 'mcwillis88@gmail.com', 'meganliang7@gmail.com', 'meghan.peacock1979@gmail.com', 'micgrob@aol.com', 'michael_francis5@hotmail.com', 'michael.1514@hotmail.com', 'michael.h@custombuiltprojects.com', 'Michael.rashleigh2005@gmail.com', 'michael@oneconnectaus.com.au', 'michaelbas24@hotmail.com', 'michaeljamesdev@icloud.com', 'michlaird@gmail.com', 'Micksdiscovery@gmail.com', 'mike19482@hotmail.com', 'mikeevillamor@icloud.com', 'mikew2340@gmail.com', 'mitchellcittadini@gmail.com', 'MJD.design@live.com', 'mjmonaghan12@bigpond.com', 'mmodrive@gmail.com', 'mobile12vhobart@gmail.com', 'morrisrjr@hotmail.com', 'morrissey089@gmail.com', 'mpitch1@bigpond.com', 'mtreekie@gmail.com', 'muldercrew@hotmail.com', 'my_other_shoe@hotmail.com', 'n77baker@yahoo.com.au', 'nabih.yaacoub@gmail.com', 'nahouli.456@gmail.com', 'nariman.d97@gmail.com', 'nathanaldous@hotmail.com', 'nathannicastri@hotmail.com', 'nathanveness@yahoo.com.au', 'neophitosandreou2001@gmail.com', 'nguyenphuoc204@gmail.com', 'nicholasnicou@hotmail.com', 'nick.colquhoun@outlook.com', 'nickjessop05@icloud.com', 'nickmumford@bigpond.com', 'nicoleclark@outlook.com.au', 'nidz@nidz.net', 'nissm0@hotmail.com', 'nlfmjy@hotmail.com', 'nodules-08-stopper@icloud.com', 'nokialaw1210@gmail.com', 'nomnob@gmail.com', 'nooonga121@hotmail.com', 'nortongl@westnet.com.au', 'nswenson03@gmail.com', 'ola.nicklason@live.com.au', 'oliver_dickson@hotmail.com', 'omarr.sleiman@gmail.com', 'omarz666@hotmail.com', 'oscar.kaye@gmail.com', 'oscar00perry@outlook.com', 'otoo7190@gmail.com', 'ovasales@bigpond.com', 'owenjlea@icloud.com', 'p.walnuts@gmail.com', 'paddy.keane@hotmail.com', 'pamiesan@bigpond.com', 'patrick.lillicrap@gmail.com', 'paul.kinbacher@gmail.com', 'paul.landrigan@bigpond.com', 'Paul231960@gmail.com', 'paulfhuxtable@gmail.com', 'pauljsands@yahoo.com', 'paultancredi@yahoo.com.au', 'perrybsm@gmail.com', 'petarprotic1@gmail.com', 'pete@martingalleries.com.au', 'peter_g_elliss@arnotts.com', 'peter_lupton@bigpond.com', 'peter.r.dean@outlook.com', 'pgrange63@gmail.com', 'pham.hoaa@hotmail.com', 'philhod@bigpond.com', 'pj_bester@bigpond.com', 'pj_captainsflat@yahoo.com.au', 'primeceilings@iprimus.com.au', 'princeautoelectrical@outlook.com', 'prof.yakkle@gmail.com', 'psullivan@live.com.au', 'Quyen.duong303@gmail.com', 'randj12@optusnet.com.au', 'raul@benchmarkautoelectrical.com.au', 'Ravenbrandon2484@gmail.com', 'razorzedge666@hotmail.com', 'rckostrz@gmail.com', 'rebeccabrooks01@outlook.com', 'reubenkershawmchugh@gmail.com', 'rick.tipper64@gmail.com', 'rickylawrence86@gmail.com', 'rikigreene1@bigpond.com', 'rlgclews@bigpond.com', 'rob@cpvehicles.com.au', 'robert.wilkinson@uqconnect.edu.au', 'robert29knowles@outlook.com', 'robertwarner.bt@gmail.com', 'robsonbuzios@hotmail.com', 'roger.wilkinson@internode.on.net', 'ronaldhiggs0@gmail.com', 'rwbadenoch@gmail.com', 'rx7nac@yahoo.com.au', 'Ryan@dawescoelectrical.com.au', 'Ryancatanz@outlook.com.au', 'ryanclark1991@gmail.com', 'rydersurf123@gmail.com', 'sales@carpartsonline.net.au', 'salter.paul@hotmail.com', 'sam_borromei@hotmail.com', 'sam@truinstalls.com.au', 'samuel.jones260603@gmail.com', 'samuel.lutzke@gmail.com', 'sarah_ong96@hotmail.com', 'scleung0918@gmail.com', 'scoie96@hotmail.com', 'scoobyrexx@gmail.com', 'scott.dove80@gmail.com', 'scottheather.sh@gmail.com', 'sduffield2@gmail.com', 'seager@internode.on.net', 'sebastian.deepak84@gmail.com', 'shadplumb@westvic.com.au', 'shaip_t@hotmail.com', 'Shanebmorton@gmail.com', 'shaneengle@hotmail.com', 'sharon@bmhearth.com', 'shaun_p_rees@hotmail.com', 'shaunwingrove@hotmail.com', 'shelaway17@gmail.com', 'shesmy_ute@hotmail.com', 'shilousa@outlook.com', 'simone.louise.h@gmail.com', 'simonkentwell@hotmail.com', 'simonloughhead@hotmail.com', 'sirmikey11@gmail.com', 'sjdeutscher@gmail.com', 'skuffer@bigpond.net.au', 'Slj_is@hotmail.com', 'sonya6462@bigpond.com', 'specialbega@gmail.com', 'starchaser93@gmail.com', 'stefan.vujevic@gmail.com', 'stefan8868@hotmail.com', 'stephen.nunn@bigpond.com', 'stephen.patterson@bigpond.com', 'stevelkneivel@gmail.com', 'steven.hogan99@gmail.com', 'steven@dreamcapital.com.au', 'stotty1995@hotmail.com', 'stuartfarrell@hotmail.com', 'tam_riley@hotmail.com', 'tarranjepsen@gmail.com', 'tattsalli@gmail.com', 'teleptaylor@gmail.com', 'the.simpsonsx4@bigpond.com', 'thomasmckerlie@live.com.au', 'thomasstokes94@hotmail.com', 'tiff.jensz@gmail.com', 'tim.howard87@gmail.com', 'timgraham888@gmail.com', 'timmy351@yahoo.com.au', 'timothynissen2002@gmail.com', 'tjralow@bigpond.com', 'tms1412.ts@gmail.com', 'tmt397@icloud.com', 'tnxk020@gmail.com', 'tombull1985@gmail.com', 'tomfoat@gmail.com', 'tomhouston123@gmail.com', 'tonky074@hotmail.com', 'tony.vera@bigpond.com', 'tonyg@mako.com.au', 'tpearce1175@gmail.com', 'tracybattersby@hotmail.com', 'travisbell888@hotmail.com', 'travisgill308@hotmail.com', 'trenteyles@gmail.com', 'troy@trojanim.com.au', 'TSGcarpentry@outlook.com.au', 'turnersamuel01@gmail.com', 'twoodhouse77@outlook.com', 'tylerandteneale@outlook.com', 'uranda5@bigpond.com', 'vasanthajith@hotmail.com', 'vijayshrinivas@gmail.com', 'vimissvi@hotmail.com', 'vinceallgood@gmail.com', 'vuthanhkinhte@gmail.com', 'walkerandrew014@gmail.com', 'waygoodwin@hotmail.com', 'wayneknight76@gmail.com', 'waynemaclagan62@yahoo.com.au', 'weh84d@gmail.com', 'wellsharry604@gmail.com', 'william.r.clement@gmail.com', 'wilson.riley27@gmail.com', 'wolvesbikeden.sales@gmail.com', 'xlfisher@gmail.com', 'y.liu24@hotmail.com', 'ypasnin@gmail.com', 'zac.brown1047@gmail.com', 'zac.pullen@icloud.com'])
		->whereIn('email', [
			'theodore@frankiesautoelectrics.com.au',
			// 'jr@frankiesautoelectrics.com.au', 
			// 'rodney@frankiesautoelectrics.com.au',
		// 	// 'angela@frankiesautoelectrics.com.au', 
		// 	// 'jay@frankiesautoelectrics.com.au', 
		// 	// 'marnell@frankiesautoelectrics.com.au', 
		// 	// 'eric@frankiesautoelectrics.com.au'
			
		])
		->where(function($query) use ($campaign) {
			$query->where('campaign_status', null);
			$query->orWhere('campaign_status', 'NOT LIKE', '%febsale'.$campaign->campaign_id.';%');
		})
		->orderBy('created_at', 'DESC')
		->chunk(50, function($customers) use ($campaign, $items) {
			foreach ($customers as $customer) {
				$customer->campaign_status .= 'febsale'. $campaign->campaign_id . ';';
				$customer->save();
				$subject = '🎉 Blast Off into Savings, '.$customer->first_name.'! Frankies\' March Madness Sale on Head Units!';
				SendCampaignTwoEmail::dispatch($subject, $campaign, $customer, $items)->onQueue('campaign_two');

				// $subject = 'Exclusive for You, ' . $customer->first_name . '! Save Big on EUFY Home Security at Frankies\' Febtastic Deals! 🛡️';
				// $subject = 'Febtastic Deals: Grab \'Em Before They\'re Gone, '.$customer->first_name.'! 🚗🌟';
			    // Mail::to($customer->email)
			    // 		->bcc(['theodore@frankiesautoelectrics.com.au'])
			    // 		->queue((new MarchCampaignMadness($subject, $campaign, $customer, $items))->onQueue('campaign_one'));

			}
		});


		return 1;

		$items = [


			// 'headers' => [
			// 	[
			// 		'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/3b1eac1caa522c53ce98703a234de1eb&01&1708492709.jpg'
			// 	]
			// ],
			// 'subheaders-1' => [
			// 	[
			// 		'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/350eb1d9b32c73b2e620e2585fcea03f&02&1708492709.jpg'
			// 	],
			// 	[
			// 		'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8852cd1',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/58091277233ca52e070797a80399f956&03&1708492709.jpg',
			// 	]
			// ],
			// 'featured-products-1' => [
			// 	[
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8851cd1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/215413ae7c67fff79a4cb29204f8187c&04&1708492709.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8853cd1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/85090af75085756cc692a4be21547b14&05&1708492709.jpg',
			// 		],
			// 	]
			// ],
			// 'subheaders-2' => [
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/79ea2861949a4e6b46eedf33bbcd89d8&06&1708492709.jpg',
			// 	],
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/product/eufy-e8213c12',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/9c185f6f5d9c8c34ace8b55ef6fa7e36&07&1708492709.jpg',
			// 	],
			// ],
			// 'featured-products-2' => [
			// 	[
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8220cw1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/35b4515eb9c41b3a76ccc1fb1cfd3fc4&08&1708492709.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8210cw1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/628ea68653e9c6fefb86c4c7246de505&09&1708492709.jpg',
			// 		],
			// 	]
			// ],
			// 'subheaders-3' => [
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/d23107e8a7e57e493e1a891f9f7e8f71&010&1708492709.jpg',
			// 	],
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/product/eufy-t8400cw4',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/f0d9047c2fdfef4d3632f2bfe70f9104&011&1708492709.jpg',
			// 	],
			// ],
			// 'featured-products-3' => [
			// 	[
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8410c24',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/94d57c8807267d6d1365e3d20c23471f&012&1708492709.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8416t21',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/ecf9fd237763832b721ebadc6d96563d&013&1708492709.jpg',
			// 		],
			// 	]
			// ],
			// 'subheaders-4' => [
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/210187cae9023f211afb89f316b944e4&014&1708492709.jpg',
			// 	],
			// ],
			// 'featured-products-4' => [
			// 	[
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8871tw1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/924004ab0e6e812afec3f674fd23b921&015&1708492709.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8873tw1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/fd9dbf7616b3c0bc029e3afce7ac82d4&016&1708492709.jpg',
			// 		],
			// 	]
			// ],
			// 'subheaders-5' => [
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/da949a4ddb7b2add4b362cc0eeb0db2d&017&1708492709.jpg',
			// 	],
			// ],
			// 'featured-products-5' => [
			// 	[
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8425c21',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/49fa0dcdda0d1db51c388b62216c778c&018&1708496320.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t84a1c11',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/989e115e4f55693af8f39f76c63d2e00&019&1708496320.jpg',
			// 		],
			// 		[
			// 			'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8170cw1',
			// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/3c40b74e557df25fc64c790fa5db6b6c&020&1708496320.jpg',
			// 		],
			// 	]
			// ],


			// 'footers' => [
			// 	[
			// 		'url' => 'https://frankiesautoelectrics.com.au/',
			// 		'image' => 'https://ultimatehosting.blackedgedigital.com/images/e15ac515868ae4d34b3b77f9fb82f52f&022&1708496594.jpg',
			// 	],
			// ],


			'headers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/cc68394dfee00ea64687482749c2cfd1&01&1708921986.jpg'
				]
			],
			'subheaders-1' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale#dynamat-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/b29b1b50cbe3120ed8193f4f1137b643&02&1708921986.jpg'
				],
			],
			'featured-products-1' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-10425',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/c3f0008d5e25b634773360ec6f2909f6&03&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-11905',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/8da671867d414cf8ae33e5ea42eec835&04&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-21100',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/de2687f309c6a09a7c3b0a6254f71cf0&05&1708921986.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-10435',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/5ab9d8674efc774d7ea5953e91a72389&06&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-10648',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/0a1b94286fa5f6ba121e04e9aa37452f&07&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-11101',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/b117d46776c43db70b87cc26c336a6b7&08&1708921986.jpg'
					],
				],
			],
			'featured-products-1-1' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-10465',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/57e4f2d7a6a725271121be56363bb68c&09&1708921986.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-13100',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/a692c8b7f2d6f032c746bd357598bd03&010-1&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/dynamat-10008',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/c6a22af47a8922f27ce70a40025f3f3c&010-2&1708921986.jpg'
					],
				]
			],
			'subheaders-2' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/66a995db07f0783df9542c81f1006dab&011&1708921986.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/ff6259b4c90eaaac8d4cdc457f61ba64&012&1708921986.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/thunder-tdr02015-12v-800a-peak-lithium-jump-starter-power-bank',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/84be774c1a5302da5ccf1caed35b8c99&013&1708921986.jpg'
				],
			],
			'featured-products-2' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/projecta-is1220',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/ac13e21cd18c3a026eb3242aa246d86b&014-2&1708925710.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/projecta-is1500',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/25981356012d499a36c897844008a2c0&015-2&1708925710.jpg'
					],
				]
			],
			'subheaders-3' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/596818a7cc50ce065be69890f0d8bd74&016&1708921986.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/thunder-tdr02021',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/3fe7de7706cc0165905d3e529bfab447&017&1708921986.jpg'
				],
			],
			'featured-products-3' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/thunder-tdr02112-12a-8-stage-pulse-battery-charger-12v',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/1479f9464e3a696eb7ee9540915893fc&018&1708921986.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/thunder-tdr02020-20a-dc-dc-charger-with-mppt-solar-regulator',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/0299f5016b96321730f988f8b478f8fa&019&1708921986.jpg'
					],
				]
			],
			'subheaders-4' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/f120f54d4366f7ee844764e956b1cc2a&020&1708926213.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/ctek-mxs-5-0',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/e64830728ca2ddb2c5e1a8e165a67aac&021&1708926213.jpg'
				],
			],
			'featured-products-4' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/ctek-mxts40-battery-charger-12v-40amp-24v-20amp',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/3bf366f0497d6e9975f08d15a5d6933d&022&1708926213.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/ctek-smartpass-120s-120a-12v-power-management-system-for-starter-and-service-batteries',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/e22676b04de2915222a03e99d25d97fd&023&1708926213.jpg'
					],
				],
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/ctek-mxs-7-0-12v-7a-battery-charger-and-maintainer',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/2b1bb70dc27a17f8241dd6b6b299bd11&024&1708926213.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/ctek-ct5-start-stop-12v-3-8a-battery-charger-and-maintainer',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/57f1b73fc6a01f118583243e7e31772d&025&1708926213.jpg'
					],
				]
			],
			'footers' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/80516781d89c192f976c126cef023fbf&026&1708926213.jpg',
				]
			],
		];

    	$campaign = Campaign::findOrFail(5);

		Customer::where(['unsubscribe' => 0])
		// ->whereNotIn('email', ['079brian@gmail.com', '13brenton@gmail.com', '13corey9@gmail.com', '555combo@gmail.com', 'A_arey3@hotmail.com', 'a.harris003@gmail.com', 'aaron.mcgifford@gmail.com', 'aaron@sivadgroup.com.au', 'aaroncomben88@hotmail.com', 'aaronsheedy386@gmail.com', 'abad.nathaniel@hotmail.com', 'acampt@bigpond.com', 'ACCOUNTS@BARWONHEADSMOTORS.COM.AU', 'accounts@bdprofessionals.com.au', 'accounts@hcautos.com.au', 'ace_skaf@hotmail.com', 'ad.hallie@gmail.com', 'adam.leeds@hotmail.com', 'adamguilfoyle854@gmail.com', 'adammcpherson91@gmail.com', 'admenzies@mac.com', 'Admin@ACCERMaintenance.com.au', 'admin@dcpowersolutions.com.au', 'admin@performanceauto.com.au', 'admin@rcae.com.au', 'admin@torontoautoelectrics.com.au', 'admin@wiredupcustoms.com.au', 'admspk@gmail.com', 'ahwassat@gmail.com', 'aidangvms@gmail.com', 'aidanmb107@gmail.com', 'ajdunstan2017@gmail.com', 'albrooksy@yahoo.com.au', 'alex.afflick@gmail.com', 'allanbeato1124@msn.com', 'Alluring_nemesis@outlook.com', 'alpreet_singh@hotmail.com', 'alyssa.bailey17@outlook.com', 'amahaul@bigpond.com', 'amos@picknowl.com.au', 'andrew.kallio@gmail.com', 'andrew@barrasons.com.au', 'andrew@edgehill.net.au', 'andrewbiffin2020@gmail.com', 'andrewscm98@gmail.com', 'ange.browne78@gmail.com', 'ankeau@gmail.com', 'anmac75@bigpond.com', 'annasims26@gmail.com', 'anthonywolff@hotmail.com', 'antlee99@yahoo.com.au', 'anton.ballza@gmail.com', 'apatten@cva.org.au', 'apexelevatorservices@outlook.com', 'apv.alog@gmail.com', 'ararat4x4@hotmail.com', 'armankam@gmail.com', 'aron@arotechsec.com', 'ashleynunn@live.com.au', 'atchisonangus@gmail.com', 'awlrenovations@outlook.com', 'Badrubberpiggy@gmail.com', 'baiden.skarpona@gmail.com', 'baonitsass@gmail.com', 'bdtimberfloors@hotmail.com', 'beauhanrahan72@gmail.com', 'ben.baker@shadcivil.com.au', 'ben.sambucco@foxmowing.com.au', 'bengee130@gmail.com', 'benhall198695@gmail.com', 'benjamin_thompson1995@hotmail.com', 'benjaminatkinson406@gmail.com', 'benjaminr02@outlook.com', 'benjburke78@gmail.com', 'benpatrickhoran@gmail.com', 'benwyckelsma@gmail.com', 'Betto82@outlook.com.au', 'big_g92@outlook.com', 'bignelljamie@gmail.com', 'bikramshrestha721@gmail.com', 'billywithers1999@gmail.com', 'blueykalbar@gmail.com', 'bobbykohli302@yahoo.com', 'bones_alfaboi@hotmail.com', 'bones@arach.net.au', 'bprichardson1@live.com.au', 'bradjmiller1983@gmail.com', 'Bradl3ywatson02@gmail.com', 'bradp@iinet.net.au', 'brandyarmstrong2@gmail.com', 'brarraman786@gmail.com', 'braydenaudio@gmail.com', 'braydon.d@auswidecorporate.com.au', 'brennywa@gmail.com', 'brentonr13@gmail.com', 'brett.samuel68@bigpond.com', 'brianmai_1@hotmail.com', 'brianseaman@bigpond.com', 'brockbudz420@gmail.com', 'brodyfarrall06@gmail.com', 'bryan.teo@gmail.com', 'bryaninoz@gmail.com', 'brycenicolaou0@gmail.com', 'bswprecision@gmail.com', 'burboandnic@gmail.com', 'burgswelding@outlook.com', 'burke.tj@gmail.com', 'burtonaaron90210@gmail.com', 'buzz1101@gmail.com', 'cah0707@gmail.com', 'Calcal1354@gmail.com', 'calebmoto@gmail.com', 'callam1997@hotmail.com', 'cameronjn1@outlook.com', 'cameronmacfarlane01@gmail.com', 'camj1981@gmail.com', 'carsci@live.com', 'catchkamath@gmail.com', 'cd_lewis@westnet.com.au', 'celvin.shovelar@gmail.com', 'Chambersjai14@gmail.com', 'chandy21@gmail.com', 'charlotte.gulliver06@outlook.com', 'cheryl@carringtonbends.com', 'chewybarker@hotmail.com', 'chloe23599@gmail.com', 'chris_blake7@hotmail.com', 'Chris.axel.Hecht@gmail.com', 'chris.weddall@hotmail.com', 'chrisandrachellane@yahoo.com.au', 'christianrobinson78@bigpond.com', 'christophermarskoch@gmail.com', 'chrisvtss@hotmail.com', 'chunter38@gmail.com', 'cjbarrett06@gmail.com', 'clemo75@bigpond.net.au', 'clintonkenny@hotmail.com', 'cobbmate@gmail.com', 'Coldapplepie@hotmail.com', 'Con.Stasinos@optusnet.com.au', 'connect@calmbuddhi.com.au', 'contact@washgroup.com.au', 'contacteded@gmail.com', 'cooperlewis370@yahoo.com.au', 'cooperneal147@gmail.com', 'Corey.tindall@outlook.com', 'cqae@optusnet.com.au', 'craftechplumbing@gmail.com', 'craig.ntcc@gmail.com', 'craiggormley79@gmail.com', 'craigjohnson-@hotmail.com', 'cruising.customs@gmail.com', 'dac803@live.com.au', 'dale.cameron@universalcranes.com', 'dalecuevas06@yahoo.com', 'damonramma2005@gmail.com', 'dan_mx284@hotmail.com', 'dan.westsec@gmail.com', 'dann.evans19@gmail.com', 'dannyvlass@outlook.com', 'darrenlam2708@gmail.com', 'darrynjb@mac.com', 'david.hall86@bigpond.com', 'david.mirtschin@hotmail.com', 'Daviddoig89@outlook.com', 'davis.warren@hotmail.com', 'davowalcott@gmail.com', 'dbillo@optusnet.com.au', 'dborrowdale@hotmail.com', 'ddrssmith@gmail.com', 'dean.s@teakindustrial.com.au', 'deancook@live.com.au', 'dekota679@optusnet.com.au', 'delg.dlg@bigpond.com', 'deranged1973@gmail.com', 'Dermottlongley@outlook.com', 'dfendr@TPG.COM.AU', 'dhdp1@bigpond.com', 'dickson.sb.wu@gmail.com', 'dimensionhair@gmail.com', 'Divesparks@yahoo.com.au', 'dndcarpentry11@gmail.com', 'don2garcia@gmail.com', 'donna.white4@bigpond.com', 'dorlando_100@hotmail.com', 'dougtucker101@gmail.com', 'dr.john.hornbuckle@gmail.com', 'dt22615@gmail.com', 'duanebutler7@bigpond.com', 'duckteale@yahoo.com.au', 'dukulani@bigpond.com', 'dumont.ma5@gmail.com', 'duncan.eddy3@gmail.com', 'dylansberg@gmail.com', 'eazyvz182@hotmail.com', 'ecoelec@yahoo.com.au', 'ed@daveymotorgroup.com', 'embleton.trent@hotmail.com', 'emily.boag2@gmail.com', 'emmanueleboma@live.com.au', 'enwelsh@outlook.com', 'eric@evautoelectrical.com', 'erin.litherland@icloud.com', 'erin.powell2005@gmail.com', 'essjayb@gmail.com', 'ethantribe@outlook.com.au', 'f.baker98@hotmail.com', 'fabulous1@bigpond.com', 'farooqui.saad@gmail.com', 'feilimclarke@gmail.com', 'Flukes_360@hotmail.com', 'forbes_machine@hotmail.com', 'ford007@live.com.au', 'frasermhewitt@gmail.com', 'g_evans@live.com.au', 'g.n.x@live.com', 'gabiirvine4@gmail.com', 'garthobrien27@gmail.com', 'george.james7@hotmail.com', 'George@vitelectrical.com.au', 'gerhard_777@hotmail.com', 'gerritlaub@gmail.com', 'gilchrist.roy@gmail.com', 'gilmore.aeac@gmail.com', 'gnwattie@bigpond.com', 'goldenrob71@gmail.com', 'gorroickhouse@hotmail.com', 'grant@rkhtestandtag.com.au', 'grantbaird@bigpond.com', 'grapnell@hotmail.com', 'guselibikes@gmail.com', 'guyforsyth@gmail.com', 'hall.ashley@hotmail.com.au', 'hamish.mcmurdie@gmail.com', 'harro.1981@gmail.com', 'haydenmaunder@gmail.com', 'heath0818@gmail.com', 'hicks.michael79@gmail.com', 'hilift01@gmail.com', 'hippossuperwash@bigpond.com', 'hislux@hotmail.com', 'hornunga@live.com.au', 'howardbg1@bigpond.com', 'hrt_racer_1@hotmail.com', 'Htcalder@gmail.com', 'hugh.sherwood17@gmail.com', 'hurst.jay1@gmail.com', 'iansmail@bigpond.net.au', 'imamakbuksh@gmail.com', 'insidelane@gmail.com', 'insufficientdopamine@gmail.com', 'Ironizaac@hotmail.com', 'ismilekimura@gmail.com', 'izabella2013.kw@gmail.com', 'jackkiker0@gmail.com', 'jackkluske@hotmail.com', 'jacksprat_69@hotmail.com', 'jaivebarber1998@gmail.com', 'jake.battelley1@hotmail.com', 'Jake@wiredmobileautoelectrics.com', 'jakejohnson584@hotmail.com', 'james.booth@live.com.au', 'james.scattolin@hotmail.com', 'james@icounsel.com.au', 'jamescraiglawrence@gmail.com', 'jamesjeffcoat88@gmail.com', 'jameslbunt@hotmail.com', 'jamesmatch13@gmail.com', 'janepaul@adam.com.au', 'jarradlutz10@outlook.com', 'jarrodng8@gmail.com', 'jasetomada27@gmail.com', 'jasmoonee@gmail.com', 'jasonmccarthy518@gmail.com', 'Jay@allbids.com.au', 'jayden.marciano@gmail.com', 'jayden.work99@gmail.com', 'jaydoson98@gmail.com', 'jermsy111@gmail.com', 'jessmydog@outlook.com', 'jezstrt@gmail.com', 'jimmy.hampel@hotmail.com', 'jimmy.sculler@gmail.com', 'jimmyread9@gmail.com', 'jjalfred3@yahoo.com', 'jmmangubat13@gmail.com', 'jodi.breen@bigpond.com', 'jodie.marcelm@gmx.com', 'joe@tta.com.au', 'john.bugler2002@gmail.com', 'john.sanders12g@gmail.com', 'john.williamson@outlook.com.au', 'johnny.tran95@gmail.com', 'johnny1985@hotmail.com.au', 'johnnynguyen._@hotmail.com', 'jono.olivier@live.com.au', 'jordan@carroll.net.au', 'josh9932@hotmail.com', 'josieatt@optusnet.com.au', 'jrcdennehy@gmail.com', 'js@hm.com', 'jtmorey77@gmail.com', 'julietan50@gmail.com', 'Justin.finnigan@hotmail.com', 'Justinwtucker@bigpond.com', 'jwilligram@hotmail.com', 'jyhatchman@hotmail.com', 'k_nicolaou@hotmail.com', 'k.backhouse@hotmail.com', 'k.stargard@gmail.com', 'karapandzastefan@gmail.com', 'karen.mccusker@hotmail.com', 'katesheehan95@hotmail.com', 'kaydenjames2007@gmail.com', 'kearo6@hotmail.com', 'keblakre23@gmail.com', 'kendell.saffin5@gmail.com', 'kendonaldson@activ8.net.au', 'kenslatter@live.com.au', 'kial_morgan123@outlook.com', 'kienbuckman@hotmail.com', 'kim.bradd40@gmail.com', 'kimin.mccaffrey@gmail.com', 'kiranpokhreel1997@gmail.com', 'kleeh@hotmail.com', 'kmokhtar@hotmail.com', 'knighter58@outlook.com', 'kodie4@gmail.com', 'kody295@hotmail.com', 'kojo_hhh@hotmail.com', 'krissmaru195@gmail.com', 'kriszids@hotmail.com', 'kronos07@adam.com.au', 'kser.razon@gmail.com', 'kt.mouse@hotmail.com', 'kurtw85@gmail.com', 'kurvinr@gmail.com', 'kye.eggleton@outlook.com', 'lachlan.harburg@gmail.com', 'lachlanhh1745@gmail.com', 'laine.johnson26@gmail.com', 'laurencetrent@hotmail.com', 'lawriecatterson@hotmail.com', 'lawsonk_22@yahoo.com', 'leroy.lim98@yahoo.com', 'les67@live.com.au', 'Lewisglenister@hotmail.com', 'liambonsall@hotmail.com', 'Liamvalente@y7mail.com', 'lil_miss_rainbow89@hotmail.com', 'ljaeger1998@outlook.com', 'llihou@hotmail.com', 'lmeyers4@icloud.com', 'lnkz.cp@hotmail.com', 'lukeoc777@hotmail.com', 'luketelfordd@gmail.com', 'lynmark1@bigpond.com', 'macsel77@outlook.com', 'magpieridge@outlook.com', 'mahunt20@gmail.com', 'mailtristan@gmail.com', 'marco@ditrentodemolition.com.au', 'mark_20-6-1994@hotmail.com', 'matshaz7@bigpond.com', 'matt_hassett@hotmail.com', 'matt.roblockster@gmail.com', 'matthew.croese@hotmail.com', 'matthewmikejames@gmail.com', 'Matthughes4489@gmail.com', 'mattwgilroy@yahoo.com.au', 'maxgawler6@gmail.com', 'maxharis6299@gmail.com', 'mcwillis88@gmail.com', 'meganliang7@gmail.com', 'meghan.peacock1979@gmail.com', 'micgrob@aol.com', 'michael_francis5@hotmail.com', 'michael.1514@hotmail.com', 'michael.h@custombuiltprojects.com', 'Michael.rashleigh2005@gmail.com', 'michael@oneconnectaus.com.au', 'michaelbas24@hotmail.com', 'michaeljamesdev@icloud.com', 'michlaird@gmail.com', 'Micksdiscovery@gmail.com', 'mike19482@hotmail.com', 'mikeevillamor@icloud.com', 'mikew2340@gmail.com', 'mitchellcittadini@gmail.com', 'MJD.design@live.com', 'mjmonaghan12@bigpond.com', 'mmodrive@gmail.com', 'mobile12vhobart@gmail.com', 'morrisrjr@hotmail.com', 'morrissey089@gmail.com', 'mpitch1@bigpond.com', 'mtreekie@gmail.com', 'muldercrew@hotmail.com', 'my_other_shoe@hotmail.com', 'n77baker@yahoo.com.au', 'nabih.yaacoub@gmail.com', 'nahouli.456@gmail.com', 'nariman.d97@gmail.com', 'nathanaldous@hotmail.com', 'nathannicastri@hotmail.com', 'nathanveness@yahoo.com.au', 'neophitosandreou2001@gmail.com', 'nguyenphuoc204@gmail.com', 'nicholasnicou@hotmail.com', 'nick.colquhoun@outlook.com', 'nickjessop05@icloud.com', 'nickmumford@bigpond.com', 'nicoleclark@outlook.com.au', 'nidz@nidz.net', 'nissm0@hotmail.com', 'nlfmjy@hotmail.com', 'nodules-08-stopper@icloud.com', 'nokialaw1210@gmail.com', 'nomnob@gmail.com', 'nooonga121@hotmail.com', 'nortongl@westnet.com.au', 'nswenson03@gmail.com', 'ola.nicklason@live.com.au', 'oliver_dickson@hotmail.com', 'omarr.sleiman@gmail.com', 'omarz666@hotmail.com', 'oscar.kaye@gmail.com', 'oscar00perry@outlook.com', 'otoo7190@gmail.com', 'ovasales@bigpond.com', 'owenjlea@icloud.com', 'p.walnuts@gmail.com', 'paddy.keane@hotmail.com', 'pamiesan@bigpond.com', 'patrick.lillicrap@gmail.com', 'paul.kinbacher@gmail.com', 'paul.landrigan@bigpond.com', 'Paul231960@gmail.com', 'paulfhuxtable@gmail.com', 'pauljsands@yahoo.com', 'paultancredi@yahoo.com.au', 'perrybsm@gmail.com', 'petarprotic1@gmail.com', 'pete@martingalleries.com.au', 'peter_g_elliss@arnotts.com', 'peter_lupton@bigpond.com', 'peter.r.dean@outlook.com', 'pgrange63@gmail.com', 'pham.hoaa@hotmail.com', 'philhod@bigpond.com', 'pj_bester@bigpond.com', 'pj_captainsflat@yahoo.com.au', 'primeceilings@iprimus.com.au', 'princeautoelectrical@outlook.com', 'prof.yakkle@gmail.com', 'psullivan@live.com.au', 'Quyen.duong303@gmail.com', 'randj12@optusnet.com.au', 'raul@benchmarkautoelectrical.com.au', 'Ravenbrandon2484@gmail.com', 'razorzedge666@hotmail.com', 'rckostrz@gmail.com', 'rebeccabrooks01@outlook.com', 'reubenkershawmchugh@gmail.com', 'rick.tipper64@gmail.com', 'rickylawrence86@gmail.com', 'rikigreene1@bigpond.com', 'rlgclews@bigpond.com', 'rob@cpvehicles.com.au', 'robert.wilkinson@uqconnect.edu.au', 'robert29knowles@outlook.com', 'robertwarner.bt@gmail.com', 'robsonbuzios@hotmail.com', 'roger.wilkinson@internode.on.net', 'ronaldhiggs0@gmail.com', 'rwbadenoch@gmail.com', 'rx7nac@yahoo.com.au', 'Ryan@dawescoelectrical.com.au', 'Ryancatanz@outlook.com.au', 'ryanclark1991@gmail.com', 'rydersurf123@gmail.com', 'sales@carpartsonline.net.au', 'salter.paul@hotmail.com', 'sam_borromei@hotmail.com', 'sam@truinstalls.com.au', 'samuel.jones260603@gmail.com', 'samuel.lutzke@gmail.com', 'sarah_ong96@hotmail.com', 'scleung0918@gmail.com', 'scoie96@hotmail.com', 'scoobyrexx@gmail.com', 'scott.dove80@gmail.com', 'scottheather.sh@gmail.com', 'sduffield2@gmail.com', 'seager@internode.on.net', 'sebastian.deepak84@gmail.com', 'shadplumb@westvic.com.au', 'shaip_t@hotmail.com', 'Shanebmorton@gmail.com', 'shaneengle@hotmail.com', 'sharon@bmhearth.com', 'shaun_p_rees@hotmail.com', 'shaunwingrove@hotmail.com', 'shelaway17@gmail.com', 'shesmy_ute@hotmail.com', 'shilousa@outlook.com', 'simone.louise.h@gmail.com', 'simonkentwell@hotmail.com', 'simonloughhead@hotmail.com', 'sirmikey11@gmail.com', 'sjdeutscher@gmail.com', 'skuffer@bigpond.net.au', 'Slj_is@hotmail.com', 'sonya6462@bigpond.com', 'specialbega@gmail.com', 'starchaser93@gmail.com', 'stefan.vujevic@gmail.com', 'stefan8868@hotmail.com', 'stephen.nunn@bigpond.com', 'stephen.patterson@bigpond.com', 'stevelkneivel@gmail.com', 'steven.hogan99@gmail.com', 'steven@dreamcapital.com.au', 'stotty1995@hotmail.com', 'stuartfarrell@hotmail.com', 'tam_riley@hotmail.com', 'tarranjepsen@gmail.com', 'tattsalli@gmail.com', 'teleptaylor@gmail.com', 'the.simpsonsx4@bigpond.com', 'thomasmckerlie@live.com.au', 'thomasstokes94@hotmail.com', 'tiff.jensz@gmail.com', 'tim.howard87@gmail.com', 'timgraham888@gmail.com', 'timmy351@yahoo.com.au', 'timothynissen2002@gmail.com', 'tjralow@bigpond.com', 'tms1412.ts@gmail.com', 'tmt397@icloud.com', 'tnxk020@gmail.com', 'tombull1985@gmail.com', 'tomfoat@gmail.com', 'tomhouston123@gmail.com', 'tonky074@hotmail.com', 'tony.vera@bigpond.com', 'tonyg@mako.com.au', 'tpearce1175@gmail.com', 'tracybattersby@hotmail.com', 'travisbell888@hotmail.com', 'travisgill308@hotmail.com', 'trenteyles@gmail.com', 'troy@trojanim.com.au', 'TSGcarpentry@outlook.com.au', 'turnersamuel01@gmail.com', 'twoodhouse77@outlook.com', 'tylerandteneale@outlook.com', 'uranda5@bigpond.com', 'vasanthajith@hotmail.com', 'vijayshrinivas@gmail.com', 'vimissvi@hotmail.com', 'vinceallgood@gmail.com', 'vuthanhkinhte@gmail.com', 'walkerandrew014@gmail.com', 'waygoodwin@hotmail.com', 'wayneknight76@gmail.com', 'waynemaclagan62@yahoo.com.au', 'weh84d@gmail.com', 'wellsharry604@gmail.com', 'william.r.clement@gmail.com', 'wilson.riley27@gmail.com', 'wolvesbikeden.sales@gmail.com', 'xlfisher@gmail.com', 'y.liu24@hotmail.com', 'ypasnin@gmail.com', 'zac.brown1047@gmail.com', 'zac.pullen@icloud.com'])
		// ->whereIn('email', [
		// 	'theodore@frankiesautoelectrics.com.au',
		// 	// 'jr@frankiesautoelectrics.com.au',
		// 	// 'rodney@frankiesautoelectrics.com.au'
		// ])
		->where(function($query) {
			$query->where('campaign_status', null);
			$query->orWhere('campaign_status', 'NOT LIKE', '%febsale5;%');
		})
		->orderBy('updated_at', 'DESC')
		->chunk(500, function($customers) use ($campaign, $items) {
			foreach ($customers as $customer) {
				$customer->campaign_status .= 'febsale5;';
				$customer->save();
				// $subject = 'Exclusive for You, ' . $customer->first_name . '! Save Big on EUFY Home Security at Frankies\' Febtastic Deals! 🛡️';
				$subject = 'Febtastic Deals: Grab \'Em Before They\'re Gone, '.$customer->first_name.'! 🚗🌟';
			    Mail::to($customer->email)->bcc([
			    	'theodore@frankiesautoelectrics.com.au',
			    	// 'jr@frankiesautoelectrics.com.au',
			    	// 'rodney@frankiesautoelectrics.com.au'
			    ])->queue(new BulkMail($subject, $campaign, $customer, $items));
			}
		});

		// $customers = Customer::whereIn('email', [
		// 	'theodore@frankiesautoelectrics.com.au', 
		// 	// 'jr@frankiesautoelectrics.com.au', 
		// 	// 'rodney@frankiesautoelectrics.com.au',
		// 	//  'angela@frankiesautoelectrics.com.au', 
		// 	//  'jay@frankiesautoelectrics.com.au', 
		// 	//  'marnell@frankiesautoelectrics.com.au', 
		// 	//  'eric@frankiesautoelectrics.com.au'
		// 	])->get();
		// foreach ($customers as $customer) {
		// 	$subject = 'Exclusive for You, ' . $customer->first_name . '! Save Big on EUFY Home Security at Frankies\' Febtastic Deals! 🛡️';
		// 	// $subject = 'Febtastic Deals: Grab \'Em Before They\'re Gone, '.$customer->first_name.'! 🚗🌟';
		//     Mail::to($customer->email)->queue(new BulkMail($subject, $campaign, $customer, $items));
		// }
		return 1;


		$campaign_id   = 4; 
		$emailTemplate = 'mail.febtasticdealsemail-4';
		$items = [
			'headers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/3b1eac1caa522c53ce98703a234de1eb&01&1708492709.jpg'
				]
			],
			'subheaders' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/350eb1d9b32c73b2e620e2585fcea03f&02&1708492709.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8852cd1',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/58091277233ca52e070797a80399f956&03&1708492709.jpg',
				]
			],
			'featured-products-1' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8851cd1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/215413ae7c67fff79a4cb29204f8187c&04&1708492709.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8853cd1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/85090af75085756cc692a4be21547b14&05&1708492709.jpg',
					],
				]
			],
			'headers-2' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/79ea2861949a4e6b46eedf33bbcd89d8&06&1708492709.jpg',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/product/eufy-e8213c12',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/9c185f6f5d9c8c34ace8b55ef6fa7e36&07&1708492709.jpg',
				],
			],
			'featured-products-2' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8220cw1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/35b4515eb9c41b3a76ccc1fb1cfd3fc4&08&1708492709.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-e8210cw1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/628ea68653e9c6fefb86c4c7246de505&09&1708492709.jpg',
					],
				]
			],
			'banners' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/d23107e8a7e57e493e1a891f9f7e8f71&010&1708492709.jpg',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/product/eufy-t8400cw4',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/f0d9047c2fdfef4d3632f2bfe70f9104&011&1708492709.jpg',
				],
			],
			'featured-products-3' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8410c24',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/94d57c8807267d6d1365e3d20c23471f&012&1708492709.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8416t21',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/ecf9fd237763832b721ebadc6d96563d&013&1708492709.jpg',
					],
				]
			],
			'headers-3' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/210187cae9023f211afb89f316b944e4&014&1708492709.jpg',
				],
			],
			'featured-products-4' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8871tw1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/924004ab0e6e812afec3f674fd23b921&015&1708492709.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8873tw1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/fd9dbf7616b3c0bc029e3afce7ac82d4&016&1708492709.jpg',
					],
				]
			],
			'headers-4' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale#eufy-on-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/da949a4ddb7b2add4b362cc0eeb0db2d&017&1708492709.jpg',
				],
			],
			'featured-products-5' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8425c21',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/49fa0dcdda0d1db51c388b62216c778c&018&1708496320.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t84a1c11',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/989e115e4f55693af8f39f76c63d2e00&019&1708496320.jpg',
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/eufy-t8170cw1',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/3c40b74e557df25fc64c790fa5db6b6c&020&1708496320.jpg',
					],
				]
			],


			'footers' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/e15ac515868ae4d34b3b77f9fb82f52f&022&1708496594.jpg',
				],
			],
		];

		// $customers = Customer::whereIn('email', [
		// 	'theodore@frankiesautoelectrics.com.au',
		// 	// 'angela@frankiesautoelectrics.com.au',
		// 	// 'jay@frankiesautoelectrics.com.au',
		// 	// 'eric@frankiesautoelectrics.com.au',
		// 	// 'marnell@frankiesautoelectrics.com.au',
		// ])->get();

		// return $customers;

		$customers = Customer::where(['unsubscribe' => 0])
							// ->whereNotIn('email', ['079brian@gmail.com', '13brenton@gmail.com', '13corey9@gmail.com', '555combo@gmail.com', 'A_arey3@hotmail.com', 'a.harris003@gmail.com', 'aaron.mcgifford@gmail.com', 'aaron@sivadgroup.com.au', 'aaroncomben88@hotmail.com', 'aaronsheedy386@gmail.com', 'abad.nathaniel@hotmail.com', 'acampt@bigpond.com', 'ACCOUNTS@BARWONHEADSMOTORS.COM.AU', 'accounts@bdprofessionals.com.au', 'accounts@hcautos.com.au', 'ace_skaf@hotmail.com', 'ad.hallie@gmail.com', 'adam.leeds@hotmail.com', 'adamguilfoyle854@gmail.com', 'adammcpherson91@gmail.com', 'admenzies@mac.com', 'Admin@ACCERMaintenance.com.au', 'admin@dcpowersolutions.com.au', 'admin@performanceauto.com.au', 'admin@rcae.com.au', 'admin@torontoautoelectrics.com.au', 'admin@wiredupcustoms.com.au', 'admspk@gmail.com', 'ahwassat@gmail.com', 'aidangvms@gmail.com', 'aidanmb107@gmail.com', 'ajdunstan2017@gmail.com', 'albrooksy@yahoo.com.au', 'alex.afflick@gmail.com', 'allanbeato1124@msn.com', 'Alluring_nemesis@outlook.com', 'alpreet_singh@hotmail.com', 'alyssa.bailey17@outlook.com', 'amahaul@bigpond.com', 'amos@picknowl.com.au', 'andrew.kallio@gmail.com', 'andrew@barrasons.com.au', 'andrew@edgehill.net.au', 'andrewbiffin2020@gmail.com', 'andrewscm98@gmail.com', 'ange.browne78@gmail.com', 'ankeau@gmail.com', 'anmac75@bigpond.com', 'annasims26@gmail.com', 'anthonywolff@hotmail.com', 'antlee99@yahoo.com.au', 'anton.ballza@gmail.com', 'apatten@cva.org.au', 'apexelevatorservices@outlook.com', 'apv.alog@gmail.com', 'ararat4x4@hotmail.com', 'armankam@gmail.com', 'aron@arotechsec.com', 'ashleynunn@live.com.au', 'atchisonangus@gmail.com', 'awlrenovations@outlook.com', 'Badrubberpiggy@gmail.com', 'baiden.skarpona@gmail.com', 'baonitsass@gmail.com', 'bdtimberfloors@hotmail.com', 'beauhanrahan72@gmail.com', 'ben.baker@shadcivil.com.au', 'ben.sambucco@foxmowing.com.au', 'bengee130@gmail.com', 'benhall198695@gmail.com', 'benjamin_thompson1995@hotmail.com', 'benjaminatkinson406@gmail.com', 'benjaminr02@outlook.com', 'benjburke78@gmail.com', 'benpatrickhoran@gmail.com', 'benwyckelsma@gmail.com', 'Betto82@outlook.com.au', 'big_g92@outlook.com', 'bignelljamie@gmail.com', 'bikramshrestha721@gmail.com', 'billywithers1999@gmail.com', 'blueykalbar@gmail.com', 'bobbykohli302@yahoo.com', 'bones_alfaboi@hotmail.com', 'bones@arach.net.au', 'bprichardson1@live.com.au', 'bradjmiller1983@gmail.com', 'Bradl3ywatson02@gmail.com', 'bradp@iinet.net.au', 'brandyarmstrong2@gmail.com', 'brarraman786@gmail.com', 'braydenaudio@gmail.com', 'braydon.d@auswidecorporate.com.au', 'brennywa@gmail.com', 'brentonr13@gmail.com', 'brett.samuel68@bigpond.com', 'brianmai_1@hotmail.com', 'brianseaman@bigpond.com', 'brockbudz420@gmail.com', 'brodyfarrall06@gmail.com', 'bryan.teo@gmail.com', 'bryaninoz@gmail.com', 'brycenicolaou0@gmail.com', 'bswprecision@gmail.com', 'burboandnic@gmail.com', 'burgswelding@outlook.com', 'burke.tj@gmail.com', 'burtonaaron90210@gmail.com', 'buzz1101@gmail.com', 'cah0707@gmail.com', 'Calcal1354@gmail.com', 'calebmoto@gmail.com', 'callam1997@hotmail.com', 'cameronjn1@outlook.com', 'cameronmacfarlane01@gmail.com', 'camj1981@gmail.com', 'carsci@live.com', 'catchkamath@gmail.com', 'cd_lewis@westnet.com.au', 'celvin.shovelar@gmail.com', 'Chambersjai14@gmail.com', 'chandy21@gmail.com', 'charlotte.gulliver06@outlook.com', 'cheryl@carringtonbends.com', 'chewybarker@hotmail.com', 'chloe23599@gmail.com', 'chris_blake7@hotmail.com', 'Chris.axel.Hecht@gmail.com', 'chris.weddall@hotmail.com', 'chrisandrachellane@yahoo.com.au', 'christianrobinson78@bigpond.com', 'christophermarskoch@gmail.com', 'chrisvtss@hotmail.com', 'chunter38@gmail.com', 'cjbarrett06@gmail.com', 'clemo75@bigpond.net.au', 'clintonkenny@hotmail.com', 'cobbmate@gmail.com', 'Coldapplepie@hotmail.com', 'Con.Stasinos@optusnet.com.au', 'connect@calmbuddhi.com.au', 'contact@washgroup.com.au', 'contacteded@gmail.com', 'cooperlewis370@yahoo.com.au', 'cooperneal147@gmail.com', 'Corey.tindall@outlook.com', 'cqae@optusnet.com.au', 'craftechplumbing@gmail.com', 'craig.ntcc@gmail.com', 'craiggormley79@gmail.com', 'craigjohnson-@hotmail.com', 'cruising.customs@gmail.com', 'dac803@live.com.au', 'dale.cameron@universalcranes.com', 'dalecuevas06@yahoo.com', 'damonramma2005@gmail.com', 'dan_mx284@hotmail.com', 'dan.westsec@gmail.com', 'dann.evans19@gmail.com', 'dannyvlass@outlook.com', 'darrenlam2708@gmail.com', 'darrynjb@mac.com', 'david.hall86@bigpond.com', 'david.mirtschin@hotmail.com', 'Daviddoig89@outlook.com', 'davis.warren@hotmail.com', 'davowalcott@gmail.com', 'dbillo@optusnet.com.au', 'dborrowdale@hotmail.com', 'ddrssmith@gmail.com', 'dean.s@teakindustrial.com.au', 'deancook@live.com.au', 'dekota679@optusnet.com.au', 'delg.dlg@bigpond.com', 'deranged1973@gmail.com', 'Dermottlongley@outlook.com', 'dfendr@TPG.COM.AU', 'dhdp1@bigpond.com', 'dickson.sb.wu@gmail.com', 'dimensionhair@gmail.com', 'Divesparks@yahoo.com.au', 'dndcarpentry11@gmail.com', 'don2garcia@gmail.com', 'donna.white4@bigpond.com', 'dorlando_100@hotmail.com', 'dougtucker101@gmail.com', 'dr.john.hornbuckle@gmail.com', 'dt22615@gmail.com', 'duanebutler7@bigpond.com', 'duckteale@yahoo.com.au', 'dukulani@bigpond.com', 'dumont.ma5@gmail.com', 'duncan.eddy3@gmail.com', 'dylansberg@gmail.com', 'eazyvz182@hotmail.com', 'ecoelec@yahoo.com.au', 'ed@daveymotorgroup.com', 'embleton.trent@hotmail.com', 'emily.boag2@gmail.com', 'emmanueleboma@live.com.au', 'enwelsh@outlook.com', 'eric@evautoelectrical.com', 'erin.litherland@icloud.com', 'erin.powell2005@gmail.com', 'essjayb@gmail.com', 'ethantribe@outlook.com.au', 'f.baker98@hotmail.com', 'fabulous1@bigpond.com', 'farooqui.saad@gmail.com', 'feilimclarke@gmail.com', 'Flukes_360@hotmail.com', 'forbes_machine@hotmail.com', 'ford007@live.com.au', 'frasermhewitt@gmail.com', 'g_evans@live.com.au', 'g.n.x@live.com', 'gabiirvine4@gmail.com', 'garthobrien27@gmail.com', 'george.james7@hotmail.com', 'George@vitelectrical.com.au', 'gerhard_777@hotmail.com', 'gerritlaub@gmail.com', 'gilchrist.roy@gmail.com', 'gilmore.aeac@gmail.com', 'gnwattie@bigpond.com', 'goldenrob71@gmail.com', 'gorroickhouse@hotmail.com', 'grant@rkhtestandtag.com.au', 'grantbaird@bigpond.com', 'grapnell@hotmail.com', 'guselibikes@gmail.com', 'guyforsyth@gmail.com', 'hall.ashley@hotmail.com.au', 'hamish.mcmurdie@gmail.com', 'harro.1981@gmail.com', 'haydenmaunder@gmail.com', 'heath0818@gmail.com', 'hicks.michael79@gmail.com', 'hilift01@gmail.com', 'hippossuperwash@bigpond.com', 'hislux@hotmail.com', 'hornunga@live.com.au', 'howardbg1@bigpond.com', 'hrt_racer_1@hotmail.com', 'Htcalder@gmail.com', 'hugh.sherwood17@gmail.com', 'hurst.jay1@gmail.com', 'iansmail@bigpond.net.au', 'imamakbuksh@gmail.com', 'insidelane@gmail.com', 'insufficientdopamine@gmail.com', 'Ironizaac@hotmail.com', 'ismilekimura@gmail.com', 'izabella2013.kw@gmail.com', 'jackkiker0@gmail.com', 'jackkluske@hotmail.com', 'jacksprat_69@hotmail.com', 'jaivebarber1998@gmail.com', 'jake.battelley1@hotmail.com', 'Jake@wiredmobileautoelectrics.com', 'jakejohnson584@hotmail.com', 'james.booth@live.com.au', 'james.scattolin@hotmail.com', 'james@icounsel.com.au', 'jamescraiglawrence@gmail.com', 'jamesjeffcoat88@gmail.com', 'jameslbunt@hotmail.com', 'jamesmatch13@gmail.com', 'janepaul@adam.com.au', 'jarradlutz10@outlook.com', 'jarrodng8@gmail.com', 'jasetomada27@gmail.com', 'jasmoonee@gmail.com', 'jasonmccarthy518@gmail.com', 'Jay@allbids.com.au', 'jayden.marciano@gmail.com', 'jayden.work99@gmail.com', 'jaydoson98@gmail.com', 'jermsy111@gmail.com', 'jessmydog@outlook.com', 'jezstrt@gmail.com', 'jimmy.hampel@hotmail.com', 'jimmy.sculler@gmail.com', 'jimmyread9@gmail.com', 'jjalfred3@yahoo.com', 'jmmangubat13@gmail.com', 'jodi.breen@bigpond.com', 'jodie.marcelm@gmx.com', 'joe@tta.com.au', 'john.bugler2002@gmail.com', 'john.sanders12g@gmail.com', 'john.williamson@outlook.com.au', 'johnny.tran95@gmail.com', 'johnny1985@hotmail.com.au', 'johnnynguyen._@hotmail.com', 'jono.olivier@live.com.au', 'jordan@carroll.net.au', 'josh9932@hotmail.com', 'josieatt@optusnet.com.au', 'jrcdennehy@gmail.com', 'js@hm.com', 'jtmorey77@gmail.com', 'julietan50@gmail.com', 'Justin.finnigan@hotmail.com', 'Justinwtucker@bigpond.com', 'jwilligram@hotmail.com', 'jyhatchman@hotmail.com', 'k_nicolaou@hotmail.com', 'k.backhouse@hotmail.com', 'k.stargard@gmail.com', 'karapandzastefan@gmail.com', 'karen.mccusker@hotmail.com', 'katesheehan95@hotmail.com', 'kaydenjames2007@gmail.com', 'kearo6@hotmail.com', 'keblakre23@gmail.com', 'kendell.saffin5@gmail.com', 'kendonaldson@activ8.net.au', 'kenslatter@live.com.au', 'kial_morgan123@outlook.com', 'kienbuckman@hotmail.com', 'kim.bradd40@gmail.com', 'kimin.mccaffrey@gmail.com', 'kiranpokhreel1997@gmail.com', 'kleeh@hotmail.com', 'kmokhtar@hotmail.com', 'knighter58@outlook.com', 'kodie4@gmail.com', 'kody295@hotmail.com', 'kojo_hhh@hotmail.com', 'krissmaru195@gmail.com', 'kriszids@hotmail.com', 'kronos07@adam.com.au', 'kser.razon@gmail.com', 'kt.mouse@hotmail.com', 'kurtw85@gmail.com', 'kurvinr@gmail.com', 'kye.eggleton@outlook.com', 'lachlan.harburg@gmail.com', 'lachlanhh1745@gmail.com', 'laine.johnson26@gmail.com', 'laurencetrent@hotmail.com', 'lawriecatterson@hotmail.com', 'lawsonk_22@yahoo.com', 'leroy.lim98@yahoo.com', 'les67@live.com.au', 'Lewisglenister@hotmail.com', 'liambonsall@hotmail.com', 'Liamvalente@y7mail.com', 'lil_miss_rainbow89@hotmail.com', 'ljaeger1998@outlook.com', 'llihou@hotmail.com', 'lmeyers4@icloud.com', 'lnkz.cp@hotmail.com', 'lukeoc777@hotmail.com', 'luketelfordd@gmail.com', 'lynmark1@bigpond.com', 'macsel77@outlook.com', 'magpieridge@outlook.com', 'mahunt20@gmail.com', 'mailtristan@gmail.com', 'marco@ditrentodemolition.com.au', 'mark_20-6-1994@hotmail.com', 'matshaz7@bigpond.com', 'matt_hassett@hotmail.com', 'matt.roblockster@gmail.com', 'matthew.croese@hotmail.com', 'matthewmikejames@gmail.com', 'Matthughes4489@gmail.com', 'mattwgilroy@yahoo.com.au', 'maxgawler6@gmail.com', 'maxharis6299@gmail.com', 'mcwillis88@gmail.com', 'meganliang7@gmail.com', 'meghan.peacock1979@gmail.com', 'micgrob@aol.com', 'michael_francis5@hotmail.com', 'michael.1514@hotmail.com', 'michael.h@custombuiltprojects.com', 'Michael.rashleigh2005@gmail.com', 'michael@oneconnectaus.com.au', 'michaelbas24@hotmail.com', 'michaeljamesdev@icloud.com', 'michlaird@gmail.com', 'Micksdiscovery@gmail.com', 'mike19482@hotmail.com', 'mikeevillamor@icloud.com', 'mikew2340@gmail.com', 'mitchellcittadini@gmail.com', 'MJD.design@live.com', 'mjmonaghan12@bigpond.com', 'mmodrive@gmail.com', 'mobile12vhobart@gmail.com', 'morrisrjr@hotmail.com', 'morrissey089@gmail.com', 'mpitch1@bigpond.com', 'mtreekie@gmail.com', 'muldercrew@hotmail.com', 'my_other_shoe@hotmail.com', 'n77baker@yahoo.com.au', 'nabih.yaacoub@gmail.com', 'nahouli.456@gmail.com', 'nariman.d97@gmail.com', 'nathanaldous@hotmail.com', 'nathannicastri@hotmail.com', 'nathanveness@yahoo.com.au', 'neophitosandreou2001@gmail.com', 'nguyenphuoc204@gmail.com', 'nicholasnicou@hotmail.com', 'nick.colquhoun@outlook.com', 'nickjessop05@icloud.com', 'nickmumford@bigpond.com', 'nicoleclark@outlook.com.au', 'nidz@nidz.net', 'nissm0@hotmail.com', 'nlfmjy@hotmail.com', 'nodules-08-stopper@icloud.com', 'nokialaw1210@gmail.com', 'nomnob@gmail.com', 'nooonga121@hotmail.com', 'nortongl@westnet.com.au', 'nswenson03@gmail.com', 'ola.nicklason@live.com.au', 'oliver_dickson@hotmail.com', 'omarr.sleiman@gmail.com', 'omarz666@hotmail.com', 'oscar.kaye@gmail.com', 'oscar00perry@outlook.com', 'otoo7190@gmail.com', 'ovasales@bigpond.com', 'owenjlea@icloud.com', 'p.walnuts@gmail.com', 'paddy.keane@hotmail.com', 'pamiesan@bigpond.com', 'patrick.lillicrap@gmail.com', 'paul.kinbacher@gmail.com', 'paul.landrigan@bigpond.com', 'Paul231960@gmail.com', 'paulfhuxtable@gmail.com', 'pauljsands@yahoo.com', 'paultancredi@yahoo.com.au', 'perrybsm@gmail.com', 'petarprotic1@gmail.com', 'pete@martingalleries.com.au', 'peter_g_elliss@arnotts.com', 'peter_lupton@bigpond.com', 'peter.r.dean@outlook.com', 'pgrange63@gmail.com', 'pham.hoaa@hotmail.com', 'philhod@bigpond.com', 'pj_bester@bigpond.com', 'pj_captainsflat@yahoo.com.au', 'primeceilings@iprimus.com.au', 'princeautoelectrical@outlook.com', 'prof.yakkle@gmail.com', 'psullivan@live.com.au', 'Quyen.duong303@gmail.com', 'randj12@optusnet.com.au', 'raul@benchmarkautoelectrical.com.au', 'Ravenbrandon2484@gmail.com', 'razorzedge666@hotmail.com', 'rckostrz@gmail.com', 'rebeccabrooks01@outlook.com', 'reubenkershawmchugh@gmail.com', 'rick.tipper64@gmail.com', 'rickylawrence86@gmail.com', 'rikigreene1@bigpond.com', 'rlgclews@bigpond.com', 'rob@cpvehicles.com.au', 'robert.wilkinson@uqconnect.edu.au', 'robert29knowles@outlook.com', 'robertwarner.bt@gmail.com', 'robsonbuzios@hotmail.com', 'roger.wilkinson@internode.on.net', 'ronaldhiggs0@gmail.com', 'rwbadenoch@gmail.com', 'rx7nac@yahoo.com.au', 'Ryan@dawescoelectrical.com.au', 'Ryancatanz@outlook.com.au', 'ryanclark1991@gmail.com', 'rydersurf123@gmail.com', 'sales@carpartsonline.net.au', 'salter.paul@hotmail.com', 'sam_borromei@hotmail.com', 'sam@truinstalls.com.au', 'samuel.jones260603@gmail.com', 'samuel.lutzke@gmail.com', 'sarah_ong96@hotmail.com', 'scleung0918@gmail.com', 'scoie96@hotmail.com', 'scoobyrexx@gmail.com', 'scott.dove80@gmail.com', 'scottheather.sh@gmail.com', 'sduffield2@gmail.com', 'seager@internode.on.net', 'sebastian.deepak84@gmail.com', 'shadplumb@westvic.com.au', 'shaip_t@hotmail.com', 'Shanebmorton@gmail.com', 'shaneengle@hotmail.com', 'sharon@bmhearth.com', 'shaun_p_rees@hotmail.com', 'shaunwingrove@hotmail.com', 'shelaway17@gmail.com', 'shesmy_ute@hotmail.com', 'shilousa@outlook.com', 'simone.louise.h@gmail.com', 'simonkentwell@hotmail.com', 'simonloughhead@hotmail.com', 'sirmikey11@gmail.com', 'sjdeutscher@gmail.com', 'skuffer@bigpond.net.au', 'Slj_is@hotmail.com', 'sonya6462@bigpond.com', 'specialbega@gmail.com', 'starchaser93@gmail.com', 'stefan.vujevic@gmail.com', 'stefan8868@hotmail.com', 'stephen.nunn@bigpond.com', 'stephen.patterson@bigpond.com', 'stevelkneivel@gmail.com', 'steven.hogan99@gmail.com', 'steven@dreamcapital.com.au', 'stotty1995@hotmail.com', 'stuartfarrell@hotmail.com', 'tam_riley@hotmail.com', 'tarranjepsen@gmail.com', 'tattsalli@gmail.com', 'teleptaylor@gmail.com', 'the.simpsonsx4@bigpond.com', 'thomasmckerlie@live.com.au', 'thomasstokes94@hotmail.com', 'tiff.jensz@gmail.com', 'tim.howard87@gmail.com', 'timgraham888@gmail.com', 'timmy351@yahoo.com.au', 'timothynissen2002@gmail.com', 'tjralow@bigpond.com', 'tms1412.ts@gmail.com', 'tmt397@icloud.com', 'tnxk020@gmail.com', 'tombull1985@gmail.com', 'tomfoat@gmail.com', 'tomhouston123@gmail.com', 'tonky074@hotmail.com', 'tony.vera@bigpond.com', 'tonyg@mako.com.au', 'tpearce1175@gmail.com', 'tracybattersby@hotmail.com', 'travisbell888@hotmail.com', 'travisgill308@hotmail.com', 'trenteyles@gmail.com', 'troy@trojanim.com.au', 'TSGcarpentry@outlook.com.au', 'turnersamuel01@gmail.com', 'twoodhouse77@outlook.com', 'tylerandteneale@outlook.com', 'uranda5@bigpond.com', 'vasanthajith@hotmail.com', 'vijayshrinivas@gmail.com', 'vimissvi@hotmail.com', 'vinceallgood@gmail.com', 'vuthanhkinhte@gmail.com', 'walkerandrew014@gmail.com', 'waygoodwin@hotmail.com', 'wayneknight76@gmail.com', 'waynemaclagan62@yahoo.com.au', 'weh84d@gmail.com', 'wellsharry604@gmail.com', 'william.r.clement@gmail.com', 'wilson.riley27@gmail.com', 'wolvesbikeden.sales@gmail.com', 'xlfisher@gmail.com', 'y.liu24@hotmail.com', 'ypasnin@gmail.com', 'zac.brown1047@gmail.com', 'zac.pullen@icloud.com'])
							->where(function($query) {
								$query->where('campaign_status', null);
								$query->orWhere('campaign_status', 'NOT LIKE', '%febsale4;%');
							})
							->get();

		foreach($customers as $customer) {
			// return view($emailTemplate, ['items' => $items, 'customer' => $customer, 'campaign_id' => $campaign_id]);

			Mail::send($emailTemplate, ['items' => $items, 'customer' => $customer, 'campaign_id' => $campaign_id], function($message) use ($customer) {
				$message->to($customer['email']);
				// $message->bcc(['theodore@frankiesautoelectrics.com.au']);
				// $message->subject('Hey ' . $customer->first_name . '! 🎉 Score Big with Frankies Auto Electrics Febtastic Deals! 🚗💥');
				$message->subject('Exclusive for You, ' . $customer->first_name . '! Save Big on EUFY Home Security at Frankies\' Febtastic Deals! 🛡️');
			});

			$customer->campaign_status .= 'febsale4;';
			$customer->save();
		}
		return 1;

    	// $emailTemplate = 'mail.febtasticdealsemail';
		// $items = [
		// 	'headers' => [
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/46b99c53456a5ea25422f862299793ec&01&1707789196.jpg'
		// 		]
		// 	],

		// 	'subheaders' => [
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/product/fusion-en-sw102-10-subwoofer',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/8b6d61440a01c3887ad0d9995283de3e&02&1707789196.jpg'
		// 		]
		// 	],

		// 	'featured-products' => [
		// 		[
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/fusion-en-sw122-12-subwoofer',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/ede205abef6102bfb9e097eb1c3ca998&03%20(1)&1707791347.jpg',
		// 			],
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/fusion-pf-sw100d4-10-dual-4-ohm-voice-coil-subwoofer',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/2de2b0facf5711b1d8a5692d11022ffb&04&1707789196.jpg',
		// 			],
		// 			// [
		// 			// 	'url' => 'https://frankiesautoelectrics.com.au/pioneer-dmh-a245bt-6-2-digital-media-av-receiver/',
		// 			// 	'image' => 'https://ultimatehosting.blackedgedigital.com/images/4690e71c0a1412f0aacb6c2ad3369996&05&1707696145.jpg',
		// 			// ],
		// 		]
		// 	],

		// 	'middleheaders' => [
		// 		// [
		// 		// 	'url' => 'https://frankiesautoelectrics.com.au/xs-lighting-xs-dlb20-20-led-light-bar-combo-beam/',
		// 		// 	'image' => 'https://ultimatehosting.blackedgedigital.com/images/8e84c1bc2fe50f9498c7585b39b4325e&06&1707696145.jpg',
		// 		// ],
		// 	],

		// 	'banners' => [
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/product/vibe-cvenv6l-v4-300w-6-compact-passive-bass-subwoofer-enclosure',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/a5932dad68e3dda9f2b68ce3f37d569c&05&1707789196.jpg',
		// 		],
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/product/vibe-cvenv6s-v4-300w-6-compact-passive-bass-subwoofer-enclosure',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/11ab4d7737316381e99160a650a544a7&06&1707789196.jpg',
		// 		],
		// 	],


		// 	'best-selling-products' => [
		// 		[
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/soundstream-l4-400n-lil-wonder-4-series-4-channel-amplifier',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/edb3a70c1e45dfb0b3a824528f50e4a6&07&1707789196.jpg',
		// 			],
		// 			// [
		// 			// 	'url' => 'https://frankiesautoelectrics.com.au/jbl-stage3-9637-6-x-9-3-way-triaxial-speakers-75w-rms-3-ohm-includes-grilles/',
		// 			// 	'image' => 'https://ultimatehosting.blackedgedigital.com/images/18fb2c03793fde15d9e1afd0c7bcb000&10&1707696145.jpg',
		// 			// ],
		// 			// [
		// 			// 	'url' => 'https://frankiesautoelectrics.com.au/jbl-stage3-9637-6-x-9-3-way-triaxial-speakers-75w-rms-3-ohm-includes-grilles/',
		// 			// 	'image' => 'https://ultimatehosting.blackedgedigital.com/images/4d49c803a89b7016122d29b2aac4c2c9&11&1707696145.jpg',
		// 			// ],
		// 		]
		// 	],

		// 	'deals-you-cant-miss' => [
		// 		[
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/pioneer-gmd8701',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/c6c2cf4e408c3bb27f5f0723f749c7d7&08&1707789196.jpg',
		// 			],
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/hertz-hmp-1d-300w-marine-powersport-ultra-compact-monoblock-amplifier',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/39110b6da5f8362003b8e2e17d65b586&09&1707789196.jpg',
		// 			],
		// 			[
		// 				'url' => 'https://frankiesautoelectrics.com.au/product/kenwood-xh401-4-x-series-800w-4-channel-class-d-power-amplifier',
		// 				'image' => 'https://ultimatehosting.blackedgedigital.com/images/30d3270edbc5c12796e9b71aa07161e9&010&1707789196.jpg',
		// 			],
		// 		]
		// 	],
 	
		// 	'finalheaders' => [
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/febtastic-sale',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/264a584774c8f741977a1907d5734cb3&011&1707789196.jpg',
		// 		],
		// 	],


		// 	'footers' => [
		// 		[
		// 			'url' => 'https://frankiesautoelectrics.com.au/',
		// 			'image' => 'https://ultimatehosting.blackedgedigital.com/images/68cf726ea3dc81d5e9c6f2b08e1f718a&012&1707789196.jpg',
		// 		],
		// 	],
		// ];

		// return view($emailTemplate, ['items' => $items]);

		foreach($customers as $customer) {
			Mail::send($emailTemplate, ['items' => $items], function($message) use ($customer) {
				$message->to($customer['email']);
				$message->bcc([
					'theodore@frankiesautoelectrics.com.au',
					'rodney@frankiesautoelectrics.com.au',
					'jr@frankiesautoelectrics.com.au', 'outlook_72ecff7b90d49e9d@outlook.com.au', 'jrfrankies@yahoo.com', 'jrfaetest@hotmail.com']);
				// $message->cc(['theodore@frankiesautoelectrics.com.au']);
				$message->subject('Hey ' . $customer['name'] . '! 🎉 Score Big with Frankies Auto Electrics Febtastic Deals! 🚗💥');
			});
		}
		return 1;
		$customers = Customer::where(['id' => 29119])->get();
		// return $customers;

		foreach ($customers as $customer) {
			Mail::send($emailTemplate, ['items' => $items, 'customer' => $customer], function($message) use($customer){
				$message->to($customer->email);
				$message->cc(['theodore@frankiesautoelectrics.com.au']);
				$message->subject('Hey, ' . ucwords($customer->first_name) . '! 🎁 Boxing Week Clearance Sale Now Live, Up to 80% off!');
			});

			if (Mail::failures()) {
				logger(Mail::failures());
			} else {
				$customer->status = '0';
				$customer->save();
			}
		}
		return 1;

    	Customer::where(['status' => 1, 'unsubscribe' => 0])->chunk(50, function($customers) {
			$recipients = [];
			$icons      = ['🎁'];
    		foreach($customers as $customer) {
				$recipients[$customer->id] = $customer;
	    	}
			$sendEmail = (new \App\Jobs\SendQueueEmail($recipients))->delay(now()->addSeconds(5)); 
			dispatch($sendEmail);
    	});
    	
    	return 1;



		$endpoint_url = 'https://api.bigcommerce.com/stores/d97c0/v3/customers?limit=250';
		$curl_options = [				
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json', 
				'Accept: application/json', 
				'X-Auth-Client: oe55s8n39hkuxqeob6gtvvrpp8fxl27',
				'X-Auth-Token: er38fvb9ltbyd65jffe3zoh2ewm65jz',
			],
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => 1,
		];

		$curl = curl_init($endpoint_url);
		curl_setopt_array($curl, $curl_options);

		$result = curl_exec($curl);
		if ($curl_error = curl_error($curl)) {
			throw new \Exception($curl_error);
		} else {
			$json_decode = json_decode($result, true);
			// $result = json_decode($result, true);//['data'];
			$meta = $json_decode['meta'];
		}
		curl_close($curl);

		// return $meta;

		for($i = 1; $i <= $meta['pagination']['total_pages']; $i++) {
			$endpoint_url = 'https://api.bigcommerce.com/stores/d97c0/v3/customers?limit=250&page='.$i;

			$curl_options = [				
				CURLOPT_HTTPHEADER => [
					'Content-Type: application/json', 
					'Accept: application/json', 
					'X-Auth-Client: oe55s8n39hkuxqeob6gtvvrpp8fxl27',
					'X-Auth-Token: er38fvb9ltbyd65jffe3zoh2ewm65jz',
				],
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_RETURNTRANSFER => 1,
			];

			$curl = curl_init($endpoint_url);
			curl_setopt_array($curl, $curl_options);

			$result = curl_exec($curl);
			if ($curl_error = curl_error($curl)) {
				throw new \Exception($curl_error);
			} else {
				$json_decode = json_decode($result, true);
				$result = $json_decode['data'];
				// $meta = $json_decode['meta'];
			}
			curl_close($curl);
			// return $json_decode;
			foreach($result as $res) {
				$primary = ['api_customer_id' => $res['id']];
				$payload = [
					'company'                 => $res['company'],
					'email'                   => $res['email'],
					'first_name'              => $res['first_name'],
					'last_name'               => $res['last_name'],
					'notes'                   => $res['notes'],
					'phone'                   => $res['phone'],
					'registration_ip_address' => $res['registration_ip_address'],
					'created_at'              => $res['date_created'],
					'updated_at'              => $res['date_modified'],
				];
				Customer::updateOrCreate($primary, $payload);

			}
		}
		return 1;
    }

}
