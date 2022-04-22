<?php

use Illuminate\Http\Request;

Route::post('getInstagramAccount', 'UserapiControllerV14@getInstagramAccount');

Route::post('sendLoginOTP', 'UserapiControllerV14@sendLoginOTP');

Route::post('login', 'UserapiControllerV14@login');

Route::post('sendRegisterOTP', 'UserapiControllerV14@sendRegisterOTP');

Route::post('register', 'UserapiControllerV14@register');

Route::any('logout', 'UserapiControllerV14@logout');

Route::any('update_device_token', 'UserapiControllerV14@updateDeviceToken');

Route::post('checkmobile', 'UserapiControllerV14@checkMobile');

Route::post('getmyprofile', 'UserapiControllerV14@getMyProfile');

Route::post('editmyprofile', 'UserapiControllerV14@editMyProfile');

Route::post('addbusiness', 'UserapiControllerV14@addBusiness');

Route::post('updatebusiness', 'UserapiControllerV14@updateBusiness');

Route::post('getmyallbusiness', 'UserapiControllerV14@getmyallbusiness');

Route::post('removemybusiness', 'UserapiControllerV14@removeMyBusiness');

//Route::post('gethomepage', 'UserapiControllerV14@getthisMonthsFestival');
Route::post('gethomepage', 'UserapiControllerV14@getHomePage');

Route::post('getdays', 'UserapiControllerV14@getDays');

Route::post('getfestivalimages', 'UserapiControllerV14@getMonthsPost');

Route::post('purchaseplan', 'UserapiControllerV14@purchasePlan');

Route::post('cencalplan', 'UserapiControllerV14@cencalPurchasedPlan');

Route::post('getmypurchaseplan', 'UserapiControllerV14@getMyPurchasePlanList');

Route::post('savephotos', 'UserapiControllerV14@savePhotos');

Route::post('getphotos', 'UserapiControllerV14@getPhotos');

Route::post('markascurrentbusiness', 'UserapiControllerV14@markascurrentbusiness');

Route::post('getmycurrentbusiness', 'UserapiControllerV14@getcurrntbusinesspreornot');


Route::post('getTemplates', 'UserapiControllerV14@getTemplates');

Route::post('testplan', 'UserapiControllerV14@testplan');

Route::post('setpreference', 'UserapiControllerV14@savePreference');

Route::get('getcustomcategorypost', 'UserapiControllerV14@getCustomCategoryPost');

Route::post('getCustomCategoryImages', 'UserapiControllerV14@getCustomCategoryImages');

Route::post('getVideoPosts', 'UserapiControllerV14@getVideoPosts');

Route::post('getBusinessCategory', 'UserapiControllerV14@getBusinessCategory');

Route::post('getAllVideoPosts', 'UserapiControllerV14@getAllVideoPosts');

Route::post('getAdvetisement', 'UserapiControllerV14@getAdvetisement');

Route::post('getLanguageVideo', 'UserapiControllerV14@getLanguageVideo');

Route::post('getLanguage', 'UserapiControllerV14@getLanguage');

Route::post('getLanguagePost', 'UserapiControllerV14@getLanguagePost');

Route::post('getCustomCategoryPosts', 'UserapiControllerV14@getCustomCategoryPosts');

Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV14@getLanguageCustomeCategoryPost');

Route::post('GetAllFestivalVideo', 'UserapiControllerV14@GetAllFestivalVideo');

Route::post('plans', 'UserapiControllerV14@Plans');

Route::post('getBusinessCategoryImages', 'UserapiControllerV14@getBusinessCategoryImages');

Route::post('CurrntbusinessPhoto', 'UserapiControllerV14@CurrntbusinessPhoto');

Route::post('newCategoryAllImage', 'UserapiControllerV14@newCategoryAllImage');

Route::post('getLanguageWithImage', 'UserapiControllerV14@getLanguageWithImage');

Route::post('SetUserLanguage', 'UserapiControllerV14@SetUserLanguage');

Route::post('SocialLogins', 'UserapiControllerV14@SocialLogins');

Route::post('SocialLoginPages', 'UserapiControllerV14@getSocialLoginPages');

Route::post('SocialLoginsLinkedInPage', 'UserapiControllerV14@SocialLoginsLinkedInPage');
Route::post('SocialLoginsFacebookPage', 'UserapiControllerV14@SocialLoginsFacebookPage');

Route::post('RemoveSocialProfile', 'UserapiControllerV14@removeSocialProfile');

Route::post('removeSocialPageLinkedIn', 'UserapiControllerV14@removeSocialPageLinkedIn');

Route::post('removeSocialPageFacebook', 'UserapiControllerV14@removeSocialPageFacebook');

Route::post('getLinkedAccounts', 'UserapiControllerV14@getLinkedAccounts');

Route::post('getScheduledPost', 'UserapiControllerV14@getScheduledPost');

Route::post('getScheduledHistory', 'UserapiControllerV14@getScheduledHistory');

Route::post('schedulePost', 'UserapiControllerV14@schedulePost');

Route::post('reSchedulePost', 'UserapiControllerV14@reSchedulePost');

Route::post('removeSchedulePost', 'UserapiControllerV14@removeSchedulePost');

Route::post('sharePost', 'UserapiControllerV14@sharePost');


// ======================= Political Section
Route::get('getPoliticalCategory', 'UserapiControllerV14@getPoliticalCategory');

Route::post('addPoliticalBusiness', 'UserapiControllerV14@addPoliticalBusiness');

Route::post('updatePoliticalbusiness', 'UserapiControllerV14@updatePoliticalbusiness');

Route::post('removePoliticalBusiness', 'UserapiControllerV14@removePoliticalBusiness');

Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV14@getmyAllPoliticalBusinessList');

Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV14@markCurrentBusinessForPolitic');

Route::get('GetAllBusinessCategory', 'UserapiControllerV14@GetAllBusinessCategory');

Route::get('getStickerCategory', 'UserapiControllerV14@getStickerCategory');

Route::get('getBackgroundCategory', 'UserapiControllerV14@getBackgroundCategory');

Route::post('getBackground', 'UserapiControllerV14@getBackground');

Route::post('getGraphic', 'UserapiControllerV14@getGraphic');

Route::post('getSticker', 'UserapiControllerV14@getSticker');

Route::post('getFrames', 'UserapiControllerV14@getFrames');

Route::get('generatePDF', 'UserapiControllerV14@generatePDF');

// ======================= Referral Section
Route::post('generateReferralLink', 'UserapiControllerV14@generateReferralLink');
Route::post('getReferralData', 'UserapiControllerV14@getReferralData');
Route::post('withdrawRequest', 'UserapiControllerV14@withdrawRequest');
Route::post('withdrawHistory', 'UserapiControllerV14@withdrawHistory');
Route::post('updatePaymentDetail', 'UserapiControllerV14@updatePaymentDetail');
