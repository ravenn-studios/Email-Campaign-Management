<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Campaign;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable {

	use Queueable, SerializesModels;

	public $campaign;
	public $customer;
	public $items;


	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Campaign $campaign, Customer $customer, $items) {
		$this->campaign = $campaign;
		$this->customer = $customer;
		$this->items    = $items;
	}

	public function getCustomer() {
		return $this->customer;
	}

	public function getCampaign() {
		return $this->campaign;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		// $subject = "🍁 [Recipient's Name], Drive Smarter, Save Better! 🚗 Explore Frankies' Autumn Sale for Driving Aids Bargains! 🍂";

		$placeholders = ["[Recipient's Name]", "[Recipient]", "[Recipient Name]"];
		$replacement = [$this->customer->first_name, $this->customer->first_name, $this->customer->first_name];

		$subject = str_replace($placeholders, $replacement, $this->campaign->campaign_subject);

		return $this->subject(str_replace("[Recipient's Name]", $this->customer->first_name, $subject))->markdown('emails.april.campaign');
	}
}
