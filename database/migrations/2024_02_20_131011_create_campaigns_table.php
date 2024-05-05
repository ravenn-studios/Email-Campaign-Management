<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id('campaign_id'); // Unique identifier for the campaign
            
            $table->string('campaign_name'); // Name of the campaign
            $table->string('campaign_type'); // Type of campaign (e.g., email, social media)
            
            $table->dateTime('start_date')->nullable(); // When the campaign starts
            $table->dateTime('end_date')->nullable(); // When the campaign ends
            
            $table->decimal('budget', 10, 2)->nullable(); // Budget allocated for the campaign
            $table->string('currency')->nullable(); // Currency of the budget
            
            $table->string('status')->default('active'); // Current status of the campaign
            
            // Optionally, you can store the target audience as a string or JSON
            // For JSON support, ensure your database supports JSON data types
            $table->text('target_audience')->nullable(); 
            
            $table->text('objectives')->nullable(); // Primary objectives of the campaign
            
            // Channels can be stored as a comma-separated string or JSON
            // For JSON support, ensure your database supports JSON data types
            $table->text('channels')->nullable(); 
            
            $table->timestamps(); // Laravel's default timestamp fields for created_at and updated_at
            $table->softDeletes(); // For soft deletes

            // Additional optional fields based on previous discussions
            $table->json('performance_metrics')->nullable(); // JSON field for storing performance metrics
            $table->unsignedBigInteger('created_by')->nullable(); // Assuming you have a users table to reference
            $table->unsignedBigInteger('modified_by')->nullable(); // Assuming you have a users table to reference
            $table->text('notes')->nullable(); // Any additional notes or comments about the campaign
            $table->text('utm_parameters')->nullable(); // UTM parameters for tracking URLs
            
            // If you're using foreign keys, for example, to link to a users table
            // Ensure that you have the users table migration run before this
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
