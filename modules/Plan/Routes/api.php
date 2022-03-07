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
Route::prefix('plan')->group(function() {

	// Route::post('login', 'UserapiController@login');

    Route::get('plans', 'PlanApiController@index');

});

// Route::middleware('auth:api')->get('/plan', function (Request $request) {
//     return $request->user();
// });