<?php

namespace App\Models;

use App\Models\Customer;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model {

    use HasFactory;

    protected $primaryKey = 'campaign_id';

    public function get_total_recipients() {
        return Customer::where('campaign_status', 'LIKE', '%febsale' . $this->campaign_id . '%')->count();
    }

    public function get_total_recipients_today() {
        return Customer::where([['campaign_status', 'LIKE', '%febsale' . $this->campaign_id . '%'], ['updated_at', '>', Carbon::today()]])->count();
    }

    public function get_total_opens() {
        return Click::where(['campaign_id' => $this->campaign_id, 'url' => 'https://gmail.com'])->count();
    }

    public function get_total_open_rate() {
        return round(($this->get_total_opens() > 0 ? ($this->get_total_opens() / $this->get_total_recipients()) : 0) * 100, 2);
    }

    public function get_total_clicks() {
        return Click::where(['campaign_id' => $this->campaign_id, ['url', 'NOT LIKE', '%https://gmail.com%']])->count();
    }

    public function get_click_through_rate() {
        $uniqueClicks = Click::where('campaign_id', $this->campaign_id)->distinct('customer_id')->count('customer_id');
        $totalDelivered = $this->get_total_recipients(); 
        $CTR = $totalDelivered > 0 ? ($uniqueClicks / $totalDelivered) * 100 : 0;
        return round($CTR, 2);
    }

    public function get_total_unsubscribers() {
        return Click::where(['campaign_id' => $this->campaign_id, 'url' => 'https://frankiesautoelectrics.com.au/unsubscribe'])->count();
    }

    public function get_total_unsubscribers_today() {
        return Click::where(['campaign_id' => $this->campaign_id, 'url' => 'https://frankiesautoelectrics.com.au/unsubscribe', ['created_at', '>', Carbon::today()]])->count();
    }

    public function get_total_spam_complaints() {
        return Click::where(['campaign_id' => $this->campaign_id, 'url' => 'https://frankiesautoelectrics.com.au/spam-report'])->count();
    }

    public function get_total_spam_complaints_today() {
        return Click::where(['campaign_id' => $this->campaign_id, 'url' => 'https://frankiesautoelectrics.com.au/spam-report', ['created_at', '>', Carbon::today()]])->count();
    }

    public function customers() {
        return $this->belongsToMany(Campaign::class, 'campaign_customer', 'campaign_id', 'customer_id')
                    ->withPivot('sent_at', 'is_sent')
                    ->withTimestamps();
    }
}
