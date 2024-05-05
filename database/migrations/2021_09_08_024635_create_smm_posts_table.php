<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmmPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smm_posts', function (Blueprint $table) {
            $table->id();
            $table->text('platform_id');
            $table->integer('file_id');
            $table->integer('user_id');
            $table->text('caption');
            $table->boolean('is_posted')->default(false);
            $table->integer('schedule_post_id');
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
        Schema::dropIfExists('smm_posts');
    }
}
