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

Route::middleware('adminauth')->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/userpurchase-table', 'DashboardController@userpurchaseTable')->name('userpurchase-table');

});

Route::prefix('dashboard')->middleware('auth','adminauth')->group(function() {
    Route::get('/setting', 'DashboardController@Setting')->name('setting');

    Route::POST('/update-credit', 'DashboardController@updateCredit');

    Route::POST('/update-days', 'DashboardController@updateDays');

    Route::POST('/update-referral-image', 'DashboardController@updateReferralImage');

    Route::POST('/saveprivacy', 'DashboardController@saveprivacy');
    
    Route::POST('/saveterms', 'DashboardController@saveterms');
    
    Route::POST('/savereferralpolicy', 'DashboardController@savereferralpolicy');

    Route::POST('/update-whatsapp', 'DashboardController@updateWhatapp');

});