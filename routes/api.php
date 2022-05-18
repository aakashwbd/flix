<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\UploaderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('profile', [AuthController::class, "profileInfo"]);
        Route::post('profile/settings', [\App\Http\Controllers\ProfileSetting::class, "store"]);
        Route::get('profile/settings', [\App\Http\Controllers\ProfileSetting::class, "getProfile"]);
        Route::patch('profile/settings/suspend', [\App\Http\Controllers\ProfileSetting::class, "suspend"]);
        Route::delete('profile/settings/delete', [\App\Http\Controllers\ProfileSetting::class, "delete"]);
    });
});

Route::get('member/profile/{id}', [AuthController::class, 'show']);
Route::post('profile/visit', [\App\Http\Controllers\ProfileVisitCountController::class, 'store']);
Route::get('profile/visitors', [\App\Http\Controllers\ProfileVisitCountController::class, 'show']);

Route::post('search-user', [AuthController::class, 'searchUser']);

Route::post('user/get-all', [AuthController::class, 'getAll']);
Route::post('user/fetch-all', [AuthController::class, 'getByUnAuth']);
Route::post('user/send-flash', [\App\Http\Controllers\FlashController::class, 'sendFlash']);
Route::get('user/get-flash', [\App\Http\Controllers\FlashController::class, 'getUserFlash']);

Route::get('user/all-users', [AuthController::class, 'fetchAllUser']);

Route::get('user/{id}', [AuthController::class, 'show']);
Route::post('user/{id}', [AuthController::class, 'statusUpdate']);

Route::post('forgot-password', [AuthController::class, 'checkEmail']);
Route::post('recover-password', [AuthController::class, 'updatePassword']);
Route::post('otp', [AuthController::class, 'matchOTP']);

Route::get('/share-website', [\App\Http\Controllers\SocialShareController::class, 'index']);


Route::post('favourite/store', [\App\Http\Controllers\FavouriteController::class, 'store']);
Route::get('favourite', [\App\Http\Controllers\FavouriteController::class, 'index']);

Route::post('block/store', [\App\Http\Controllers\BlockController::class, 'store']);
Route::get('block', [\App\Http\Controllers\BlockController::class, 'index']);


Route::post('alert/store', [\App\Http\Controllers\AlertController::class, 'store']);

Route::post('rating/store', [\App\Http\Controllers\RatingController::class, 'store']);
Route::post('video/comment', [\App\Http\Controllers\VideoCommentController::class, 'store']);
Route::get('video/comment/{id}', [\App\Http\Controllers\VideoCommentController::class, 'show']);
Route::get('rating/count/{id}', [\App\Http\Controllers\RatingController::class, 'count']);

Route::post('testimony/store', [\App\Http\Controllers\TestimonyController::class, 'store']);
Route::get('testimony/{id}', [\App\Http\Controllers\TestimonyController::class, 'show']);
Route::get('testimony/all', [\App\Http\Controllers\TestimonyController::class, 'getAll']);


Route::post('send-messages', [\App\Http\Controllers\MessengerController::class, 'store']);
Route::get('get-message/{id}', [\App\Http\Controllers\MessengerController::class, 'getMessage']);
Route::get('get-message/all', [\App\Http\Controllers\MessengerController::class, 'getAllMessage']);
Route::get('short-messages', [\App\Http\Controllers\MessengerController::class, 'getByPersonMessage']);
Route::post('contact-us', [\App\Http\Controllers\ContactUsController::class, 'store']);


//Route::get('/check', [AuthController::class, 'userOnlineStatus']);


Route::prefix('admin')->group(function () {



    Route::get('/all', [\App\Http\Controllers\AdminController::class, 'index']);
    Route::patch('/update-password', [\App\Http\Controllers\AdminController::class, 'updatePassword']);
    Route::patch('/profile-update', [\App\Http\Controllers\AdminController::class, 'profileUpdate']);

    Route::delete('/{id}', [\App\Http\Controllers\AdminController::class, 'delete']);
    Route::get('/{id}', [\App\Http\Controllers\AdminController::class, 'getSingle']);
    Route::patch('/{id}', [\App\Http\Controllers\AdminController::class, 'update']);

    Route::get('dashboard/total-count', [\App\Http\Controllers\DashboardCountController::class, 'totalCount']);


    Route::post('/banner-image/store', [BannerController::class, 'store']);
    Route::get('/banner-image/index', [BannerController::class, 'index']);
    Route::delete('/banner-image/{id}', [BannerController::class, 'delete']);
    Route::patch('/banner-image/{id}', [BannerController::class, 'update']);
    Route::get('/banner-image/{id}', [BannerController::class, 'getSingle']);


    Route::get('user/get-all', [AuthController::class, 'index']);

    Route::get('user/all-users', [AuthController::class, 'getAllUsers']);
    Route::get('user/suspend', [AuthController::class, 'suspendUser']);

    Route::post('setting/store', [\App\Http\Controllers\SettingController::class, 'store']);
    Route::get('setting/get-all', [\App\Http\Controllers\SettingController::class, 'index']);
    Route::get('setting/faq/search', [\App\Http\Controllers\SettingController::class, 'faqSearch']);

    Route::post('category/store', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('category/all', [\App\Http\Controllers\CategoryController::class, 'getAll']);
    Route::delete('category/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);
    Route::patch('category/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::get('category/{id}', [\App\Http\Controllers\CategoryController::class, 'getSingle']);

    Route::post('invite-code/store', [\App\Http\Controllers\InviteCodeController::class, 'store']);
    Route::get('invite-code/get-all', [\App\Http\Controllers\InviteCodeController::class, 'index']);
    Route::get('invite-code/get-by-user', [\App\Http\Controllers\InviteCodeController::class, 'getByUser']);
    Route::get('invite-code/{id}', [\App\Http\Controllers\InviteCodeController::class, 'getSingleCode']);
    Route::patch('invite-code/{id}', [\App\Http\Controllers\InviteCodeController::class, 'update']);
    Route::delete('invite-code/{id}', [\App\Http\Controllers\InviteCodeController::class, 'delete']);

    Route::post('notification/store', [\App\Http\Controllers\NotificationController::class, 'store']);
    Route::get('notification/get-all', [\App\Http\Controllers\NotificationController::class, 'index']);
    Route::delete('notification/{id}', [\App\Http\Controllers\NotificationController::class, 'delete']);

    Route::post('notification/manage-api', [\App\Http\Controllers\NotificationController::class, 'manageApi']);
    Route::get('notification/manage-api/fetch', [\App\Http\Controllers\NotificationController::class, 'fetchManageApi']);

    Route::get('package/list/get-all', [\App\Http\Controllers\PackageController::class, 'show']);
    Route::get('package/all-list', [\App\Http\Controllers\PackageController::class, 'getAllPackage']);
    Route::get('package/{id}', [\App\Http\Controllers\PackageController::class, 'getSingle']);
    Route::post('package/update', [\App\Http\Controllers\PackageController::class, 'update']);

    Route::post('/blog/store', [\App\Http\Controllers\BlogController::class, 'store']);
    Route::get('/blog/get-all', [\App\Http\Controllers\BlogController::class, 'show']);
    Route::get('/blog/{id}', [\App\Http\Controllers\BlogController::class, 'index']);
    Route::get('/blog/{id}', [\App\Http\Controllers\BlogController::class, 'getSingleBlog']);
    Route::delete('/blog/{id}', [\App\Http\Controllers\BlogController::class, 'delete']);
    Route::patch('/blog/{id}', [\App\Http\Controllers\BlogController::class, 'update']);
    Route::get('/blog/comment/{id}', [\App\Http\Controllers\BlogCommentController::class, 'getAllComment']);

    Route::post('/flash', [\App\Http\Controllers\FlashController::class, 'store']);
    Route::get('/flash/get', [\App\Http\Controllers\FlashController::class, 'show']);
    Route::get('flash-list/all-list', [\App\Http\Controllers\FlashController::class, 'allList']);
    Route::delete('flash-list/{id}', [\App\Http\Controllers\FlashController::class, 'delete']);
    Route::get('flash-list/{id}', [\App\Http\Controllers\FlashController::class, 'singleShow']);
    Route::patch('flash-list/{id}', [\App\Http\Controllers\FlashController::class, 'update']);

    Route::get('/payment', [\App\Http\Controllers\FlashController::class, 'show']);

    Route::get('recent-payment/all', [\App\Http\Controllers\CheckoutController::class, 'getAllCheckoutList']);


    Route::post('video/store', [\App\Http\Controllers\VideoController::class, 'store']);
    Route::get('video/get-all', [\App\Http\Controllers\VideoController::class, 'index']);
    Route::get('video/fetch-all', [\App\Http\Controllers\VideoController::class, 'fetch']);
    Route::patch('video/id', [\App\Http\Controllers\VideoController::class, 'update']);
    Route::patch('video/{id}', [\App\Http\Controllers\VideoController::class, 'videoUpdate']);
    Route::delete('video/{id}', [\App\Http\Controllers\VideoController::class, 'delete']);
    Route::get('video/{id}', [\App\Http\Controllers\VideoController::class, 'getSingle']);

    Route::get('alert/all-list', [\App\Http\Controllers\AlertController::class, 'getAll']);

    Route::post('smtp/store', [\App\Http\Controllers\SmtpController::class, 'store']);
    Route::get('smtp/fetch', [\App\Http\Controllers\SmtpController::class, 'fetch']);

});
Route::post('/blog/comment', [\App\Http\Controllers\BlogCommentController::class, 'store']);

Route::post('file/store', [\App\Http\Controllers\FileController::class, 'store']);
Route::get('file/video', [\App\Http\Controllers\FileController::class, 'getVideo']);
Route::get('file/video/{id}', [\App\Http\Controllers\FileController::class, 'singleVideo']);
Route::post('file/video/search', [\App\Http\Controllers\FileController::class, 'search']);
Route::get('file/fetch-all', [\App\Http\Controllers\FileController::class, 'fetchAll']);

Route::post('video/search', [\App\Http\Controllers\VideoController::class, 'search']);
Route::post('place/store', [\App\Http\Controllers\AdController::class, 'store']);

Route::patch('place/{id}', [\App\Http\Controllers\AdController::class, 'update']);
Route::delete('place/{id}', [\App\Http\Controllers\AdController::class, 'delete']);

Route::get('place/get-all', [\App\Http\Controllers\AdController::class, 'getAll']);
Route::post('/news/search', [\App\Http\Controllers\AdController::class, 'search']);

Route::post('checkout', [\App\Http\Controllers\CheckoutController::class, 'store']);
Route::get('subscriber/all-list', [\App\Http\Controllers\CheckoutController::class, 'allSubcribeUser']);

Route::post('image-uploader', [UploaderController::class, 'imgUploader']);
Route::post('set-location', [\App\Http\Controllers\LocationController::class, 'store']);
Route::get('get-location', [\App\Http\Controllers\LocationController::class, 'getall']);
Route::patch('user-activity-check', [\App\Http\Controllers\auth\AuthController::class, 'userOnlineStatus']);


