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

use App\Mail\CampaignMail;
use App\Jobs\SendCampaignEmail;
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

		public function mythicalmorning(Request $request) {
			$items = [
			'headers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/mothers-day-blowout-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_01.jpg'
				],
			],
			'subheaders-1' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/product/pioneer-dmha245bt',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_02.jpg',
				],
			],
			'featured-products-1' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-dmx7522s',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_03.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-dmhz5350bt',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_04.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/kenwood-dmx7522dabs',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_05.jpg'
					],
				],
			],
			'subheaders-2' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/mothers-day-blowout-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_06.jpg',
				],
			],
			'featured-products-2' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/us-audio-ussp10pa',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_07.jpg',
					],
				], [
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/pioneer-tswx010a',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_08.jpg'
					],
				],
			],
			'subheaders-3' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/mothers-day-blowout-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_09.jpg'
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/product/scosche-btfmpd2',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_10.jpg'
				],
			],
			'featured-products-3' => [
				[
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/aerpro-apbt210',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_11.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/scosche-btfmpdsr-sp-bt-freq-wireless-handsfree-car-kit',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_12.jpg'
					],
					[
						'url'   => 'https://frankiesautoelectrics.com.au/product/aerpro-adm1501',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_13.jpg'
					],
				],
			],
			'footers' => [
				[
					'url'   => 'https://frankiesautoelectrics.com.au/mothers-day-blowout-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_14.jpg',
				],
				[
					'url'   => 'https://frankiesautoelectrics.com.au/mothers-day-blowout-sale',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/May%20Campaign%201/01_15.jpg',
				],
			],
		];

		$campaign = Campaign::orderBy('created_at', 'DESC')->first();

		Customer::where(['unsubscribe' => 0])
		// ->whereNotIn('email', ['079brian@gmail.com', '13brenton@gmail.com', '13corey9@gmail.com', '555combo@gmail.com', 'A_arey3@hotmail.com', 'a.harris003@gmail.com', 'aaron.mcgifford@gmail.com', 'aaron@sivadgroup.com.au', 'aaroncomben88@hotmail.com', 'aaronsheedy386@gmail.com', 'abad.nathaniel@hotmail.com', 'acampt@bigpond.com', 'ACCOUNTS@BARWONHEADSMOTORS.COM.AU', 'accounts@bdprofessionals.com.au', 'accounts@hcautos.com.au', 'ace_skaf@hotmail.com', 'ad.hallie@gmail.com', 'adam.leeds@hotmail.com', 'adamguilfoyle854@gmail.com', 'adammcpherson91@gmail.com', 'admenzies@mac.com', 'Admin@ACCERMaintenance.com.au', 'admin@dcpowersolutions.com.au', 'admin@performanceauto.com.au', 'admin@rcae.com.au', 'admin@torontoautoelectrics.com.au', 'admin@wiredupcustoms.com.au', 'admspk@gmail.com', 'ahwassat@gmail.com', 'aidangvms@gmail.com', 'aidanmb107@gmail.com', 'ajdunstan2017@gmail.com', 'albrooksy@yahoo.com.au', 'alex.afflick@gmail.com', 'allanbeato1124@msn.com', 'Alluring_nemesis@outlook.com', 'alpreet_singh@hotmail.com', 'alyssa.bailey17@outlook.com', 'amahaul@bigpond.com', 'amos@picknowl.com.au', 'andrew.kallio@gmail.com', 'andrew@barrasons.com.au', 'andrew@edgehill.net.au', 'andrewbiffin2020@gmail.com', 'andrewscm98@gmail.com', 'ange.browne78@gmail.com', 'ankeau@gmail.com', 'anmac75@bigpond.com', 'annasims26@gmail.com', 'anthonywolff@hotmail.com', 'antlee99@yahoo.com.au', 'anton.ballza@gmail.com', 'apatten@cva.org.au', 'apexelevatorservices@outlook.com', 'apv.alog@gmail.com', 'ararat4x4@hotmail.com', 'armankam@gmail.com', 'aron@arotechsec.com', 'ashleynunn@live.com.au', 'atchisonangus@gmail.com', 'awlrenovations@outlook.com', 'Badrubberpiggy@gmail.com', 'baiden.skarpona@gmail.com', 'baonitsass@gmail.com', 'bdtimberfloors@hotmail.com', 'beauhanrahan72@gmail.com', 'ben.baker@shadcivil.com.au', 'ben.sambucco@foxmowing.com.au', 'bengee130@gmail.com', 'benhall198695@gmail.com', 'benjamin_thompson1995@hotmail.com', 'benjaminatkinson406@gmail.com', 'benjaminr02@outlook.com', 'benjburke78@gmail.com', 'benpatrickhoran@gmail.com', 'benwyckelsma@gmail.com', 'Betto82@outlook.com.au', 'big_g92@outlook.com', 'bignelljamie@gmail.com', 'bikramshrestha721@gmail.com', 'billywithers1999@gmail.com', 'blueykalbar@gmail.com', 'bobbykohli302@yahoo.com', 'bones_alfaboi@hotmail.com', 'bones@arach.net.au', 'bprichardson1@live.com.au', 'bradjmiller1983@gmail.com', 'Bradl3ywatson02@gmail.com', 'bradp@iinet.net.au', 'brandyarmstrong2@gmail.com', 'brarraman786@gmail.com', 'braydenaudio@gmail.com', 'braydon.d@auswidecorporate.com.au', 'brennywa@gmail.com', 'brentonr13@gmail.com', 'brett.samuel68@bigpond.com', 'brianmai_1@hotmail.com', 'brianseaman@bigpond.com', 'brockbudz420@gmail.com', 'brodyfarrall06@gmail.com', 'bryan.teo@gmail.com', 'bryaninoz@gmail.com', 'brycenicolaou0@gmail.com', 'bswprecision@gmail.com', 'burboandnic@gmail.com', 'burgswelding@outlook.com', 'burke.tj@gmail.com', 'burtonaaron90210@gmail.com', 'buzz1101@gmail.com', 'cah0707@gmail.com', 'Calcal1354@gmail.com', 'calebmoto@gmail.com', 'callam1997@hotmail.com', 'cameronjn1@outlook.com', 'cameronmacfarlane01@gmail.com', 'camj1981@gmail.com', 'carsci@live.com', 'catchkamath@gmail.com', 'cd_lewis@westnet.com.au', 'celvin.shovelar@gmail.com', 'Chambersjai14@gmail.com', 'chandy21@gmail.com', 'charlotte.gulliver06@outlook.com', 'cheryl@carringtonbends.com', 'chewybarker@hotmail.com', 'chloe23599@gmail.com', 'chris_blake7@hotmail.com', 'Chris.axel.Hecht@gmail.com', 'chris.weddall@hotmail.com', 'chrisandrachellane@yahoo.com.au', 'christianrobinson78@bigpond.com', 'christophermarskoch@gmail.com', 'chrisvtss@hotmail.com', 'chunter38@gmail.com', 'cjbarrett06@gmail.com', 'clemo75@bigpond.net.au', 'clintonkenny@hotmail.com', 'cobbmate@gmail.com', 'Coldapplepie@hotmail.com', 'Con.Stasinos@optusnet.com.au', 'connect@calmbuddhi.com.au', 'contact@washgroup.com.au', 'contacteded@gmail.com', 'cooperlewis370@yahoo.com.au', 'cooperneal147@gmail.com', 'Corey.tindall@outlook.com', 'cqae@optusnet.com.au', 'craftechplumbing@gmail.com', 'craig.ntcc@gmail.com', 'craiggormley79@gmail.com', 'craigjohnson-@hotmail.com', 'cruising.customs@gmail.com', 'dac803@live.com.au', 'dale.cameron@universalcranes.com', 'dalecuevas06@yahoo.com', 'damonramma2005@gmail.com', 'dan_mx284@hotmail.com', 'dan.westsec@gmail.com', 'dann.evans19@gmail.com', 'dannyvlass@outlook.com', 'darrenlam2708@gmail.com', 'darrynjb@mac.com', 'david.hall86@bigpond.com', 'david.mirtschin@hotmail.com', 'Daviddoig89@outlook.com', 'davis.warren@hotmail.com', 'davowalcott@gmail.com', 'dbillo@optusnet.com.au', 'dborrowdale@hotmail.com', 'ddrssmith@gmail.com', 'dean.s@teakindustrial.com.au', 'deancook@live.com.au', 'dekota679@optusnet.com.au', 'delg.dlg@bigpond.com', 'deranged1973@gmail.com', 'Dermottlongley@outlook.com', 'dfendr@TPG.COM.AU', 'dhdp1@bigpond.com', 'dickson.sb.wu@gmail.com', 'dimensionhair@gmail.com', 'Divesparks@yahoo.com.au', 'dndcarpentry11@gmail.com', 'don2garcia@gmail.com', 'donna.white4@bigpond.com', 'dorlando_100@hotmail.com', 'dougtucker101@gmail.com', 'dr.john.hornbuckle@gmail.com', 'dt22615@gmail.com', 'duanebutler7@bigpond.com', 'duckteale@yahoo.com.au', 'dukulani@bigpond.com', 'dumont.ma5@gmail.com', 'duncan.eddy3@gmail.com', 'dylansberg@gmail.com', 'eazyvz182@hotmail.com', 'ecoelec@yahoo.com.au', 'ed@daveymotorgroup.com', 'embleton.trent@hotmail.com', 'emily.boag2@gmail.com', 'emmanueleboma@live.com.au', 'enwelsh@outlook.com', 'eric@evautoelectrical.com', 'erin.litherland@icloud.com', 'erin.powell2005@gmail.com', 'essjayb@gmail.com', 'ethantribe@outlook.com.au', 'f.baker98@hotmail.com', 'fabulous1@bigpond.com', 'farooqui.saad@gmail.com', 'feilimclarke@gmail.com', 'Flukes_360@hotmail.com', 'forbes_machine@hotmail.com', 'ford007@live.com.au', 'frasermhewitt@gmail.com', 'g_evans@live.com.au', 'g.n.x@live.com', 'gabiirvine4@gmail.com', 'garthobrien27@gmail.com', 'george.james7@hotmail.com', 'George@vitelectrical.com.au', 'gerhard_777@hotmail.com', 'gerritlaub@gmail.com', 'gilchrist.roy@gmail.com', 'gilmore.aeac@gmail.com', 'gnwattie@bigpond.com', 'goldenrob71@gmail.com', 'gorroickhouse@hotmail.com', 'grant@rkhtestandtag.com.au', 'grantbaird@bigpond.com', 'grapnell@hotmail.com', 'guselibikes@gmail.com', 'guyforsyth@gmail.com', 'hall.ashley@hotmail.com.au', 'hamish.mcmurdie@gmail.com', 'harro.1981@gmail.com', 'haydenmaunder@gmail.com', 'heath0818@gmail.com', 'hicks.michael79@gmail.com', 'hilift01@gmail.com', 'hippossuperwash@bigpond.com', 'hislux@hotmail.com', 'hornunga@live.com.au', 'howardbg1@bigpond.com', 'hrt_racer_1@hotmail.com', 'Htcalder@gmail.com', 'hugh.sherwood17@gmail.com', 'hurst.jay1@gmail.com', 'iansmail@bigpond.net.au', 'imamakbuksh@gmail.com', 'insidelane@gmail.com', 'insufficientdopamine@gmail.com', 'Ironizaac@hotmail.com', 'ismilekimura@gmail.com', 'izabella2013.kw@gmail.com', 'jackkiker0@gmail.com', 'jackkluske@hotmail.com', 'jacksprat_69@hotmail.com', 'jaivebarber1998@gmail.com', 'jake.battelley1@hotmail.com', 'Jake@wiredmobileautoelectrics.com', 'jakejohnson584@hotmail.com', 'james.booth@live.com.au', 'james.scattolin@hotmail.com', 'james@icounsel.com.au', 'jamescraiglawrence@gmail.com', 'jamesjeffcoat88@gmail.com', 'jameslbunt@hotmail.com', 'jamesmatch13@gmail.com', 'janepaul@adam.com.au', 'jarradlutz10@outlook.com', 'jarrodng8@gmail.com', 'jasetomada27@gmail.com', 'jasmoonee@gmail.com', 'jasonmccarthy518@gmail.com', 'Jay@allbids.com.au', 'jayden.marciano@gmail.com', 'jayden.work99@gmail.com', 'jaydoson98@gmail.com', 'jermsy111@gmail.com', 'jessmydog@outlook.com', 'jezstrt@gmail.com', 'jimmy.hampel@hotmail.com', 'jimmy.sculler@gmail.com', 'jimmyread9@gmail.com', 'jjalfred3@yahoo.com', 'jmmangubat13@gmail.com', 'jodi.breen@bigpond.com', 'jodie.marcelm@gmx.com', 'joe@tta.com.au', 'john.bugler2002@gmail.com', 'john.sanders12g@gmail.com', 'john.williamson@outlook.com.au', 'johnny.tran95@gmail.com', 'johnny1985@hotmail.com.au', 'johnnynguyen._@hotmail.com', 'jono.olivier@live.com.au', 'jordan@carroll.net.au', 'josh9932@hotmail.com', 'josieatt@optusnet.com.au', 'jrcdennehy@gmail.com', 'js@hm.com', 'jtmorey77@gmail.com', 'julietan50@gmail.com', 'Justin.finnigan@hotmail.com', 'Justinwtucker@bigpond.com', 'jwilligram@hotmail.com', 'jyhatchman@hotmail.com', 'k_nicolaou@hotmail.com', 'k.backhouse@hotmail.com', 'k.stargard@gmail.com', 'karapandzastefan@gmail.com', 'karen.mccusker@hotmail.com', 'katesheehan95@hotmail.com', 'kaydenjames2007@gmail.com', 'kearo6@hotmail.com', 'keblakre23@gmail.com', 'kendell.saffin5@gmail.com', 'kendonaldson@activ8.net.au', 'kenslatter@live.com.au', 'kial_morgan123@outlook.com', 'kienbuckman@hotmail.com', 'kim.bradd40@gmail.com', 'kimin.mccaffrey@gmail.com', 'kiranpokhreel1997@gmail.com', 'kleeh@hotmail.com', 'kmokhtar@hotmail.com', 'knighter58@outlook.com', 'kodie4@gmail.com', 'kody295@hotmail.com', 'kojo_hhh@hotmail.com', 'krissmaru195@gmail.com', 'kriszids@hotmail.com', 'kronos07@adam.com.au', 'kser.razon@gmail.com', 'kt.mouse@hotmail.com', 'kurtw85@gmail.com', 'kurvinr@gmail.com', 'kye.eggleton@outlook.com', 'lachlan.harburg@gmail.com', 'lachlanhh1745@gmail.com', 'laine.johnson26@gmail.com', 'laurencetrent@hotmail.com', 'lawriecatterson@hotmail.com', 'lawsonk_22@yahoo.com', 'leroy.lim98@yahoo.com', 'les67@live.com.au', 'Lewisglenister@hotmail.com', 'liambonsall@hotmail.com', 'Liamvalente@y7mail.com', 'lil_miss_rainbow89@hotmail.com', 'ljaeger1998@outlook.com', 'llihou@hotmail.com', 'lmeyers4@icloud.com', 'lnkz.cp@hotmail.com', 'lukeoc777@hotmail.com', 'luketelfordd@gmail.com', 'lynmark1@bigpond.com', 'macsel77@outlook.com', 'magpieridge@outlook.com', 'mahunt20@gmail.com', 'mailtristan@gmail.com', 'marco@ditrentodemolition.com.au', 'mark_20-6-1994@hotmail.com', 'matshaz7@bigpond.com', 'matt_hassett@hotmail.com', 'matt.roblockster@gmail.com', 'matthew.croese@hotmail.com', 'matthewmikejames@gmail.com', 'Matthughes4489@gmail.com', 'mattwgilroy@yahoo.com.au', 'maxgawler6@gmail.com', 'maxharis6299@gmail.com', 'mcwillis88@gmail.com', 'meganliang7@gmail.com', 'meghan.peacock1979@gmail.com', 'micgrob@aol.com', 'michael_francis5@hotmail.com', 'michael.1514@hotmail.com', 'michael.h@custombuiltprojects.com', 'Michael.rashleigh2005@gmail.com', 'michael@oneconnectaus.com.au', 'michaelbas24@hotmail.com', 'michaeljamesdev@icloud.com', 'michlaird@gmail.com', 'Micksdiscovery@gmail.com', 'mike19482@hotmail.com', 'mikeevillamor@icloud.com', 'mikew2340@gmail.com', 'mitchellcittadini@gmail.com', 'MJD.design@live.com', 'mjmonaghan12@bigpond.com', 'mmodrive@gmail.com', 'mobile12vhobart@gmail.com', 'morrisrjr@hotmail.com', 'morrissey089@gmail.com', 'mpitch1@bigpond.com', 'mtreekie@gmail.com', 'muldercrew@hotmail.com', 'my_other_shoe@hotmail.com', 'n77baker@yahoo.com.au', 'nabih.yaacoub@gmail.com', 'nahouli.456@gmail.com', 'nariman.d97@gmail.com', 'nathanaldous@hotmail.com', 'nathannicastri@hotmail.com', 'nathanveness@yahoo.com.au', 'neophitosandreou2001@gmail.com', 'nguyenphuoc204@gmail.com', 'nicholasnicou@hotmail.com', 'nick.colquhoun@outlook.com', 'nickjessop05@icloud.com', 'nickmumford@bigpond.com', 'nicoleclark@outlook.com.au', 'nidz@nidz.net', 'nissm0@hotmail.com', 'nlfmjy@hotmail.com', 'nodules-08-stopper@icloud.com', 'nokialaw1210@gmail.com', 'nomnob@gmail.com', 'nooonga121@hotmail.com', 'nortongl@westnet.com.au', 'nswenson03@gmail.com', 'ola.nicklason@live.com.au', 'oliver_dickson@hotmail.com', 'omarr.sleiman@gmail.com', 'omarz666@hotmail.com', 'oscar.kaye@gmail.com', 'oscar00perry@outlook.com', 'otoo7190@gmail.com', 'ovasales@bigpond.com', 'owenjlea@icloud.com', 'p.walnuts@gmail.com', 'paddy.keane@hotmail.com', 'pamiesan@bigpond.com', 'patrick.lillicrap@gmail.com', 'paul.kinbacher@gmail.com', 'paul.landrigan@bigpond.com', 'Paul231960@gmail.com', 'paulfhuxtable@gmail.com', 'pauljsands@yahoo.com', 'paultancredi@yahoo.com.au', 'perrybsm@gmail.com', 'petarprotic1@gmail.com', 'pete@martingalleries.com.au', 'peter_g_elliss@arnotts.com', 'peter_lupton@bigpond.com', 'peter.r.dean@outlook.com', 'pgrange63@gmail.com', 'pham.hoaa@hotmail.com', 'philhod@bigpond.com', 'pj_bester@bigpond.com', 'pj_captainsflat@yahoo.com.au', 'primeceilings@iprimus.com.au', 'princeautoelectrical@outlook.com', 'prof.yakkle@gmail.com', 'psullivan@live.com.au', 'Quyen.duong303@gmail.com', 'randj12@optusnet.com.au', 'raul@benchmarkautoelectrical.com.au', 'Ravenbrandon2484@gmail.com', 'razorzedge666@hotmail.com', 'rckostrz@gmail.com', 'rebeccabrooks01@outlook.com', 'reubenkershawmchugh@gmail.com', 'rick.tipper64@gmail.com', 'rickylawrence86@gmail.com', 'rikigreene1@bigpond.com', 'rlgclews@bigpond.com', 'rob@cpvehicles.com.au', 'robert.wilkinson@uqconnect.edu.au', 'robert29knowles@outlook.com', 'robertwarner.bt@gmail.com', 'robsonbuzios@hotmail.com', 'roger.wilkinson@internode.on.net', 'ronaldhiggs0@gmail.com', 'rwbadenoch@gmail.com', 'rx7nac@yahoo.com.au', 'Ryan@dawescoelectrical.com.au', 'Ryancatanz@outlook.com.au', 'ryanclark1991@gmail.com', 'rydersurf123@gmail.com', 'sales@carpartsonline.net.au', 'salter.paul@hotmail.com', 'sam_borromei@hotmail.com', 'sam@truinstalls.com.au', 'samuel.jones260603@gmail.com', 'samuel.lutzke@gmail.com', 'sarah_ong96@hotmail.com', 'scleung0918@gmail.com', 'scoie96@hotmail.com', 'scoobyrexx@gmail.com', 'scott.dove80@gmail.com', 'scottheather.sh@gmail.com', 'sduffield2@gmail.com', 'seager@internode.on.net', 'sebastian.deepak84@gmail.com', 'shadplumb@westvic.com.au', 'shaip_t@hotmail.com', 'Shanebmorton@gmail.com', 'shaneengle@hotmail.com', 'sharon@bmhearth.com', 'shaun_p_rees@hotmail.com', 'shaunwingrove@hotmail.com', 'shelaway17@gmail.com', 'shesmy_ute@hotmail.com', 'shilousa@outlook.com', 'simone.louise.h@gmail.com', 'simonkentwell@hotmail.com', 'simonloughhead@hotmail.com', 'sirmikey11@gmail.com', 'sjdeutscher@gmail.com', 'skuffer@bigpond.net.au', 'Slj_is@hotmail.com', 'sonya6462@bigpond.com', 'specialbega@gmail.com', 'starchaser93@gmail.com', 'stefan.vujevic@gmail.com', 'stefan8868@hotmail.com', 'stephen.nunn@bigpond.com', 'stephen.patterson@bigpond.com', 'stevelkneivel@gmail.com', 'steven.hogan99@gmail.com', 'steven@dreamcapital.com.au', 'stotty1995@hotmail.com', 'stuartfarrell@hotmail.com', 'tam_riley@hotmail.com', 'tarranjepsen@gmail.com', 'tattsalli@gmail.com', 'teleptaylor@gmail.com', 'the.simpsonsx4@bigpond.com', 'thomasmckerlie@live.com.au', 'thomasstokes94@hotmail.com', 'tiff.jensz@gmail.com', 'tim.howard87@gmail.com', 'timgraham888@gmail.com', 'timmy351@yahoo.com.au', 'timothynissen2002@gmail.com', 'tjralow@bigpond.com', 'tms1412.ts@gmail.com', 'tmt397@icloud.com', 'tnxk020@gmail.com', 'tombull1985@gmail.com', 'tomfoat@gmail.com', 'tomhouston123@gmail.com', 'tonky074@hotmail.com', 'tony.vera@bigpond.com', 'tonyg@mako.com.au', 'tpearce1175@gmail.com', 'tracybattersby@hotmail.com', 'travisbell888@hotmail.com', 'travisgill308@hotmail.com', 'trenteyles@gmail.com', 'troy@trojanim.com.au', 'TSGcarpentry@outlook.com.au', 'turnersamuel01@gmail.com', 'twoodhouse77@outlook.com', 'tylerandteneale@outlook.com', 'uranda5@bigpond.com', 'vasanthajith@hotmail.com', 'vijayshrinivas@gmail.com', 'vimissvi@hotmail.com', 'vinceallgood@gmail.com', 'vuthanhkinhte@gmail.com', 'walkerandrew014@gmail.com', 'waygoodwin@hotmail.com', 'wayneknight76@gmail.com', 'waynemaclagan62@yahoo.com.au', 'weh84d@gmail.com', 'wellsharry604@gmail.com', 'william.r.clement@gmail.com', 'wilson.riley27@gmail.com', 'wolvesbikeden.sales@gmail.com', 'xlfisher@gmail.com', 'y.liu24@hotmail.com', 'ypasnin@gmail.com', 'zac.brown1047@gmail.com', 'zac.pullen@icloud.com'])
		// ->whereIn('email', [
			// 'theodore@frankiesautoelectrics.com.au',
			// 'jr@frankiesautoelectrics.com.au', 
			// 'rodney@frankiesautoelectrics.com.au',
			// 'angela@frankiesautoelectrics.com.au', 
			// 'jay@frankiesautoelectrics.com.au', 
			// 'marnell@frankiesautoelectrics.com.au', 
			// 'eric@frankiesautoelectrics.com.au',	 
			// 'kate@frankiesautoelectrics.com.au'
		// ])
		->where(function($query) use ($campaign) {
			$query->where('campaign_status', null);
			$query->orWhere('campaign_status', 'NOT LIKE', '%febsale'.$campaign->campaign_id.';%');
		})
		->orderBy('created_at', 'DESC')
		->chunk(500, function($customers) use ($campaign, $items) {
			foreach ($customers as $customer) {				
				SendCampaignEmail::dispatch($campaign, $customer, $items)->onQueue('campaign_queue');
			}
		});


		return 1;
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

}
