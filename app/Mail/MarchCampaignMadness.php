<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Campaign;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarchCampaignMadness extends Mailable {

    use Queueable, SerializesModels;

    public $subject;

    public $campaign;
    public $customer;
    public $items;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, Campaign $campaign, Customer $customer, $items) {
        $this->subject  = $subject;
        $this->campaign = $campaign;
        $this->customer = $customer;
        $this->items    = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject($this->subject)
                    ->markdown('emails.march.march_madness');
    }
}
