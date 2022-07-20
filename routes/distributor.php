<?php

use Illuminate\Support\Facades\Route;

Route::get('/register', 'Distributors\AuthController@registerForm')->name('distributors.registerForm');
Route::post('/register', 'Distributors\AuthController@register')->name('distributors.register');
Route::get('/login', 'Distributors\AuthController@loginForm')->name('distributors.loginForm');
Route::post('/login', 'Distributors\AuthController@login')->name('distributors.login');
Route::get('/logout', 'Distributors\AuthController@logout')->name('distributors.logout');

Route::middleware('distributorAuth')->group(function() {
    Route::get('/dashboard', 'Distributors\DashboardController@index')->name('distributors.dashboard');

    //Profile
    Route::get('/profile', 'Distributors\DashboardController@profile')->name('distributors.profile');
    Route::post('/updateProfile', 'Distributors\DashboardController@updateProfile')->name('distributors.updateProfile');

    //Transaction
    Route::get('/transaction', 'Distributors\DashboardController@transaction')->name('distributors.transaction');
    Route::get('/transactionList/{id}', 'Distributors\DashboardController@transactionList')->name('distributors.transactionList');

    //Normal Business
    Route::get('/business', 'Distributors\BusinessController@index')->name('distributors.business');
    Route::get('/business/add', 'Distributors\BusinessController@businessAdd')->name('distributors.businessAdd');
    Route::post('/business/insert', 'Distributors\BusinessController@businessInsert')->name('distributors.businessInsert');
    Route::get('/business/view/{id}', 'Distributors\BusinessController@businessView')->name('distributors.businessView');
    Route::post('/business/update/{id}', 'Distributors\BusinessController@businessUpdate')->name('distributors.businessUpdate');
    Route::get('/businessUserList/', 'Distributors\BusinessController@businessUserList')->name('distributors.businessUserList');
    Route::get('/businessPurchaseList/', 'Distributors\BusinessController@businessPurchaseList')->name('distributors.businessPurchaseList');
    Route::get('/businessFrameList/', 'Distributors\BusinessController@businessFrameList')->name('distributors.businessFrameList');
    Route::post('/businessUser/add', 'Distributors\BusinessController@businessUserAdd')->name('distributors.businessUserAdd');
    Route::post('/businessFrame/add', 'Distributors\BusinessController@businessFrameAdd')->name('distributors.businessFrameAdd');
    Route::post('/businessUser/delete', 'Distributors\BusinessController@businessUserDelete')->name('distributors.businessUserDelete');
    Route::get('/businessList/view/{id}', 'Distributors\BusinessController@businessList')->name('distributors.businessList');
    Route::get('/getpendingFrameList/', 'Distributors\BusinessController@getPendingFrameList')->name('distributors.getpendingFrameList');


    Route::get('/upcomingRenewals/', 'Distributors\BusinessController@upcomingRenewals')->name('distributors.upcomingRenewals');
    Route::get('/normalBusinessExpirePlan/', 'Distributors\BusinessController@normalBusinessExpirePlan')->name('distributors.normalBusinessExpirePlan');
    Route::get('/politicalBusinessExpirePlan/', 'Distributors\BusinessController@politicalBusinessExpirePlan')->name('distributors.politicalBusinessExpirePlan');
    Route::get('/normalBusinessUpcomingExpirePlan/', 'Distributors\BusinessController@normalBusinessUpcomingExpirePlan')->name('distributors.normalBusinessUpcomingExpirePlan');
    Route::get('/politicalBusinessUpcomingExpirePlan/', 'Distributors\BusinessController@politicalBusinessUpcomingExpirePlan')->name('distributors.politicalBusinessUpcomingExpirePlan');
    Route::post('/purchasePlan/', 'Distributors\BusinessController@purchasePlan')->name('distributors.purchasePlan');



    //Normal Business
    Route::get('/political-business', 'Distributors\PoliticalBusinessController@index')->name('distributors.politicalBusiness');
    Route::get('/political-business/add', 'Distributors\PoliticalBusinessController@politicalBusinessAdd')->name('distributors.politicalBusinessAdd');
    Route::post('/political-business/insert', 'Distributors\PoliticalBusinessController@politicalBusinessInsert')->name('distributors.politicalBusinessInsert');
    Route::get('/political-business/view/{id}', 'Distributors\PoliticalBusinessController@politicalBusinessView')->name('distributors.politicalBusinessView');
    Route::post('/political-business/update/{id}', 'Distributors\PoliticalBusinessController@politicalBusinessUpdate')->name('distributors.politicalBusinessUpdate');
    Route::get('/political-businessUserList/', 'Distributors\PoliticalBusinessController@politicalBusinessUserList')->name('distributors.politicalBusinessUserList');
    Route::get('/political-businessPurchaseList/', 'Distributors\PoliticalBusinessController@politicalBusinessPurchaseList')->name('distributors.politicalBusinessPurchaseList');
    Route::get('/political-businessFrameList/', 'Distributors\PoliticalBusinessController@politicalBusinessFrameList')->name('distributors.politicalBusinessFrameList');
    Route::post('/political-businessUser/add', 'Distributors\PoliticalBusinessController@politicalBusinessUserAdd')->name('distributors.politicalBusinessUserAdd');
    Route::post('/political-businessFrame/add', 'Distributors\PoliticalBusinessController@politicalBusinessFrameAdd')->name('distributors.politicalBusinessFrameAdd');
    Route::post('/political-businessUser/delete', 'Distributors\PoliticalBusinessController@politicalBusinessUserDelete')->name('distributors.politicalBusinessUserDelete');
    Route::get('/political-businessList/view/{id}', 'Distributors\PoliticalBusinessController@politicalBusinessList')->name('distributors.politicalBusinessList');
    Route::get('/getpendingFrameListPolitical/', 'Distributors\PoliticalBusinessController@getPendingFrameListPolitical')->name('distributors.getpendingFrameListPolitical');
});
