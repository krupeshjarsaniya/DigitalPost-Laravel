<?php

use Illuminate\Support\Facades\Route;

Route::post('getInstagramAccount', 'UserapiControllerV16@getInstagramAccount');

Route::post('sendLoginOTP', 'UserapiControllerV16@sendLoginOTP');

Route::post('login', 'UserapiControllerV16@login');

Route::post('sendRegisterOTP', 'UserapiControllerV16@sendRegisterOTP');

Route::post('register', 'UserapiControllerV16@register');

Route::any('logout', 'UserapiControllerV16@logout');

Route::any('update_device_token', 'UserapiControllerV16@updateDeviceToken');

Route::post('checkmobile', 'UserapiControllerV16@checkMobile');

Route::post('getmyprofile', 'UserapiControllerV16@getMyProfile');

Route::post('editmyprofile', 'UserapiControllerV16@editMyProfile');

Route::post('addbusiness', 'UserapiControllerV16@addBusiness');

Route::post('updatebusiness', 'UserapiControllerV16@updateBusiness');

Route::post('getmyallbusiness', 'UserapiControllerV16@getmyallbusiness');

Route::post('removemybusiness', 'UserapiControllerV16@removeMyBusiness');

Route::post('gethomepage', 'UserapiControllerV16@getHomePage');

Route::post('getdays', 'UserapiControllerV16@getDays');

Route::post('getfestivalimages', 'UserapiControllerV16@getMonthsPost');

Route::post('purchaseplan', 'UserapiControllerV16@purchasePlan');

Route::post('cencalplan', 'UserapiControllerV16@cencalPurchasedPlan');

Route::post('getmypurchaseplan', 'UserapiControllerV16@getMyPurchasePlanList');

Route::post('savephotos', 'UserapiControllerV16@savePhotos');

Route::post('getphotos', 'UserapiControllerV16@getPhotos');

Route::post('markascurrentbusiness', 'UserapiControllerV16@markascurrentbusiness');

Route::post('getmycurrentbusiness', 'UserapiControllerV16@getcurrntbusinesspreornot');


Route::post('getTemplates', 'UserapiControllerV16@getTemplates');

Route::post('testplan', 'UserapiControllerV16@testplan');

Route::post('setpreference', 'UserapiControllerV16@savePreference');

Route::get('getcustomcategorypost', 'UserapiControllerV16@getCustomCategoryPost');

Route::post('getCustomCategoryImages', 'UserapiControllerV16@getCustomCategoryImages');

Route::post('getVideoPosts', 'UserapiControllerV16@getVideoPosts');

Route::post('getBusinessCategory', 'UserapiControllerV16@getBusinessCategory');

Route::post('getAllVideoPosts', 'UserapiControllerV16@getAllVideoPosts');

Route::post('getAdvetisement', 'UserapiControllerV16@getAdvetisement');

Route::post('getLanguageVideo', 'UserapiControllerV16@getLanguageVideo');

Route::post('getLanguage', 'UserapiControllerV16@getLanguage');

Route::post('getLanguagePost', 'UserapiControllerV16@getLanguagePost');

Route::post('getCustomCategoryPosts', 'UserapiControllerV16@getCustomCategoryPosts');

Route::post('getLanguageCustomeCategoryPost', 'UserapiControllerV16@getLanguageCustomeCategoryPost');

Route::post('GetAllFestivalVideo', 'UserapiControllerV16@GetAllFestivalVideo');

Route::post('plans', 'UserapiControllerV16@Plans');

Route::post('getBusinessCategoryImages', 'UserapiControllerV16@getBusinessCategoryImages');

Route::post('CurrntbusinessPhoto', 'UserapiControllerV16@CurrntbusinessPhoto');

Route::post('newCategoryAllImage', 'UserapiControllerV16@newCategoryAllImage');

Route::post('getLanguageWithImage', 'UserapiControllerV16@getLanguageWithImage');

Route::post('SetUserLanguage', 'UserapiControllerV16@SetUserLanguage');

Route::post('SocialLogins', 'UserapiControllerV16@SocialLogins');

Route::post('SocialLoginPages', 'UserapiControllerV16@getSocialLoginPages');

Route::post('SocialLoginsLinkedInPage', 'UserapiControllerV16@SocialLoginsLinkedInPage');
Route::post('SocialLoginsFacebookPage', 'UserapiControllerV16@SocialLoginsFacebookPage');

Route::post('RemoveSocialProfile', 'UserapiControllerV16@removeSocialProfile');

Route::post('removeSocialPageLinkedIn', 'UserapiControllerV16@removeSocialPageLinkedIn');

Route::post('removeSocialPageFacebook', 'UserapiControllerV16@removeSocialPageFacebook');

Route::post('getLinkedAccounts', 'UserapiControllerV16@getLinkedAccounts');

Route::post('getScheduledPost', 'UserapiControllerV16@getScheduledPost');

Route::post('getScheduledHistory', 'UserapiControllerV16@getScheduledHistory');

Route::post('schedulePost', 'UserapiControllerV16@schedulePost');

Route::post('reSchedulePost', 'UserapiControllerV16@reSchedulePost');

Route::post('removeSchedulePost', 'UserapiControllerV16@removeSchedulePost');

Route::post('sharePost', 'UserapiControllerV16@sharePost');


// ======================= Political Section
Route::get('getPoliticalCategory', 'UserapiControllerV16@getPoliticalCategory');

Route::post('addPoliticalBusiness', 'UserapiControllerV16@addPoliticalBusiness');

Route::post('updatePoliticalbusiness', 'UserapiControllerV16@updatePoliticalbusiness');

Route::post('removePoliticalBusiness', 'UserapiControllerV16@removePoliticalBusiness');

Route::post('getmyAllPoliticalBusinessList', 'UserapiControllerV16@getmyAllPoliticalBusinessList');

Route::post('markCurrentBusinessForPolitic', 'UserapiControllerV16@markCurrentBusinessForPolitic');

Route::get('GetAllBusinessCategory', 'UserapiControllerV16@GetAllBusinessCategory');

Route::get('getStickerCategory', 'UserapiControllerV16@getStickerCategory');

Route::get('getBackgroundCategory', 'UserapiControllerV16@getBackgroundCategory');

Route::post('getBackground', 'UserapiControllerV16@getBackground');

Route::post('getGraphic', 'UserapiControllerV16@getGraphic');

Route::post('getSticker', 'UserapiControllerV16@getSticker');

Route::post('getFrames', 'UserapiControllerV16@getFrames');


// ======================= Referral Section
Route::post('generateReferralLink', 'UserapiControllerV16@generateReferralLink');
Route::post('getReferralData', 'UserapiControllerV16@getReferralData');
Route::post('withdrawRequest', 'UserapiControllerV16@withdrawRequest');
Route::post('withdrawHistory', 'UserapiControllerV16@withdrawHistory');
Route::post('updatePaymentDetail', 'UserapiControllerV16@updatePaymentDetail');

Route::post('getMusicList', 'UserapiControllerV16@getMusicList');

Route::post('getBGRemoveCreditPlan', 'UserapiControllerV16@getBGRemoveCreditPlan');

Route::post('purchaseBGRemovePlan', 'UserapiControllerV16@purchaseBGRemovePlan');

Route::post('removeBackground', 'UserapiControllerV16@removeBackground');

Route::post('userDownloadPhoto', 'UserapiControllerV16@userDownloadPhoto');

Route::post('checkUserRemainingLimit', 'UserapiControllerV16@checkUserRemainingLimit');

Route::post('addContentCreater', 'UserapiControllerV16@addContentCreater');

Route::post('addDistributor', 'UserapiControllerV16@addDistributor');

Route::post('getBanners', 'UserapiControllerV16@getBanners');

Route::post('testFramejson', 'UserapiControllerV16@testFramejson');

Route::post('search', 'UserapiControllerV16@search');

Route::post('getBusinessCategoryData', 'UserapiControllerV16@getBusinessCategoryData');
