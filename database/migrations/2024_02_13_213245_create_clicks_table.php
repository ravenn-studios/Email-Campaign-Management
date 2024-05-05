<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();

            $table->integer('campaign_id');

            $table->string('url');
            $table->string('customer_id');
            $table->string('user_agent');
            $table->string('referrer');
            $table->string('ip_address');
            $table->string('click_type');
            $table->string('country');
            $table->string('device_type');
            $table->string('action');
            $table->string('page_title');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
