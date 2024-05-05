@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Create a New Campaign</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Campaign</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Create Campaign </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card offset-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('campaigns.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="campaign_name">Campaign Name:</label>
                            <input type="text" class="form-control" id="campaign_name" name="campaign_name" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_subject">Campaign Subject:</label>
                            <input type="text" class="form-control" id="campaign_subject" name="campaign_subject" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_snippet">Campaign Snippet:</label>
                            <input type="text" class="form-control" id="campaign_snippet" name="campaign_snippet" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_type">Campaign Type:</label>
                            <input type="text" class="form-control" id="campaign_type" name="campaign_type" required>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>

                        <div class="form-group">
                            <label for="budget">Budget:</label>
                            <input type="text" class="form-control" id="budget" name="budget">
                        </div>

                        <div class="form-group">
                            <label for="currency">Currency:</label>
                            <select class="form-control" id="currency" name="currency">
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <!-- Add more currencies as needed -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <!-- Add more statuses as needed -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="target_audience">Target Audience:</label>
                            <input type="text" class="form-control" id="target_audience" name="target_audience">
                        </div>

                        <div class="form-group">
                            <label for="objectives">Objectives:</label>
                            <textarea class="form-control" id="objectives" name="objectives" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="channels">Channels:</label>
                            <input type="text" class="form-control" id="channels" name="channels">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="utm_parameters">UTM Parameters:</label>
                            <input type="text" class="form-control" id="utm_parameters" name="utm_parameters">
                        </div>

                        <button type="submit" class="btn btn-primary">Create Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
