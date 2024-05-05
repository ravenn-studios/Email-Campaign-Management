<?php

use Illuminate\Support\Facades\Route;
use Atymic\Twitter\Facade\Twitter;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SmmController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::get('privacy-policy', function () {
    return view('privacyPolicy.index');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});
Route::get('post', [SmmController::class, 'index']);
Route::get('active-posts', [SmmController::class, 'activePosts']);

Route::get('/homeTimeline', function()
{
	return Twitter::getHomeTimeline(['count' => 20, 'response_format' => 'json']);
});

//regular tweet
Route::get('/tweet', function()
{
	return Twitter::postTweet(['status' => 'Laravel is beautiful', 'response_format' => 'json']);
});

//tweet with media
Route::get('/tweetMedia', function()
{
	$file = File::get( public_path('/images/soft-cloth.jpg') );
	$uploaded_media = Twitter::uploadMedia(['media' => $file]);

	return Twitter::postTweet(['status' => 'Laravel is beautiful', 'media_ids' => $uploaded_media->media_id_string]);
});

Route::get('/userTimeline', function()
{
	return Twitter::getUserTimeline(['screen_name' => 'rodneydc3', 'count' => 20, 'response_format' => 'json']);
});

Route::get('/twitter', function(){
	return view('twitter.index');
});


// Route::post('/dropzone/upload', 'App\Http\Controllers\DropzoneController@upload')->name('dropzone.upload');
Route::post('/dropzone/upload', [DropzoneController::class, 'upload'])->name('dropzone.upload');

Route::get('/test', function(){

	$schedulePost = \App\Models\SchedulePost::find(1);
	dump($schedulePost->post_at);
	dump(\Carbon\Carbon::now());

	if ( (\Carbon\Carbon::now()->gt($schedulePost->post_at)) )
	{
		dd(99);
	}

	dd();

});

Route::get('/auth', [AuthController::class, 'auth']);
Route::get('/test', [TestController::class, 'index']);


// ajax posts
Route::post('/savePost', [AjaxController::class, 'savePost']);
Route::post('/saveAccessToken', [AjaxController::class, 'saveAccessToken']);
Route::post('/cancelPost', [AjaxController::class, 'cancelPost']);


Route::resource('campaigns', 'CampaignController');




// TestController
Route::get('/mythicalmorning', [TestController::class, 'mythicalmorning'])->name('test.mythicalmorning');
Route::get('/unsubscribe', [TestController::class, 'unsubscribe'])->name('test.unsubscribe');
Route::get('/click', [TestController::class, 'click'])->name('test.click');

Route::get('/track_click', [TestController::class, 'trackClick'])->name('test.track_click');
Route::get('/track_spam_report', [TestController::class, 'trackSpamReport'])->name('test.track_spam_report');
Route::get('/track_unsubscribe', [TestController::class, 'trackUnsubscribe'])->name('test.track_unsubscribe');
Route::get('/tracking_pixel', [TestController::class, 'trackingPixel'])->name('test.tracking_pixel');
Route::post('/unsubscribe_submit', [TestController::class, 'unsubscribeSubmit'])->name('unsubscribe.submit');