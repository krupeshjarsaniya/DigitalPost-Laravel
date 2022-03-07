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

/*Route::middleware('auth:api')->get('/festival', function (Request $request) {
    return $request->user();
});*/
Route::prefix('client/festival')->group(function () {
    Route::any('getPostData', 'FestivalPostController@getFestivalPostData');
    Route::any('getFestivalPostPhotosData', 'FestivalPostController@getFestivalPostPhotosData');
	
    Route::any('getVideoData', 'FestivalPostController@getFestivalVideoData');
    Route::any('getFestivalVideoPhotosData', 'FestivalPostController@getFestivalVideoPhotosData');
	
    Route::any('getBusinessCategoryData', 'FestivalPostController@getBusinessCategoryData');
    Route::any('getBusinessCategoryPostData', 'FestivalPostController@getBusinessCategoryPostData');
	
    Route::any('singleFestivalPostPhotosData', 'FestivalPostController@singleFestivalPostPhotosData');
    Route::any('singleBusinessCategoryPostData', 'FestivalPostController@singleBusinessCategoryPostData');
    Route::any('singleFestivalVideoPhotosData', 'FestivalPostController@singleFestivalVideoPhotosData');
});