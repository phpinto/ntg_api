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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List all Loads
Route::get('loads', 'LoadController@allLoads');

// List one Load
Route::get('loads/{id}', 'LoadController@singleLoad');

// List Matching Nodes by ID
Route::get('matches/{id}', 'LoadController@matchingLoadsByID');