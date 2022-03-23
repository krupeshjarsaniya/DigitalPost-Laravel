<?php

use Illuminate\Http\Request;

Route::post('getInstagramAccount', 'UserapiControllerV13@getInstagramAccount');

Route::post('sendLoginOTP', 'UserapiControllerV13@sendLoginOTP');

Route::post('login', 'UserapiControllerV13@login');

Route::post('sendRegisterOTP', 'UserapiControllerV13@sendRegisterOTP');

Route::post('register', 'UserapiControllerV13@register');

Route::any('logout', 'UserapiControllerV13@logout');

Route::any('update_device_token', 'UserapiControllerV13@updateDeviceToken');

Route::post('checkmobile', 'UserapiControllerV13@checkMobile');

Route::post('getmyprofile', 'UserapiControllerV13@getMyProfile');

Route::post('editmyprofile', 'UserapiControllerV13@editMyProfile');

Route::post('addbusiness', 'UserapiControllerV13@addBusiness');

Route::post('updatebusiness', 'UserapiControllerV13@updateBusiness');

Route::post('getmyallbusiness', 'UserapiControllerV13@getmyallbusiness');

Route::post('removemybusiness', 'UserapiControllerV13@removeMyBusiness');

//Route::post('gethomepage', 'UserapiControllerV13@getthisMonthsFestival');
Route::post('gethomepage', 'UserapiControllerV13@getHomePage');

Route::post('getdays', 'UserapiControllerV13@getDays');

Route::post('getfestivalimages', 'UserapiControllerV13@getMonthsPost');

Route::post('purchaseplan', 'UserapiControllerV13@purchasePlan');

Route::post('cencalplan', 'UserapiControllerV13@cencalPurchasedPlan');

Route::post('getmypurchaseplan', 'UserapiControllerV13@getMyPurchasePlanList');

Route::post('savephotos', 'UserapiControllerV13@savePhotos');

Route::post('getphotos', 'UserapiControllerV13@getPhotos');

Route::post('markascurrentbusiness', 'UserapiControllerV13@markascurrentbusiness');

Route::post('getmycurrentbusiness', 'UserapiControllerV13@getcurrntbusinesspreornot');


Route::post('getTemplates', 'UserapiControllerV13@getTemplates');

Route::post('testplan', 'UserapiControllerV13@testplan');

Route::post('setpreference', 'UserapiControllerV13@savePreference');

Route::get('getcustomcategorypost', 'UserapiControllerV13@getCustomCategoryPost');

Route::post('getCustomCategoryImages', 'UserapiControllerV13@getCustomCategoryImages');

Route::post('getVideoPosts', 'UserapiControllerV13@getVideoPosts');

Route::post('getBusinessCategory', 'UserapiControllerV13@getBusinessCategory');

Route::post('getAllVideoPosts', 'UserapiControllerV13@getAllVideoPosts');

Route::post('getAdvetisement', 'UserapiControllerV13@getAdvetisement');

Route::post('getLanguageVideo', 'UserapiControllerV13@getLanguageVideo');

Route::post('getLanguage', 'UserapiControllerV13@getLanguage');

Route::post('getLanguagePost', 'UserapiControllerV13@getLanguagePost');

Route::post('getCustomCategoryPosts', 'UserapiControllerV13@getCustomCategoryPosts');

Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV13@getLanguageCustomeCategoryPost');

Route::post('GetAllFestivalVideo', 'UserapiControllerV13@GetAllFestivalVideo');

Route::post('plans', 'UserapiControllerV13@Plans');

Route::post('getBusinessCategoryImages', 'UserapiControllerV13@getBusinessCategoryImages');

Route::post('CurrntbusinessPhoto', 'UserapiControllerV13@CurrntbusinessPhoto');

Route::post('newCategoryAllImage', 'UserapiControllerV13@newCategoryAllImage');

Route::post('getLanguageWithImage', 'UserapiControllerV13@getLanguageWithImage');

Route::post('SetUserLanguage', 'UserapiControllerV13@SetUserLanguage');

Route::post('SocialLogins', 'UserapiControllerV13@SocialLogins');

Route::post('SocialLoginPages', 'UserapiControllerV13@getSocialLoginPages');

Route::post('SocialLoginsLinkedInPage', 'UserapiControllerV13@SocialLoginsLinkedInPage');
Route::post('SocialLoginsFacebookPage', 'UserapiControllerV13@SocialLoginsFacebookPage');

Route::post('RemoveSocialProfile', 'UserapiControllerV13@removeSocialProfile');

Route::post('removeSocialPageLinkedIn', 'UserapiControllerV13@removeSocialPageLinkedIn');

Route::post('getLinkedAccounts', 'UserapiControllerV13@getLinkedAccounts');

Route::post('getScheduledPost', 'UserapiControllerV13@getScheduledPost');

Route::post('getScheduledHistory', 'UserapiControllerV13@getScheduledHistory');

Route::post('schedulePost', 'UserapiControllerV13@schedulePost');

Route::post('reSchedulePost', 'UserapiControllerV13@reSchedulePost');

Route::post('removeSchedulePost', 'UserapiControllerV13@removeSchedulePost');

Route::post('sharePost', 'UserapiControllerV13@sharePost');


// ======================= Political Section
Route::get('getPoliticalCategory', 'UserapiControllerV13@getPoliticalCategory');

Route::post('addPoliticalBusiness', 'UserapiControllerV13@addPoliticalBusiness');

Route::post('updatePoliticalbusiness', 'UserapiControllerV13@updatePoliticalbusiness');

Route::post('removePoliticalBusiness', 'UserapiControllerV13@removePoliticalBusiness');

Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV13@getmyAllPoliticalBusinessList');

Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV13@markCurrentBusinessForPolitic');

Route::get('GetAllBusinessCategory', 'UserapiControllerV13@GetAllBusinessCategory');

Route::get('getStickerCategory', 'UserapiControllerV13@getStickerCategory');

Route::get('getBackgroundCategory', 'UserapiControllerV13@getBackgroundCategory');

Route::post('getBackground', 'UserapiControllerV13@getBackground');

Route::post('getGraphic', 'UserapiControllerV13@getGraphic');

Route::post('getSticker', 'UserapiControllerV13@getSticker');

Route::get('generatePDF', 'UserapiControllerV13@generatePDF');

// ======================= Referral Section
Route::post('generateReferralLink', 'UserapiControllerV13@generateReferralLink');
Route::post('getReferralData', 'UserapiControllerV13@getReferralData');
Route::post('withdrawRequest', 'UserapiControllerV13@withdrawRequest');
Route::post('withdrawHistory', 'UserapiControllerV13@withdrawHistory');
Route::post('updatePaymentDetail', 'UserapiControllerV13@updatePaymentDetail');