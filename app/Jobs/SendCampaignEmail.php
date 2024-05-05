<?php

namespace App\Jobs;

use App\Mail\CampaignMail;

use App\Mail\MarchSoundSystem;
use App\Models\Campaign;
use App\Models\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class SendCampaignEmail implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    protected $customer;
    protected $items;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Customer $customer, $items) {
        $this->campaign = $campaign;
        $this->customer = $customer;
        $this->items    = $items;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->customer->email)
            // ->bcc(['theodore@frankiesautoelectrics.com.au'])
            ->queue((new CampaignMail($this->campaign, $this->customer, $this->items))->onQueue('campaign_queue'));

        \Log::info('Updating pivot for campaign '.$this->campaign->id.' and customer '.$this->customer->id);
        try {
            $this->campaign->customers()->attach($this->customer->id, ['is_sent' => true, 'sent_at' => now()]);
            $this->customer->campaign_status .= 'febsale'. $this->campaign->campaign_id . ';';
            $this->customer->save();
        } catch (\Exception $e) {
            \Log::error('Error updating pivot: '.$e->getMessage());
        }
        \Log::info('Pivot updated');
    
    }
}
