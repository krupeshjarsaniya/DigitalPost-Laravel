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
    Route::get('/businessList/add', 'Distributors\BusinessController@businessAdd')->name('distributors.businessAdd');
    Route::post('/businessList/insert', 'Distributors\BusinessController@businessInsert')->name('distributors.businessInsert');
    Route::get('/businessList/{id}', 'Distributors\BusinessController@businessList')->name('distributors.businessList');
});
