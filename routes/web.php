<?php

use App\Events\Message;
use App\Http\Controllers\SocialAuthTwitterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'landing.home.index');
Route::view('/member/profile/{id}', 'landing.home.view');
Route::view('/ads', 'landing.ads.index');
Route::view('/live', 'landing.live.index');
Route::view('/videos', 'landing.videos.index');
Route::view('/videos/{id}', 'landing.videos.view');
Route::view('/maps', 'landing.maps.index');
Route::view('/blogs', 'landing.blogs.index');
Route::view('/package', 'landing.package.index');
Route::view('/package/{id}', 'landing.package.payment');
Route::view('/inscription', 'landing.inscription.index');
Route::view('/profile', 'landing.profile.index');
Route::view('/information', 'landing.more_menu.index');
Route::view('/graph', 'landing.graph.index');
Route::view('/live', 'landing.live.index');
Route::view('/about', 'landing.about.index');

Route::get('/check', [\App\Http\Controllers\auth\AuthController::class, 'userOnlineStatus']);

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.home.index');
    Route::view('/category', 'admin.category.index');
    Route::view('/blog', 'admin.blog.index');
    Route::view('/banner-image', 'admin.banner.index');
    Route::view('/verification', 'admin.verification.index');
    Route::view('/manage-admin', 'admin.manage-admin.index');
    Route::view('/manage-users', 'admin.user.index');
    Route::view('/banned-users', 'admin.user.banned');
    Route::view('/settings', 'admin.setting.index');
    Route::view('/package', 'admin.package.index');
    Route::view('/invite-code', 'admin.invitation.index');
    Route::view('/recent-payment', 'admin.payment.index');
    Route::view('/notification', 'admin.notification.index');
    Route::view('/video', 'admin.video.index');
    Route::view('/flash', 'admin.flash.index');
    Route::view('/report', 'admin.report.index');
    Route::view('/smtp', 'admin.smtp.index');
    Route::view('/change-password', 'admin.auth.password');
    Route::view('/profile', 'admin.auth.profile');

    Route::prefix('auth')->group(function () {
        Route::view('/login', 'admin.auth.login');
    });
});

Route::get('/auth/twitter', [SocialAuthTwitterController::class, 'redirect']);
Route::get('/auth/callback/twitter', [SocialAuthTwitterController::class, 'callback']);


//    Route::get('/streaming', 'App\Http\Controllers\WebrtcStreamingController@index');
//    Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
//    Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
//    Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');

    Route::get('/streaming', 'App\Http\Controllers\WebrtcStreamingController@index');
    Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
    Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
    Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');

Route::post('/send-message', function (Request $request) {
    event($data = new Message($request->from_user_id, $request->to_user_id, $request->message));

    return [
        'success' => true,
    ];
});
