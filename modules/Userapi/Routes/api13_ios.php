<?php

use Illuminate\Http\Request;

Route::post('sendLoginOTP', 'UserapiControllerV13IOS@sendLoginOTP');

Route::post('login', 'UserapiControllerV13IOS@login');

Route::post('sendRegisterOTP', 'UserapiControllerV13IOS@sendRegisterOTP');

Route::post('register', 'UserapiControllerV13IOS@register');

Route::any('logout', 'UserapiControllerV13IOS@logout');

Route::any('update_device_token', 'UserapiControllerV13IOS@updateDeviceToken');

Route::post('checkmobile', 'UserapiControllerV13IOS@checkMobile');

Route::post('getmyprofile', 'UserapiControllerV13IOS@getMyProfile');

Route::post('editmyprofile', 'UserapiControllerV13IOS@editMyProfile');

Route::post('addbusiness', 'UserapiControllerV13IOS@addBusiness');

Route::post('updatebusiness', 'UserapiControllerV13IOS@updateBusiness');

Route::post('getmyallbusiness', 'UserapiControllerV13IOS@getmyallbusiness');

Route::post('removemybusiness', 'UserapiControllerV13IOS@removeMyBusiness');

//Route::post('gethomepage', 'UserapiControllerV13IOS@getthisMonthsFestival');
Route::post('gethomepage', 'UserapiControllerV13IOS@getHomePage');

Route::post('getdays', 'UserapiControllerV13IOS@getDays');

Route::post('getfestivalimages', 'UserapiControllerV13IOS@getMonthsPost');

Route::post('purchaseplan', 'UserapiControllerV13IOS@purchasePlan');

Route::post('cencalplan', 'UserapiControllerV13IOS@cencalPurchasedPlan');

Route::post('getmypurchaseplan', 'UserapiControllerV13IOS@getMyPurchasePlanList');

Route::post('savephotos', 'UserapiControllerV13IOS@savePhotos');

Route::post('getphotos', 'UserapiControllerV13IOS@getPhotos');

Route::post('markascurrentbusiness', 'UserapiControllerV13IOS@markascurrentbusiness');

Route::post('getmycurrentbusiness', 'UserapiControllerV13IOS@getcurrntbusinesspreornot');


Route::post('getTemplates', 'UserapiControllerV13IOS@getTemplates');

Route::post('testplan', 'UserapiControllerV13IOS@testplan');

Route::post('setpreference', 'UserapiControllerV13IOS@savePreference');

Route::get('getcustomcategorypost', 'UserapiControllerV13IOS@getCustomCategoryPost');

Route::post('getCustomCategoryImages', 'UserapiControllerV13IOS@getCustomCategoryImages');

Route::post('getVideoPosts', 'UserapiControllerV13IOS@getVideoPosts');

Route::post('getBusinessCategory', 'UserapiControllerV13IOS@getBusinessCategory');

Route::post('getAllVideoPosts', 'UserapiControllerV13IOS@getAllVideoPosts');

Route::post('getAdvetisement', 'UserapiControllerV13IOS@getAdvetisement');

Route::post('getLanguageVideo', 'UserapiControllerV13IOS@getLanguageVideo');

Route::post('getLanguage', 'UserapiControllerV13IOS@getLanguage');

Route::post('getLanguagePost', 'UserapiControllerV13IOS@getLanguagePost');

Route::post('getCustomCategoryPosts', 'UserapiControllerV13IOS@getCustomCategoryPosts');

Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV13IOS@getLanguageCustomeCategoryPost');

Route::post('GetAllFestivalVideo', 'UserapiControllerV13IOS@GetAllFestivalVideo');

Route::post('plans', 'UserapiControllerV13IOS@Plans');

Route::post('getBusinessCategoryImages', 'UserapiControllerV13IOS@getBusinessCategoryImages');

Route::post('CurrntbusinessPhoto', 'UserapiControllerV13IOS@CurrntbusinessPhoto');

Route::post('newCategoryAllImage', 'UserapiControllerV13IOS@newCategoryAllImage');

Route::post('getLanguageWithImage', 'UserapiControllerV13IOS@getLanguageWithImage');

Route::post('SetUserLanguage', 'UserapiControllerV13IOS@SetUserLanguage');

Route::post('SocialLogins', 'UserapiControllerV13IOS@SocialLogins');

Route::post('SocialLoginPages', 'UserapiControllerV13IOS@getSocialLoginPages');

Route::post('SocialLoginsLinkedInPage', 'UserapiControllerV13IOS@SocialLoginsLinkedInPage');
Route::post('SocialLoginsFacebookPage', 'UserapiControllerV13IOS@SocialLoginsFacebookPage');

Route::post('RemoveSocialProfile', 'UserapiControllerV13IOS@removeSocialProfile');

Route::post('removeSocialPageLinkedIn', 'UserapiControllerV13IOS@removeSocialPageLinkedIn');

Route::post('removeSocialPageFacebook', 'UserapiControllerV13IOS@removeSocialPageFacebook');

Route::post('getLinkedAccounts', 'UserapiControllerV13IOS@getLinkedAccounts');

Route::post('getScheduledPost', 'UserapiControllerV13IOS@getScheduledPost');

Route::post('getScheduledHistory', 'UserapiControllerV13IOS@getScheduledHistory');

Route::post('schedulePost', 'UserapiControllerV13IOS@schedulePost');

Route::post('reSchedulePost', 'UserapiControllerV13IOS@reSchedulePost');

Route::post('removeSchedulePost', 'UserapiControllerV13IOS@removeSchedulePost');

Route::post('sharePost', 'UserapiControllerV13IOS@sharePost');


// ======================= Political Section
Route::get('getPoliticalCategory', 'UserapiControllerV13IOS@getPoliticalCategory');

Route::post('addPoliticalBusiness', 'UserapiControllerV13IOS@addPoliticalBusiness');

Route::post('updatePoliticalbusiness', 'UserapiControllerV13IOS@updatePoliticalbusiness');

Route::post('removePoliticalBusiness', 'UserapiControllerV13IOS@removePoliticalBusiness');

Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV13IOS@getmyAllPoliticalBusinessList');

Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV13IOS@markCurrentBusinessForPolitic');

Route::get('GetAllBusinessCategory', 'UserapiControllerV13IOS@GetAllBusinessCategory');

Route::get('getStickerCategory', 'UserapiControllerV13IOS@getStickerCategory');

Route::get('getBackgroundCategory', 'UserapiControllerV13IOS@getBackgroundCategory');

Route::post('getBackground', 'UserapiControllerV13IOS@getBackground');

Route::post('getGraphic', 'UserapiControllerV13IOS@getGraphic');

Route::post('getSticker', 'UserapiControllerV13IOS@getSticker');

Route::get('generatePDF', 'UserapiControllerV13IOS@generatePDF');

// ======================= Referral Section
Route::post('generateReferralLink', 'UserapiControllerV13IOS@generateReferralLink');
Route::post('getReferralData', 'UserapiControllerV13IOS@getReferralData');
Route::post('withdrawRequest', 'UserapiControllerV13IOS@withdrawRequest');
Route::post('withdrawHistory', 'UserapiControllerV13IOS@withdrawHistory');
Route::post('updatePaymentDetail', 'UserapiControllerV13IOS@updatePaymentDetail');