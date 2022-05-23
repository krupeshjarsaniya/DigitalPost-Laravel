<?php

use Illuminate\Http\Request;

Route::post('getInstagramAccount', 'UserapiControllerV15@getInstagramAccount');

Route::post('sendLoginOTP', 'UserapiControllerV15@sendLoginOTP');

Route::post('login', 'UserapiControllerV15@login');

Route::post('sendRegisterOTP', 'UserapiControllerV15@sendRegisterOTP');

Route::post('register', 'UserapiControllerV15@register');

Route::any('logout', 'UserapiControllerV15@logout');

Route::any('update_device_token', 'UserapiControllerV15@updateDeviceToken');

Route::post('checkmobile', 'UserapiControllerV15@checkMobile');

Route::post('getmyprofile', 'UserapiControllerV15@getMyProfile');

Route::post('editmyprofile', 'UserapiControllerV15@editMyProfile');

Route::post('addbusiness', 'UserapiControllerV15@addBusiness');

Route::post('updatebusiness', 'UserapiControllerV15@updateBusiness');

Route::post('getmyallbusiness', 'UserapiControllerV15@getmyallbusiness');

Route::post('removemybusiness', 'UserapiControllerV15@removeMyBusiness');

//Route::post('gethomepage', 'UserapiControllerV15@getthisMonthsFestival');
Route::post('gethomepage', 'UserapiControllerV15@getHomePage');

Route::post('getdays', 'UserapiControllerV15@getDays');

Route::post('getfestivalimages', 'UserapiControllerV15@getMonthsPost');

Route::post('purchaseplan', 'UserapiControllerV15@purchasePlan');

Route::post('cencalplan', 'UserapiControllerV15@cencalPurchasedPlan');

Route::post('getmypurchaseplan', 'UserapiControllerV15@getMyPurchasePlanList');

Route::post('savephotos', 'UserapiControllerV15@savePhotos');

Route::post('getphotos', 'UserapiControllerV15@getPhotos');

Route::post('markascurrentbusiness', 'UserapiControllerV15@markascurrentbusiness');

Route::post('getmycurrentbusiness', 'UserapiControllerV15@getcurrntbusinesspreornot');


Route::post('getTemplates', 'UserapiControllerV15@getTemplates');

Route::post('testplan', 'UserapiControllerV15@testplan');

Route::post('setpreference', 'UserapiControllerV15@savePreference');

Route::get('getcustomcategorypost', 'UserapiControllerV15@getCustomCategoryPost');

Route::post('getCustomCategoryImages', 'UserapiControllerV15@getCustomCategoryImages');

Route::post('getVideoPosts', 'UserapiControllerV15@getVideoPosts');

Route::post('getBusinessCategory', 'UserapiControllerV15@getBusinessCategory');

Route::post('getAllVideoPosts', 'UserapiControllerV15@getAllVideoPosts');

Route::post('getAdvetisement', 'UserapiControllerV15@getAdvetisement');

Route::post('getLanguageVideo', 'UserapiControllerV15@getLanguageVideo');

Route::post('getLanguage', 'UserapiControllerV15@getLanguage');

Route::post('getLanguagePost', 'UserapiControllerV15@getLanguagePost');

Route::post('getCustomCategoryPosts', 'UserapiControllerV15@getCustomCategoryPosts');

Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV15@getLanguageCustomeCategoryPost');

Route::post('GetAllFestivalVideo', 'UserapiControllerV15@GetAllFestivalVideo');

Route::post('plans', 'UserapiControllerV15@Plans');

Route::post('getBusinessCategoryImages', 'UserapiControllerV15@getBusinessCategoryImages');

Route::post('CurrntbusinessPhoto', 'UserapiControllerV15@CurrntbusinessPhoto');

Route::post('newCategoryAllImage', 'UserapiControllerV15@newCategoryAllImage');

Route::post('getLanguageWithImage', 'UserapiControllerV15@getLanguageWithImage');

Route::post('SetUserLanguage', 'UserapiControllerV15@SetUserLanguage');

Route::post('SocialLogins', 'UserapiControllerV15@SocialLogins');

Route::post('SocialLoginPages', 'UserapiControllerV15@getSocialLoginPages');

Route::post('SocialLoginsLinkedInPage', 'UserapiControllerV15@SocialLoginsLinkedInPage');
Route::post('SocialLoginsFacebookPage', 'UserapiControllerV15@SocialLoginsFacebookPage');

Route::post('RemoveSocialProfile', 'UserapiControllerV15@removeSocialProfile');

Route::post('removeSocialPageLinkedIn', 'UserapiControllerV15@removeSocialPageLinkedIn');

Route::post('removeSocialPageFacebook', 'UserapiControllerV15@removeSocialPageFacebook');

Route::post('getLinkedAccounts', 'UserapiControllerV15@getLinkedAccounts');

Route::post('getScheduledPost', 'UserapiControllerV15@getScheduledPost');

Route::post('getScheduledHistory', 'UserapiControllerV15@getScheduledHistory');

Route::post('schedulePost', 'UserapiControllerV15@schedulePost');

Route::post('reSchedulePost', 'UserapiControllerV15@reSchedulePost');

Route::post('removeSchedulePost', 'UserapiControllerV15@removeSchedulePost');

Route::post('sharePost', 'UserapiControllerV15@sharePost');


// ======================= Political Section
Route::get('getPoliticalCategory', 'UserapiControllerV15@getPoliticalCategory');

Route::post('addPoliticalBusiness', 'UserapiControllerV15@addPoliticalBusiness');

Route::post('updatePoliticalbusiness', 'UserapiControllerV15@updatePoliticalbusiness');

Route::post('removePoliticalBusiness', 'UserapiControllerV15@removePoliticalBusiness');

Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV15@getmyAllPoliticalBusinessList');

Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV15@markCurrentBusinessForPolitic');

Route::get('GetAllBusinessCategory', 'UserapiControllerV15@GetAllBusinessCategory');

Route::get('getStickerCategory', 'UserapiControllerV15@getStickerCategory');

Route::get('getBackgroundCategory', 'UserapiControllerV15@getBackgroundCategory');

Route::post('getBackground', 'UserapiControllerV15@getBackground');

Route::post('getGraphic', 'UserapiControllerV15@getGraphic');

Route::post('getSticker', 'UserapiControllerV15@getSticker');

Route::post('getFrames', 'UserapiControllerV15@getFrames');

Route::get('generatePDF', 'UserapiControllerV15@generatePDF');

// ======================= Referral Section
Route::post('generateReferralLink', 'UserapiControllerV15@generateReferralLink');
Route::post('getReferralData', 'UserapiControllerV15@getReferralData');
Route::post('withdrawRequest', 'UserapiControllerV15@withdrawRequest');
Route::post('withdrawHistory', 'UserapiControllerV15@withdrawHistory');
Route::post('updatePaymentDetail', 'UserapiControllerV15@updatePaymentDetail');

Route::post('getMusicList', 'UserapiControllerV15@getMusicList');
