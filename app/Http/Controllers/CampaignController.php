<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'campaign_subject' => 'required|string|max:255',
            'campaign_snippet' => 'required|string|max:255',
            'campaign_type' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric',
            'currency' => 'nullable|string|max:3',
            'status' => 'required|string|max:255',
            'target_audience' => 'nullable|string',
            'objectives' => 'nullable|string',
            'channels' => 'nullable|string',
            // Validate other fields as necessary
            // 'performance_metrics' => 'nullable|json', // Ensure your validation supports JSON if using
            'notes' => 'nullable|string',
            'utm_parameters' => 'nullable|string',
            // Assuming 'created_by' and 'modified_by' are automatically handled
        ]);

        $campaign                   = new Campaign();
        $campaign->campaign_name    = $request->campaign_name;
        $campaign->campaign_subject = $request->campaign_subject;
        $campaign->campaign_snippet = $request->campaign_snippet;
        $campaign->campaign_type    = $request->campaign_type;
        $campaign->start_date       = $request->start_date;
        $campaign->end_date         = $request->end_date;
        $campaign->budget           = $request->budget;
        $campaign->currency         = $request->currency;
        $campaign->status           = $request->status;
        $campaign->target_audience  = $request->target_audience;
        $campaign->objectives       = $request->objectives;
        $campaign->channels         = $request->channels;
        // Assign other fields from the request
        $campaign->notes            = $request->notes;
        $campaign->utm_parameters   = $request->utm_parameters;

        // If using Auth to automatically assign the creator and modifier
        $campaign->created_by  = Auth::id(); // Make sure the user is logged in
        $campaign->modified_by = Auth::id(); // This can be updated when editing the campaign

        $campaign->save();

        return redirect()->route('campaigns.create')->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign) {
        //
    }
}
