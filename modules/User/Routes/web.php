<?php

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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->middleware('auth','adminauth')->group(function() {
  	Route::post('view-user-detail', 'UserDataController@viewUserDetail');
  	Route::post('addDesigner', 'UserDataController@addDesigner');
  	Route::post('viewDesignerPolitical', 'UserDataController@viewDesignerPolitical');
});
Route::prefix('custom_frame')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'UserDataController@customFrame')->name('custom_frame');
  	Route::get('/getCustomFrameData', 'UserDataController@getCustomFrameData');
  	Route::get('/getCustomFrameDataPolitical', 'UserDataController@getCustomFrameDataPolitical');
  	Route::get('/getCustomFrameCompletedData', 'UserDataController@getCustomFrameCompletedData');
  	Route::get('/getCustomFrameCompletedDataPolitical', 'UserDataController@getCustomFrameCompletedDataPolitical');
  	Route::post('/add_custom_frame', 'UserDataController@add_custom_frame');
  	Route::post('/get_business', 'UserDataController@getBusiness');
  	Route::post('/getCustomFrames', 'UserDataController@getCustomFrames');
  	Route::post('/editBusinessFromFrame', 'UserDataController@editBusinessFromFrame');
});

Route::prefix('telecaller')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'TelecallerController@index')->name('telecaller');
  	Route::get('/list', 'TelecallerController@getTelecallerList');
  	Route::post('/getAssignedUser', 'TelecallerController@getAssignedUser');
  	Route::post('/assigneUserAdd', 'TelecallerController@assigneUserAdd');
  	Route::post('/getUserByDate', 'TelecallerController@getUserByDate');
  	Route::post('/transferUser', 'TelecallerController@transferUser');
});

Route::prefix('sticker')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'StickerController@index')->name('sticker');
  	Route::post('/getStickers', 'StickerController@getStickers');
  	Route::post('/addSticker', 'StickerController@addSticker');
  	Route::post('/deleteSticker', 'StickerController@deleteSticker');
  	Route::get('/getStickerCategory', 'StickerController@getStickerCategory');
  	Route::post('/addStickerCategory', 'StickerController@addStickerCategory');
  	Route::post('/deleteStickerCategory', 'StickerController@deleteStickerCategory');
  	Route::post('/editStickerCategory', 'StickerController@editStickerCategory');
  	Route::post('/updateStickerCategory', 'StickerController@updateStickerCategory');
});

Route::prefix('background')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'BackgroundController@index')->name('background');
  	Route::post('/getBackgrounds', 'BackgroundController@getBackgrounds');
  	Route::post('/addBackground', 'BackgroundController@addBackground');
  	Route::post('/deleteBackground', 'BackgroundController@deleteBackground');
  	Route::get('/getBackgroundCategory', 'BackgroundController@getBackgroundCategory');
  	Route::post('/addBackgroundCategory', 'BackgroundController@addBackgroundCategory');
  	Route::post('/deleteBackgroundCategory', 'BackgroundController@deleteBackgroundCategory');
  	Route::post('/editBackgroundCategory', 'BackgroundController@editBackgroundCategory');
  	Route::post('/updateBackgroundCategory', 'BackgroundController@updateBackgroundCategory');
});

Route::prefix('musicCategory')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'MusicCategoryController@index')->name('musicCategory');
    Route::get('/getMusicCategory', 'MusicCategoryController@getMusicCategory');
    Route::post('/addMusicCategory', 'MusicCategoryController@addMusicCategory');
    Route::post('/getMusicCategoryById', 'MusicCategoryController@getMusicCategoryById');
    Route::post('/updateMusicCategory', 'MusicCategoryController@updateMusicCategory');
    Route::post('/deleteMusicCategory', 'MusicCategoryController@deleteMusicCategory');
    Route::get('/{id}', 'MusicController@index')->name('musicList');
});

Route::prefix('music')->middleware('auth','adminauth')->group(function() {
    Route::get('/list/{id}', 'MusicController@index')->name('musicList');
    Route::get('/getMusicByCategory/{id}', 'MusicController@getMusicByCategory');
    Route::post('/addMusic', 'MusicController@addMusic');
    Route::post('/getMusicById', 'MusicController@getMusicById');
    Route::post('/updateMusic', 'MusicController@updateMusic');
    Route::post('/deleteMusic', 'MusicController@deleteMusic');
});

Route::prefix('graphic')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'GraphicController@index')->name('graphic');
    Route::post('/getGraphics', 'GraphicController@getGraphics');
    Route::post('/addGraphic', 'GraphicController@addGraphic');
    Route::post('/deleteGraphic', 'GraphicController@deleteGraphic');
    Route::get('/getGraphicCategory', 'GraphicController@getGraphicCategory');
    Route::post('/addGraphicCategory', 'GraphicController@addGraphicCategory');
    Route::post('/deleteGraphicCategory', 'GraphicController@deleteGraphicCategory');
    Route::post('/editGraphicCategory', 'GraphicController@editGraphicCategory');
    Route::post('/updateGraphicCategory', 'GraphicController@updateGraphicCategory');
});

Route::prefix('popup')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'PopupDataController@index')->name('popup');
  	Route::get('/getPopup', 'PopupDataController@getPopup');
  	Route::post('/addPopup', 'PopupDataController@addPopup');
  	Route::post('/editPopup', 'PopupDataController@editPopup');
  	Route::post('/updatePopup', 'PopupDataController@updatePopup');
  	Route::post('/deletePopup', 'PopupDataController@deletePopup');
});

Route::prefix('frame')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'FrameController@index')->name('frame');
    Route::get('/getFrame', 'FrameController@getFrame');
    Route::post('/addFrame', 'FrameController@addFrame');
    Route::post('/editFrame', 'FrameController@editFrame');
    Route::post('/updateFrame', 'FrameController@updateFrame');
    Route::get('/addlayers/{id}', 'FrameController@addlayers')->name('addlayers');
    Route::get('/getComponents/{id}', 'FrameController@getComponents');
    Route::post('/addComponent', 'FrameController@addComponent');
    Route::post('/editComponent', 'FrameController@editComponent');
    Route::post('/updateComponent', 'FrameController@updateComponent');
    Route::post('/deleteComponent', 'FrameController@deleteComponent');
    Route::get('/getTexts/{id}', 'FrameController@getTexts');
    Route::post('/addText', 'FrameController@addText');
    Route::post('/editText', 'FrameController@editText');
    Route::post('/updateText', 'FrameController@updateText');
    Route::post('/deleteText', 'FrameController@deleteText');
});

Route::prefix('user')->middleware('auth','adminauth')->group(function() {

    Route::get('/', 'UserController@index')->name('userlist');
    Route::get('view-user', 'UserDataController@index');

 	Route::post('block-user', 'UserDataController@blockuser');
  	Route::post('unblock-user', 'UserDataController@unblockuser');

	Route::get('listallbusiness',function(){
        $business_category = DB::table('business_category')->where('is_delete','=',0)->get();
		return view("user::businesslist",['business_category'=>$business_category]);
	 })->name('listallbusiness');

	 Route::get('politicallistallbusiness',function(){
        $political_category = DB::table('political_category')->where('pc_is_deleted','=',0)->get();
		return view("user::politicalbusinesslist",['political_category'=>$political_category]);
	 })->name('politicallistallbusiness');

	Route::get('view-business-list','UserDataController@ListofAllBusiness');

  	Route::get('approval', 'UserDataController@ListofBusinessApproval')->name('approval');

  	Route::post('approv-business', 'UserDataController@approvBusiness');

  	Route::post('decline-business', 'UserDataController@declineBusiness');

  	Route::post('remove-user', 'UserDataController@removeUser');

  	//Route::post('view-user-detail', 'UserDataController@viewUserDetail');

	Route::post('purchase-plan', 'UserDataController@purchasePlan');

	Route::post('cancel-plan', 'UserDataController@cencalPurchasedPlan');

	Route::post('addframe', 'UserDataController@addFrame');

	Route::post('removeframe', 'UserDataController@removeFrame');

	Route::post('remove-business', 'UserDataController@RemoveBusiness');
	Route::post('remove-business-political', 'UserDataController@RemoveBusinessPolitical');

	Route::get('allpostlist', 'UserDataController@AllPost');

	Route::get('allpost', function(){
		$telecallers = DB::table('users')->where('status', 0)->where('user_role', 2)->get();
		return view("user::allpost", ['telecallers' => $telecallers]);
	})->name('allpost');

	Route::post('allpostassigneTelecallerAdd', 'UserDataController@assigneTelecallerAdd');

	Route::post('getBusinessforEdit', 'UserDataController@getBusinessforEdit');

	Route::post('updateBusiness', 'UserDataController@updateBusiness');

	Route::post('get-reffer-user-list', 'UserDataController@getRefUserList');

	Route::post('plan-list', 'UserDataController@PlanList');

	// Route::get('pushnotification', function(){
	// 	return view("user::pushnotification");
	// });


	Route::get('push_notification','PushNotificationController@index')->name('pushnotification');
	Route::post('getBusinessCategory','PushNotificationController@getBusinessCategory');
	Route::post('changeNotificationType','PushNotificationController@changeNotificationType');
	Route::post('schedule_notification','PushNotificationController@schedule_notification');
	Route::post('editPushNotification','PushNotificationController@editPushNotification');
	Route::post('updatePushNotification','PushNotificationController@updatePushNotification');
	Route::post('deletePushNotification','PushNotificationController@deletePushNotification');
	Route::get('getPendingNotification','PushNotificationController@getPendingNotification');
	Route::get('getCompletedNotification','PushNotificationController@getCompletedNotification');
	Route::post('sendpushnotification','UserDataController@sendPushNotification')->name('sendpushnotification');

	Route::post('deletePhotos','UserDataController@DeletePhotos');

	Route::get('adminuser', function(){
		return view("user::adminuser");
	})->name('adminuser');

	Route::get('expiredplanlist', function(){
		return view("user::expiredplanlist");
	})->name('expiredplanlist');

	Route::get('getexpiredplanlist','UserDataController@getExpiredPlanList');

	Route::post('adduser','AdminUserController@store');
	Route::get('getuser','AdminUserController@index');
	Route::post('block-users', 'AdminUserController@BlockUser');
    Route::post('unblock-users', 'AdminUserController@UnBlockUser');
    Route::post('removeUsers', 'AdminUserController@destroy');
    Route::post('edit', 'AdminUserController@edit');

	// Political Business

	Route::get('view-political-business-list','UserDataController@ListofAllPoliticalBusiness');

	Route::get('view-political-user-business-list','UserDataController@ListofUsersAllPoliticalBusiness');

	Route::post('getPoliticalBusinessforEdit','UserDataController@getPoliticalBusinessforEdit');

	Route::post('updatePoliticalBusiness','UserDataController@updatePoliticalBusiness');

	Route::post('purchasePoliticalPlan','UserDataController@purchasePoliticalPlan');

	Route::post('political-plan-list','UserDataController@getPoliticalPlanList');

	Route::post('political-categoty-list','UserDataController@getPoliticalCategoryList');

	Route::post('political-plan-cencal','UserDataController@cencalPoliticalPurchasedPlan');

	Route::post('political-user-business-frame-list','UserDataController@getPoliticalUserBusinessFrameList');

	Route::get('political-approval','UserDataController@ListofPoliticalBusinessApproval')->name('political-approval');

	Route::post('approve-political-business','UserDataController@approvePoliticalbusiness');

	Route::post('decline-political-business','UserDataController@declinePoliticalBusiness');

	Route::post('get-business-list-type-wise','UserDataController@getBusinessListTypeWise');
});

Route::prefix('userlist')->middleware('adminauth')->group(function() {
	Route::get('getuserslist', function(){
		return view("user::adminuserslist");
	})->name('getuserslist');
    Route::post('viewuserslist', 'AdminUserController@getUsersList');
    Route::get('hold-viewuserslist', 'AdminUserController@HoldgetUsersList');
    Route::get('complete-viewuserslist', 'AdminUserController@CompletegetUsersList');
    Route::get('complete-viewuserslist', 'AdminUserController@CompletegetUsersList');
    Route::post('changeStatus', 'AdminUserController@ChangeStatus');
    Route::post('changeUser', 'AdminUserController@ChangeUser');
    Route::post('addUserComment', 'AdminUserController@AddUserComment');
    Route::get('getcomment/{id}', 'AdminUserController@getComment');
});

Route::prefix('permission')->middleware('masterAuth')->group(function() {
	Route::get('/', 'AdminUserRoleController@index')->name('permission');
	Route::post('changeUserRole', 'AdminUserRoleController@changeUserRole');
	Route::post('updatepermission', 'AdminUserRoleController@updatepermission');
});

Route::prefix('renewal')->middleware('adminauth')->group(function() {
	Route::get('/', 'RenewalController@index')->name('renewal');
	Route::post('/list', 'RenewalController@list');
	Route::post('/getBusinessComment', 'RenewalController@getBusinessComment');
	Route::post('/addBusinessComment', 'RenewalController@addBusinessComment');
	Route::post('/getPurchaseHistory', 'RenewalController@getPurchaseHistory');
});

Route::prefix('frame')->middleware('adminauth')->group(function() {
	Route::get('/', 'FrameController@index')->name('frame');
	Route::post('/list', 'FrameController@list');
});

Route::prefix('group')->middleware('adminauth')->group(function() {
	Route::get('/', 'GroupController@index')->name('group');
	Route::post('/list', 'GroupController@list');
	Route::post('/store', 'GroupController@store');
	Route::post('/edit', 'GroupController@edit');
	Route::post('/update', 'GroupController@update');
	Route::post('/delete', 'GroupController@delete');
});

Route::prefix('withdraw-request')->middleware('adminauth')->group(function() {
	Route::get('/', 'ReferralController@index')->name('withdrawRequest');
	Route::get('/getPendingRequest', 'ReferralController@getPendingRequest');
	Route::get('/getCompletedRequest', 'ReferralController@getCompletedRequest');
	Route::post('/completePayment', 'ReferralController@completePayment');
});

Route::prefix('download-limit')->middleware('adminauth')->group(function() {
	Route::get('/', 'DownloadLimitController@index')->name('downloadLimit');
	Route::post('/update', 'DownloadLimitController@update');
});

Route::prefix('bg-remove-request')->middleware('adminauth')->group(function() {
	Route::get('/', 'BGRemoveRequestController@index')->name('bgRemoveRequest');
	Route::get('/list', 'BGRemoveRequestController@list')->name('bg-request-list');
	Route::post('/remove', 'BGRemoveRequestController@remove')->name('bg-request-remove');
});
