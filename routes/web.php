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

// Route::get('/backup', function()
// {
//     // \Artisan::call('backup:run',['--only-files'=>true]);
//     // \Artisan::call('backup:run',['--only-db'=>true]);
//     \Artisan::call('backup:run');
//     // \Artisan::call('migrate');
// });

// Route::get('/cache-config', function()
// {
//     \Artisan::call('config:cache');
// });

Route::get('db-backup', 'HomeController@our_backup_database');
Route::get('privacypolicy', 'ConditionController@privacyplicy');

Route::get('termsandcondition', 'ConditionController@termcondition');
Route::get('referralpolicy', 'ConditionController@referralpolicy');


Route::get('facebook', 'HomeController@facebookLogin');

Route::get('instagram', 'HomeController@instagramLogin');

Route::get('facebook/callback', 'HomeController@facebookCallback');

Route::get('facebook/access_token', 'HomeController@facebookAccessToken')->name('facebookAccessToken');

Route::group(['middleware' => 'auth'], function()
{

	// Route::get('/', function () {
	// 	return redirect()->route('dashboard');
 //        //return redirect()->url('login');
	// });

	// Route::get('/home', function () {
	// 	return redirect()->route('dashboard');
	// });
		// Route::redirect('/','/admin/dashboard',301);
		// Route::redirect('/home','/admin/dashboard',301);

});

// Auth::routes();

Route::get('test/{offset}', 'TestController@test');
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@AdminLogin');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('logout', 'Auth\LoginController@logout');
// Route::group(['middleware' => 'auth'], function(){
//  	Route::get('/home', 'HomeController@index')->name('home');
// });

Route::prefix('distributor_channel')->group(base_path('routes/distributor.php'));
