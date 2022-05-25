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

Route::prefix('plan')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'PlanController@index')->name('plans');
    Route::post('/getdetailforedit', 'PlanController@getdetailforedit')->name('getdetailforedit');

    Route::post('/updateplan', 'PlanController@updateplan')->name('updateplan');

    Route::post('/unblock-plan', 'PlanController@UnBlockPlan');
    Route::post('/block-plan', 'PlanController@BlockPlan');

});

Route::prefix('bg-remove-plan')->middleware('auth','adminauth')->group(function() {
    Route::get('/', 'BGPlanController@index')->name('bg_remove_plan');
    Route::get('/getBGRemovePlanList', 'BGPlanController@getBGRemovePlanList');
    Route::post('/addBGRemovePlan', 'BGPlanController@addBGRemovePlan');
    Route::post('/getBGRemovePlanById', 'BGPlanController@getBGRemovePlanById');
    Route::post('/updateBGRemovePlan', 'BGPlanController@updateBGRemovePlan');
    Route::post('/updateStatusBGRemovePlan', 'BGPlanController@updateStatusBGRemovePlan');
});
