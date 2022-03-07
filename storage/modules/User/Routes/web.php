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

Route::prefix('popup')->middleware('auth','adminauth')->group(function() {
  	Route::get('/', 'PopupDataController@index')->name('popup');
  	Route::get('/getPopup', 'PopupDataController@getPopup');
  	Route::post('/addPopup', 'PopupDataController@addPopup');
  	Route::post('/editPopup', 'PopupDataController@editPopup');
  	Route::post('/updatePopup', 'PopupDataController@updatePopup');
  	Route::post('/deletePopup', 'PopupDataController@deletePopup');
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
		return view("user::allpost");
	})->name('allpost');
	
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
    Route::get('viewuserslist', 'AdminUserController@getUsersList');
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