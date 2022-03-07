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

Route::get('imagthumb', 'NewFestivalPostController@index');

Route::get('clear', function(){
   
    \Artisan::Call('config:cache');
    

});
use App\Language;
use Modules\Festival\Http\Controllers\FestivalPostController;
Route::prefix('festival')->middleware('auth','adminauth')->group(function() {
    // Route::get('/', 'FestivalController@index');

    Route::get('/', 'FestivalController@index')->name('festival');
    Route::get('/test', 'FestivalController@test')->name('test');

    Route::post('addfestival','FestivalController@addFestival')->name('addfestival');

    Route::post('searchfestival','FestivalController@searchMonthsFestival');

    Route::post('deletefestival','FestivalController@deleteFestival');

    Route::post('getfestdetailforedit','FestivalController@getFestivalforedit');

    Route::post('updatefestival','FestivalController@updateFestival')->name('updatefestival');
    
    Route::post('removefestivalimage','FestivalController@removefestivalimage');

    Route::get('custom', function(){
        return view("festival::custom");})->name('customcatfest');
        
    Route::post('addcategory','FestivalController@addCategory')->name('addcategory');

    Route::post('getSubCategory','FestivalController@getSubCategory');
    Route::post('getSubCategoryTest','FestivalController@getSubCategoryTest');

    Route::post('addSubCategory','FestivalController@addSubCategory');
    Route::post('addSubCategoryTest','FestivalController@addSubCategoryTest');

    Route::post('editSubCategory','FestivalController@editSubCategory');
    Route::post('editSubCategoryTest','FestivalController@editSubCategoryTest');

    Route::post('deleteSubCategory','FestivalController@deleteSubCategory');
    Route::post('deleteSubCategoryTest','FestivalController@deleteSubCategoryTest');

    Route::get('getallcat','FestivalController@getAllCategory')->name('getallcat');

    Route::post('removeCat','FestivalController@removeCat');

    Route::post('getcatdetailforedit','FestivalController@getcatdetailforedit');

    Route::get('customcatpost', function(){
        return view("festival::customcatpost");})->name('customcatpost');

    Route::get('getcatlist','FestivalController@getcatlist');

    Route::post('addcatpost','FestivalController@addCatPost')->name('addcatpost');

    Route::get('getallcatpost','FestivalController@getAllCategoryPost')->name('getallcatpost');

    Route::post('removeCatPost','FestivalController@removeCatPost');

    Route::post('getcatpostdetailforedit','FestivalController@getcatpostdetailforedit');

    Route::get('videopost', function(){
        return view("festival::videopost");})->name('videopost');

    Route::post('addvideopost','FestivalController@addVideoPost')->name('addvideopost');

    Route::get('allvideopostlist','FestivalController@allvideopostlist');

    Route::post('remove-video','FestivalController@removeVideoPost');

    Route::post('get-video-post-edit','FestivalController@getVideoEdit');


    Route::get('newvideopost', function(){
        $language = Language::where('is_delete','=',0)->get();
        return view("festival::newvideopost",['language'=>$language]);})->name('newvideopost');

        Route::post('addnewvideopost','NewVideoPostController@store')->name('addnewvideopost');
        Route::post('getSubCategory','NewVideoPostController@getSubCategory');

        Route::post('addSubCategory','NewVideoPostController@addSubCategory');

        Route::post('editSubCategory','NewVideoPostController@editSubCategory');

        Route::post('deleteSubCategory','NewVideoPostController@deleteSubCategory');

    Route::post('getVideoData','NewVideoPostController@getVideoData');
    Route::post('get-newvideo-post-edit','NewVideoPostController@getNewVideoEdit');
    Route::post('changeimagetype','NewVideoPostController@ChangeImageType');
    Route::post('changelanguage','NewVideoPostController@ChangeLanguage');
    Route::post('changesubcategory','NewVideoPostController@ChangeSubCategory');
    Route::post('newremovefestivalimage','NewVideoPostController@removefestivalimage');
    Route::post('removenewvideo','NewVideoPostController@destroy');
    Route::post('changeColor','NewVideoPostController@changeColor');
    
    
    // Political Category
    Route::get('politicalcategory', function(){
        return view("festival::politicalcategory");
    })->name('politicalcategory');

    Route::get('getallpoliticalcategory','PoliticalCategoryController@getAllCategory');

    Route::post('addPoliticalcategory','PoliticalCategoryController@addCategory')->name('addPoliticalcategory');

    Route::post('getPoliticalCategoryforedit','PoliticalCategoryController@getcatdetailforedit');

    Route::post('removePoliticalCategory','PoliticalCategoryController@removePoliticalCategory');

});

Route::prefix('language')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'LanguageController@index')->name('language');
    Route::post('/languagelist', 'LanguageController@Languagelist');
    Route::post('/addlanguage', 'LanguageController@Addlanguage')->name('addlanguage');
    Route::post('/getlanguageforedit', 'LanguageController@edit');
    Route::post('/updatelanguage', 'LanguageController@update');
    Route::post('/deletelanguage', 'LanguageController@destroy');
});

Route::prefix('businesscategory')->middleware('auth','adminauth')->group(function() {
    Route::get('/', function(){
        $language = Language::where('is_delete','=',0)->get();
        return view("festival::businesscategory",['language'=>$language]);})->name('businesscategory');
    Route::post('video/changeimagetype','BusinessCategory@ChangeVideoType');
    Route::post('video/changelanguage','BusinessCategory@ChangeVideoLanguage');
    Route::post('video/changesubcategory','BusinessCategory@ChangeVideoSubCategory');
    Route::get('video/{id}','BusinessCategory@ShowCategoryVideo')->name('businesscategory.video');
    Route::post('video/store','BusinessCategory@ShowCategoryVideoStore')->name('businesscategory.video.add');
    Route::post('video/delete','BusinessCategory@ShowCategoryVideoDelete');
    Route::post('categorylist','BusinessCategory@ShowCategory');
    Route::post('addcategory','BusinessCategory@store');
    Route::post('getSubCategory','BusinessCategory@getSubCategory');
    Route::post('addSubCategory','BusinessCategory@addSubCategory');
    Route::post('editSubCategory','BusinessCategory@editSubCategory');
    Route::post('deleteSubCategory','BusinessCategory@deleteSubCategory');
    Route::post('getcategoryforedit','BusinessCategory@edit');
    Route::post('deletecategory','BusinessCategory@destroy');
    Route::post('changeimagetype','BusinessCategory@ChangeImageType');
    Route::post('changelanguage','BusinessCategory@ChangeLanguage');
    Route::post('changesubcategory','BusinessCategory@ChangeSubCategory');
    Route::post('removebussinessCATimage','BusinessCategory@removeBuseinesCATimage');

    
});

Route::prefix('FestivalPost')->middleware('auth','adminauth')->group(function() {

Route::get('/', function(){
        $language = Language::where('is_delete','=',0)->get();
        return view("festival::newfestivalpost",['language'=>$language]);})->name('FestivalPost');

    Route::post('addnewFestivalPost','NewFestivalPostController@store')->name('addnewFestivalPost');

    Route::post('getSubCategory','NewFestivalPostController@getSubCategory');
    Route::post('addSubCategory','NewFestivalPostController@addSubCategory');
    Route::post('editSubCategory','NewFestivalPostController@editSubCategory');
    Route::post('deleteSubCategory','NewFestivalPostController@deleteSubCategory');
    Route::post('getFestivalPostData','NewFestivalPostController@getFestivalPostData');
    Route::post('FestivalPostUpdates','NewFestivalPostController@FestivalPostUpdate');
    Route::post('get-newFestivalPost-edit','NewFestivalPostController@getNewFestivalPostEdit');
    Route::post('changeimagetypefestivalpost','NewFestivalPostController@ChangeImageType');
    Route::post('changelanguagefestivalpost','NewFestivalPostController@ChangeLanguage');
    Route::post('changesubcategoryfestivalpost','NewFestivalPostController@ChangeSubCategory');
    Route::post('newremovefestivalpostimage','NewFestivalPostController@removefestivalimage');
    Route::post('removenewFestivalPost','NewFestivalPostController@destroy');
});

Route::prefix('CustomCategorypost')->middleware('auth','adminauth')->group(function() {

Route::get('/', function(){
        $language = Language::where('is_delete','=',0)->get();
        return view("festival::customcategorypost",['language'=>$language]);})->name('CustomCategorypost');


    Route::get('getCustomeCategoryPost','CustomCategoryPostControllaer@getCustomeCategoryPost');
    Route::post('getcatlist','CustomCategoryPostControllaer@getcatlist');
    Route::post('addCustomCategorypost','CustomCategoryPostControllaer@addCustomCategorypost')->name('addCustomCategorypost');
    Route::post('editCustomeCategoryPost','CustomCategoryPostControllaer@editCustomeCategoryPost');
    Route::post('updateCustomCategoryvalue','CustomCategoryPostControllaer@updateCustomCategoryvalue');
    Route::post('RemoveCustomCategoryvalue','CustomCategoryPostControllaer@RemoveCustomCategoryvalue');
    
});

Route::prefix('advetisement')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'AdvetisementController@index')->name('advetisement');
    Route::post('/addadvetisement', 'AdvetisementController@store')->name('addadvetisement');
    Route::post('/searchadvetisement', 'AdvetisementController@searchAdvetisement');
    Route::post('/geteditadvetisement', 'AdvetisementController@EditAdvetisement');
    Route::post('/removeadvetisement', 'AdvetisementController@RemoveAdvetisement');
});

Route::prefix('client/festival')->group(function () {
    Route::any('getPostData', [FestivalPostController::class, 'getFestivalPostData']);
    Route::any('getFestivalPostPhotosData', [FestivalPostController::class, 'getFestivalPostPhotosData']);
	
    Route::any('getVideoData', [FestivalPostController::class, 'getFestivalVideoData']);
    Route::any('getFestivalVideoPhotosData', [FestivalPostController::class, 'getFestivalVideoPhotosData']);
	
    Route::any('getBusinessCategoryData', [FestivalPostController::class, 'getBusinessCategoryData']);
    Route::any('getBusinessCategoryPostData', [FestivalPostController::class, 'getBusinessCategoryPostData']);
	
    Route::any('singleFestivalPostPhotosData', [FestivalPostController::class, 'singleFestivalPostPhotosData']);
    Route::any('singleBusinessCategoryPostData', [FestivalPostController::class, 'singleBusinessCategoryPostData']);
    Route::any('singleFestivalVideoPhotosData', [FestivalPostController::class, 'singleFestivalVideoPhotosData']);
});
