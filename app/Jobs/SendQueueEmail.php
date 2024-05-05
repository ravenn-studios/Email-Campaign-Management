<?php

namespace App\Jobs;

use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendQueueEmail implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	protected $customers;
	public $timeout = 7200; // 2 hours

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($customers) {
		$this->customers = $customers;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$emailTemplate = 'mail.boxingdaysaleemail';
		$items = [
			'headers' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/boxing-week-clearance-up-to-80-off/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/28f861a343aec7dab73a0937e482f3ce&Header&1671519146.jpg'
				]
			],

			'subheaders' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/pioneer-dmh-a4450bt-6-8-capacitive-touch-screen-multimedia-receiver-with-apple-carplay-android-auto-bluetooth/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/39b583e87e263b8b80bec436f77782e6&Great-Deal&1671519146.jpg'
				]
			],

			'featured-products' => [
				[
					[
						'url' => 'https://frankiesautoelectrics.com.au/sony-xav-ax5000-6-95-apple-carplay-android-auto-usb-bluetooth-media-receiver/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/d5d762683a143f23abc477b7be35b105&image_2022_12_21T00_09_12_863Z&1671581507.png',
					],
					[
						'url' => 'https://frankiesautoelectrics.com.au/pioneer-dmh-z5350bt-6-8-apple-carplay-android-auto-bluetooth-multimedia-player/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/4613dbe774a5cb43c9d568368d6e3199&Product-2&1671519004.jpg',
					],
				], [
					[
						'url' => 'https://frankiesautoelectrics.com.au/pioneer-dmh-a245bt-6-2-digital-media-av-receiver/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/ef07678cf631f62dc52b70fc3da8b8b3&Product-3&1671519004.jpg',
					],
					[
						'url' => 'https://frankiesautoelectrics.com.au/clarion-fx450-6-8-double-din-mechless-av-receiver-with-bluetooth-carplay-android-auto/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/47240baa04eadca4e20809204e08f12a&Product-4&1671519004.jpg',
					],
				]
			],

			'banners' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/25-off-rrp-jbl-and-rockford-fosgate/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/187414eec4e5e1bd67c53f084ee29e39&image_2022_12_19T06_07_48_703Z&1671463108.png',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/gme-on-sale/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/18e2904616464e6b239beb7369150128&image_2022_12_19T06_08_00_812Z&1671463108.png',
				]
			],

			'middleheaders' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/xs-lighting-xs-dlb20-20-led-light-bar-combo-beam/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/7584d60f589a00136195ced803ee90ef&Product-5&1671519004.jpg',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/big-red-br9506-6-bar-high-powered-led-camping-light-kit-white-amber/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/1de7b0d702b50b93cdce46b8f90f20fd&Product-6&1671519507.jpg',
				],
			],


			'best-selling-products' => [
				[
					[
						'url' => 'https://frankiesautoelectrics.com.au/jbl-stage-a9004-90-watts-rms-x-4-4-ohms-high-level-input-4-channel-amplifier/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/43041ecef7b4781729daf2c3d22f8b23&Product-7&1671519004.jpg',
					],
					[
						'url' => 'https://frankiesautoelectrics.com.au/jbl-stage3-9637-6-x-9-3-way-triaxial-speakers-75w-rms-3-ohm-includes-grilles/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/6aaf77bbec8ae773d1162618e31c6f92&Product-8&1671519004.jpg',
					],
				], [
					[
						'url' => 'https://frankiesautoelectrics.com.au/rockford-fosgate-r2s-1x10-prime-10-r2s-shallow-loaded-enclosure/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/f0fc448a30f4e73f9bb5885c17cbfabe&Product-9&1671519004.jpg',
					],
					[
						'url' => 'https://frankiesautoelectrics.com.au/rockford-fosgate-p2d2-8-punch-8-p2-2-ohm-dvc-subwoofer/',
						'image' => 'https://ultimatehosting.blackedgedigital.com/images/c401a0deee7ee492980c6ebf7b8b10ab&Product-10&1671519004.jpg',
					],
				]
			],

			'bottomheaders' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/dynamat-10455-xtreme-black-bulk-pack-sound-deadener-9-sheets/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/fe28efa1fc20c1e3c4d6239586f4af14&Product-11&1671519507.jpg',
				],
			],

			'special-products' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/thunder-tdr15002-80w-solar-panel/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/4caa89a317643b59a2b6c506f0356e67&Thunder-1&1671519146.jpg',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/thunder-tdr15005-80w-folding-solar-panel/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/8be20b61c9e96b4a67bff557ff9a2f6a&Thunder-2&1671519146.jpg',
				],
				[
					'url' => 'https://frankiesautoelectrics.com.au/thunder-tdr15007-240w-folding-solar-panel/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/791a30d6988f212e2bc9e5764d10cc7f&Thunder-3&1671519146.jpg',
				],
			],


			'finalheaders' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/us-audio-ussp10pa-10-300w-rms-1000w-peak-active-subwoofer-box-system-pink/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/8af8b52e56e975a08aaadae105e95495&Final-Product&1671519507.jpg',
				],
			],


			'footers' => [
				[
					'url' => 'https://frankiesautoelectrics.com.au/',
					'image' => 'https://ultimatehosting.blackedgedigital.com/images/23226edb04f810b19b2194f2b2f630b3&Footer&1671519146.jpg',
				],
			],

		];

		foreach ($this->customers as $customer) {

			Mail::send($emailTemplate, ['items' => $items, 'customer' => $customer], function($message) use($customer){
				$message->to($customer->email);
				$message->bcc(['theodore@frankiesautoelectrics.com.au']);
				$message->subject('Hey, ' . ucwords($customer->first_name) . '! 🎁 Boxing Week Clearance Sale Now Live, Up to 80% off!');
			});

			if (Mail::failures()) {
				logger(Mail::failures());
			} else {
				$customer->status = '0';
				$customer->save();
			}
		}
	}
}
