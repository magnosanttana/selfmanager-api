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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::middleware(['auth:api'])->group(function () {
    

    Route::get('user/profile', function () {
        // Uses first & second Middleware
    });
});
Route::prefix('v1')->group(function () {
    Route::get('/dentists', 'DentistaController@index');
    Route::post('/dentists', 'DentistaController@store');
    Route::get('/dentists/{id}', 'DentistaController@show');
    Route::put('/dentists/{id}', 'DentistaController@update');
    Route::delete('/dentists/{id}', 'DentistaController@destroy');

    Route::get('/marital-status', 'EstadoCivilController@index');
    Route::get('/marital-status/{id}', 'EstadoCivilController@show');

});
