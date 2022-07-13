<?php

use Illuminate\Support\Facades\Route;

Route::get('/register', 'Distributors\AuthController@registerForm')->name('distributors.registerForm');
Route::post('/register', 'Distributors\AuthController@register')->name('distributors.register');
Route::get('/login', 'Distributors\AuthController@loginForm')->name('distributors.loginForm');
Route::post('/login', 'Distributors\AuthController@login')->name('distributors.login');
Route::get('/logout', 'Distributors\AuthController@logout')->name('distributors.logout');

Route::middleware('distributorAuth')->group(function() {
    Route::get('/dashboard', 'Distributors\DashboardController@index')->name('distributors.dashboard');
});
