<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/userapi', function (Request $request) {
//     return $request->user();

// });
Route::prefix('userapi')->group(function() {

	Route::post('login', 'UserapiController@login');

    Route::any('register', 'UserapiController@register');

    Route::any('logout', 'UserapiController@logout');
    
    Route::post('checkmobile', 'UserapiController@checkMobile');

    Route::post('getmyprofile', 'UserapiController@getMyProfile');

    Route::post('editmyprofile', 'UserapiController@editMyProfile');

    Route::post('addbusiness', 'UserapiController@addBusiness');

    Route::post('updatebusiness', 'UserapiController@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiController@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiController@removeMyBusiness');

    Route::post('gethomepage', 'UserapiController@getthisMonthsFestival');

    Route::post('getdays', 'UserapiController@getDays');

    Route::post('getfestivalimages', 'UserapiController@getMonthsPost');

    Route::post('purchaseplan', 'UserapiController@purchasePlan');

    Route::post('cencalplan', 'UserapiController@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiController@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiController@savePhotos');

    Route::post('getphotos', 'UserapiController@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiController@markascurrentbusiness');
    
     Route::post('getmycurrentbusiness', 'UserapiController@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiController@getTemplates');

    Route::post('testplan', 'UserapiController@testplan');

    Route::post('setpreference', 'UserapiController@savePreference');

    Route::get('getcustomcategorypost', 'UserapiController@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiController@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiController@getVideoPosts');

});

//  Version V2

    Route::prefix('userapi/v2')->group(function() {

        Route::post('login', 'UserapiControllerV2@login');

        Route::any('register', 'UserapiControllerV2@register');

        Route::any('logout', 'UserapiControllerV2@logout');
        
        Route::post('checkmobile', 'UserapiControllerV2@checkMobile');

        Route::post('getmyprofile', 'UserapiControllerV2@getMyProfile');

        Route::post('editmyprofile', 'UserapiControllerV2@editMyProfile');

        Route::post('addbusiness', 'UserapiControllerV2@addBusiness');

        Route::post('updatebusiness', 'UserapiControllerV2@updateBusiness');

        Route::post('getmyallbusiness', 'UserapiControllerV2@getmyallbusiness');

        Route::post('removemybusiness', 'UserapiControllerV2@removeMyBusiness');

        Route::post('gethomepage', 'UserapiControllerV2@getthisMonthsFestival');

        Route::post('getdays', 'UserapiControllerV2@getDays');

        Route::post('getfestivalimages', 'UserapiControllerV2@getMonthsPost');

        Route::post('purchaseplan', 'UserapiControllerV2@purchasePlan');

        Route::post('cencalplan', 'UserapiControllerV2@cencalPurchasedPlan');

        Route::post('getmypurchaseplan', 'UserapiControllerV2@getMyPurchasePlanList');
        
        Route::post('savephotos', 'UserapiControllerV2@savePhotos');

        Route::post('getphotos', 'UserapiControllerV2@getPhotos');
        
        Route::post('markascurrentbusiness', 'UserapiControllerV2@markascurrentbusiness');
        
        Route::post('getmycurrentbusiness', 'UserapiControllerV2@getcurrntbusinesspreornot');
        
        
        Route::post('getTemplates', 'UserapiControllerV2@getTemplates');

        Route::post('testplan', 'UserapiControllerV2@testplan');

        Route::post('setpreference', 'UserapiControllerV2@savePreference');

        Route::get('getcustomcategorypost', 'UserapiControllerV2@getCustomCategoryPost');

        Route::post('getCustomCategoryImages', 'UserapiControllerV2@getCustomCategoryImages');

        Route::post('getVideoPosts', 'UserapiControllerV2@getVideoPosts');


    });

// End V2 Version

//  Version V3

Route::prefix('userapi/v3')->group(function() {

    Route::post('login', 'UserapiControllerV3@login');

    Route::any('register', 'UserapiControllerV3@register');

    Route::any('logout', 'UserapiControllerV3@logout');
    
    Route::post('checkmobile', 'UserapiControllerV3@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV3@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV3@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV3@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV3@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV3@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV3@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV3@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV3@getHomePage');

    Route::post('getdays', 'UserapiControllerV3@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV3@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV3@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV3@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV3@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV3@savePhotos');

    Route::post('getphotos', 'UserapiControllerV3@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV3@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV3@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV3@getTemplates');

    Route::post('testplan', 'UserapiControllerV3@testplan');

    Route::post('setpreference', 'UserapiControllerV3@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV3@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV3@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV3@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV3@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV3@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV3@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV3@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV3@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV3@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV3@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV3@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV3@GetAllFestivalVideo');
    
    Route::get('plans', 'UserapiControllerV3@Plans');
    

});

// End V3 Version

//version v4
Route::get('userapi/apilist', 'UserapiControllerV4@apilist');

Route::prefix('userapi/v4')->group(function() {

    Route::post('login', 'UserapiControllerV4@login');

    Route::any('register', 'UserapiControllerV4@register');

    Route::any('logout', 'UserapiControllerV4@logout');
    
    Route::post('checkmobile', 'UserapiControllerV4@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV4@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV4@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV4@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV4@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV4@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV4@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV4@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV4@getHomePage');

    Route::post('getdays', 'UserapiControllerV4@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV4@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV4@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV4@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV4@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV4@savePhotos');

    Route::post('getphotos', 'UserapiControllerV4@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV4@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV4@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV4@getTemplates');

    Route::post('testplan', 'UserapiControllerV4@testplan');

    Route::post('setpreference', 'UserapiControllerV4@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV4@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV4@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV4@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV4@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV4@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV4@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV4@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV4@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV4@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV4@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV4@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV4@GetAllFestivalVideo');
    
    Route::get('plans', 'UserapiControllerV4@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV4@getBusinessCategoryImages');


});

//endversion v4

//version v5

Route::prefix('userapi/v5')->group(function() {

    Route::post('login', 'UserapiControllerV5@login');

    Route::any('register', 'UserapiControllerV5@register');

    Route::any('logout', 'UserapiControllerV5@logout');
    
    Route::post('checkmobile', 'UserapiControllerV5@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV5@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV5@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV5@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV5@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV5@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV5@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV5@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV5@getHomePage');

    Route::post('getdays', 'UserapiControllerV5@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV5@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV5@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV5@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV5@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV5@savePhotos');

    Route::post('getphotos', 'UserapiControllerV5@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV5@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV5@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV5@getTemplates');

    Route::post('testplan', 'UserapiControllerV5@testplan');

    Route::post('setpreference', 'UserapiControllerV5@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV5@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV5@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV5@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV5@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV5@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV5@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV5@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV5@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV5@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV5@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV5@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV5@GetAllFestivalVideo');
    
    Route::get('plans', 'UserapiControllerV5@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV5@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV5@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV5@newCategoryAllImage');


});

//endversion v5


//version v6

Route::prefix('userapi/v6')->group(function() {

    Route::post('login', 'UserapiControllerV6@login');

    Route::any('register', 'UserapiControllerV6@register');

    Route::any('logout', 'UserapiControllerV6@logout');
    
    Route::post('checkmobile', 'UserapiControllerV6@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV6@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV6@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV6@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV6@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV6@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV6@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV6@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV6@getHomePage');

    Route::post('getdays', 'UserapiControllerV6@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV6@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV6@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV6@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV6@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV6@savePhotos');

    Route::post('getphotos', 'UserapiControllerV6@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV6@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV6@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV6@getTemplates');

    Route::post('testplan', 'UserapiControllerV6@testplan');

    Route::post('setpreference', 'UserapiControllerV6@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV6@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV6@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV6@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV6@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV6@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV6@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV6@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV6@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV6@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV6@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV6@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV6@GetAllFestivalVideo');
    
    Route::get('plans', 'UserapiControllerV6@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV6@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV6@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV6@newCategoryAllImage');
    Route::post('SocialLogins', 'UserapiControllerV6@SocialLogins');
    Route::post('getLanguageWithImage', 'UserapiControllerV6@getLanguageWithImage');
    Route::post('SetUserLanguage', 'UserapiControllerV6@SetUserLanguage');


});

//endversion v6

//version v7

Route::prefix('userapi/v7')->group(function() {

    Route::post('login', 'UserapiControllerV7@login');

    Route::any('register', 'UserapiControllerV7@register');

    Route::any('logout', 'UserapiControllerV7@logout');
    
    Route::post('checkmobile', 'UserapiControllerV7@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV7@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV7@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV7@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV7@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV7@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV7@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV7@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV7@getHomePage');

    Route::post('getdays', 'UserapiControllerV7@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV7@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV7@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV7@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV7@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV7@savePhotos');

    Route::post('getphotos', 'UserapiControllerV7@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV7@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV7@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV7@getTemplates');

    Route::post('testplan', 'UserapiControllerV7@testplan');

    Route::post('setpreference', 'UserapiControllerV7@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV7@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV7@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV7@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV7@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV7@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV7@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV7@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV7@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV7@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV7@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV7@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV7@GetAllFestivalVideo');
    
    Route::post('plans', 'UserapiControllerV7@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV7@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV7@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV7@newCategoryAllImage');
    Route::post('SocialLogins', 'UserapiControllerV7@SocialLogins');
    Route::post('getLanguageWithImage', 'UserapiControllerV7@getLanguageWithImage');
    Route::post('SetUserLanguage', 'UserapiControllerV7@SetUserLanguage');

    Route::post('schedulePost', 'UserapiControllerV7@schedulePost');

    Route::post('reSchedulePost', 'UserapiControllerV7@reSchedulePost');

    Route::post('getScheduledPost', 'UserapiControllerV7@getScheduledPost');

    Route::post('removeSchedulePost', 'UserapiControllerV7@removeSchedulePost');
    
    Route::post('sharePost', 'UserapiControllerV7@sharePost');


    // ======================= Political Section
    Route::get('getPoliticalCategory', 'UserapiControllerV7@getPoliticalCategory');

    Route::post('addPoliticalBusiness', 'UserapiControllerV7@addPoliticalBusiness');

    Route::post('updatePoliticalbusiness', 'UserapiControllerV7@updatePoliticalbusiness');

    Route::post('removePoliticalBusiness', 'UserapiControllerV7@removePoliticalBusiness');

    Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV7@getmyAllPoliticalBusinessList');

    Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV7@markCurrentBusinessForPolitic');

    Route::get('GetAllBusinessCategory', 'UserapiControllerV7@GetAllBusinessCategory');



});

//version v8

Route::prefix('userapi/v8')->group(function() {

    Route::post('login', 'UserapiControllerV8@login');

    Route::any('register', 'UserapiControllerV8@register');

    Route::any('logout', 'UserapiControllerV8@logout');
    
    Route::post('checkmobile', 'UserapiControllerV8@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV8@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV8@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV8@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV8@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV8@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV8@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV8@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV8@getHomePage');

    Route::post('getdays', 'UserapiControllerV8@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV8@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV8@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV8@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV8@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV8@savePhotos');

    Route::post('getphotos', 'UserapiControllerV8@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV8@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV8@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV8@getTemplates');

    Route::post('testplan', 'UserapiControllerV8@testplan');

    Route::post('setpreference', 'UserapiControllerV8@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV8@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV8@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV8@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV8@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV8@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV8@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV8@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV8@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV8@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV8@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV8@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV8@GetAllFestivalVideo');
    
    Route::post('plans', 'UserapiControllerV8@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV8@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV8@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV8@newCategoryAllImage');
    Route::post('SocialLogins', 'UserapiControllerV8@SocialLogins');
    Route::post('getLanguageWithImage', 'UserapiControllerV8@getLanguageWithImage');
    Route::post('SetUserLanguage', 'UserapiControllerV8@SetUserLanguage');

    Route::post('schedulePost', 'UserapiControllerV8@schedulePost');

    Route::post('reSchedulePost', 'UserapiControllerV8@reSchedulePost');

    Route::post('getScheduledPost', 'UserapiControllerV8@getScheduledPost');

    Route::post('removeSchedulePost', 'UserapiControllerV8@removeSchedulePost');
    
    Route::post('sharePost', 'UserapiControllerV8@sharePost');


    // ======================= Political Section
    Route::get('getPoliticalCategory', 'UserapiControllerV8@getPoliticalCategory');

    Route::post('addPoliticalBusiness', 'UserapiControllerV8@addPoliticalBusiness');

    Route::post('updatePoliticalbusiness', 'UserapiControllerV8@updatePoliticalbusiness');

    Route::post('removePoliticalBusiness', 'UserapiControllerV8@removePoliticalBusiness');

    Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV8@getmyAllPoliticalBusinessList');

    Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV8@markCurrentBusinessForPolitic');

    Route::get('GetAllBusinessCategory', 'UserapiControllerV8@GetAllBusinessCategory');



});


//version v9

Route::prefix('userapi/v9')->group(function() {

    Route::post('sendLoginOTP', 'UserapiControllerV9@sendLoginOTP');
    
    Route::post('login', 'UserapiControllerV9@login');

    Route::post('sendRegisterOTP', 'UserapiControllerV9@sendRegisterOTP');

    Route::post('register', 'UserapiControllerV9@register');

    Route::any('logout', 'UserapiControllerV9@logout');
    
    Route::post('checkmobile', 'UserapiControllerV9@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV9@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV9@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV9@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV9@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV9@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV9@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV9@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV9@getHomePage');

    Route::post('getdays', 'UserapiControllerV9@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV9@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV9@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV9@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV9@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV9@savePhotos');

    Route::post('getphotos', 'UserapiControllerV9@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV9@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV9@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV9@getTemplates');

    Route::post('testplan', 'UserapiControllerV9@testplan');

    Route::post('setpreference', 'UserapiControllerV9@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV9@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV9@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV9@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV9@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV9@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV9@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV9@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV9@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV9@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV9@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV9@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV9@GetAllFestivalVideo');
    
    Route::post('plans', 'UserapiControllerV9@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV9@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV9@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV9@newCategoryAllImage');
    Route::post('SocialLogins', 'UserapiControllerV9@SocialLogins');
    Route::post('getLanguageWithImage', 'UserapiControllerV9@getLanguageWithImage');
    Route::post('SetUserLanguage', 'UserapiControllerV9@SetUserLanguage');

    Route::post('schedulePost', 'UserapiControllerV9@schedulePost');

    Route::post('reSchedulePost', 'UserapiControllerV9@reSchedulePost');

    Route::post('getScheduledPost', 'UserapiControllerV9@getScheduledPost');

    Route::post('removeSchedulePost', 'UserapiControllerV9@removeSchedulePost');
    
    Route::post('sharePost', 'UserapiControllerV9@sharePost');


    // ======================= Political Section
    Route::get('getPoliticalCategory', 'UserapiControllerV9@getPoliticalCategory');

    Route::post('addPoliticalBusiness', 'UserapiControllerV9@addPoliticalBusiness');

    Route::post('updatePoliticalbusiness', 'UserapiControllerV9@updatePoliticalbusiness');

    Route::post('removePoliticalBusiness', 'UserapiControllerV9@removePoliticalBusiness');

    Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV9@getmyAllPoliticalBusinessList');

    Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV9@markCurrentBusinessForPolitic');

    Route::get('GetAllBusinessCategory', 'UserapiControllerV9@GetAllBusinessCategory');



});



//version v10

Route::prefix('userapi/v10')->group(function() {

    Route::post('sendLoginOTP', 'UserapiControllerV10@sendLoginOTP');
    
    Route::post('login', 'UserapiControllerV10@login');

    Route::post('sendRegisterOTP', 'UserapiControllerV10@sendRegisterOTP');

    Route::post('register', 'UserapiControllerV10@register');

    Route::any('logout', 'UserapiControllerV10@logout');
    
    Route::post('checkmobile', 'UserapiControllerV10@checkMobile');

    Route::post('getmyprofile', 'UserapiControllerV10@getMyProfile');

    Route::post('editmyprofile', 'UserapiControllerV10@editMyProfile');

    Route::post('addbusiness', 'UserapiControllerV10@addBusiness');

    Route::post('updatebusiness', 'UserapiControllerV10@updateBusiness');

    Route::post('getmyallbusiness', 'UserapiControllerV10@getmyallbusiness');

    Route::post('removemybusiness', 'UserapiControllerV10@removeMyBusiness');

    //Route::post('gethomepage', 'UserapiControllerV10@getthisMonthsFestival');
    Route::post('gethomepage', 'UserapiControllerV10@getHomePage');

    Route::post('getdays', 'UserapiControllerV10@getDays');

    Route::post('getfestivalimages', 'UserapiControllerV10@getMonthsPost');

    Route::post('purchaseplan', 'UserapiControllerV10@purchasePlan');

    Route::post('cencalplan', 'UserapiControllerV10@cencalPurchasedPlan');

    Route::post('getmypurchaseplan', 'UserapiControllerV10@getMyPurchasePlanList');
    
    Route::post('savephotos', 'UserapiControllerV10@savePhotos');

    Route::post('getphotos', 'UserapiControllerV10@getPhotos');
    
    Route::post('markascurrentbusiness', 'UserapiControllerV10@markascurrentbusiness');
    
    Route::post('getmycurrentbusiness', 'UserapiControllerV10@getcurrntbusinesspreornot');
    
    
    Route::post('getTemplates', 'UserapiControllerV10@getTemplates');

    Route::post('testplan', 'UserapiControllerV10@testplan');

    Route::post('setpreference', 'UserapiControllerV10@savePreference');

    Route::get('getcustomcategorypost', 'UserapiControllerV10@getCustomCategoryPost');

    Route::post('getCustomCategoryImages', 'UserapiControllerV10@getCustomCategoryImages');

    Route::post('getVideoPosts', 'UserapiControllerV10@getVideoPosts');
    
    Route::post('getBusinessCategory', 'UserapiControllerV10@getBusinessCategory');

    Route::post('getAllVideoPosts', 'UserapiControllerV10@getAllVideoPosts');
    
    Route::post('getAdvetisement', 'UserapiControllerV10@getAdvetisement');
    
    Route::post('getLanguageVideo', 'UserapiControllerV10@getLanguageVideo');
    
    Route::post('getLanguage', 'UserapiControllerV10@getLanguage');

    Route::post('getLanguagePost', 'UserapiControllerV10@getLanguagePost');
    
    Route::post('getCustomCategoryPosts', 'UserapiControllerV10@getCustomCategoryPosts');
    
    Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV10@getLanguageCustomeCategoryPost');
    
    Route::post('GetAllFestivalVideo', 'UserapiControllerV10@GetAllFestivalVideo');
    
    Route::post('plans', 'UserapiControllerV10@Plans');
    
    Route::post('getBusinessCategoryImages', 'UserapiControllerV10@getBusinessCategoryImages');
    
    Route::post('CurrntbusinessPhoto', 'UserapiControllerV10@CurrntbusinessPhoto');
    
    Route::post('newCategoryAllImage', 'UserapiControllerV10@newCategoryAllImage');
    Route::post('SocialLogins', 'UserapiControllerV10@SocialLogins');
    Route::post('getLanguageWithImage', 'UserapiControllerV10@getLanguageWithImage');
    Route::post('SetUserLanguage', 'UserapiControllerV10@SetUserLanguage');

    Route::post('schedulePost', 'UserapiControllerV10@schedulePost');

    Route::post('reSchedulePost', 'UserapiControllerV10@reSchedulePost');

    Route::post('getScheduledPost', 'UserapiControllerV10@getScheduledPost');

    Route::post('removeSchedulePost', 'UserapiControllerV10@removeSchedulePost');
    
    Route::post('sharePost', 'UserapiControllerV10@sharePost');


    // ======================= Political Section
    Route::get('getPoliticalCategory', 'UserapiControllerV10@getPoliticalCategory');

    Route::post('addPoliticalBusiness', 'UserapiControllerV10@addPoliticalBusiness');

    Route::post('updatePoliticalbusiness', 'UserapiControllerV10@updatePoliticalbusiness');

    Route::post('removePoliticalBusiness', 'UserapiControllerV10@removePoliticalBusiness');

    Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV10@getmyAllPoliticalBusinessList');

    Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV10@markCurrentBusinessForPolitic');

    Route::get('GetAllBusinessCategory', 'UserapiControllerV10@GetAllBusinessCategory');

    Route::get('getStickerCategory', 'UserapiControllerV10@getStickerCategory');

    Route::get('getBackgroundCategory', 'UserapiControllerV10@getBackgroundCategory');

    Route::post('getBackground', 'UserapiControllerV10@getBackground');

    Route::post('getSticker', 'UserapiControllerV10@getSticker');



});