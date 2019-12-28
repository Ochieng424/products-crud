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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'API\AuthController@user');
    Route::post('auth/logout', 'API\AuthController@logout');

    Route::apiResources(['products' => 'API\ProductController']);

    Route::prefix('products')->group(function () {
        Route::post('update_product/{productId}', 'API\ProductController@update');
        Route::get('find_products/{keyword}', 'API\ProductController@find');
    });
});

Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'API\AuthController@refresh');
});

Route::post('auth/register', 'API\AuthController@register');
Route::post('auth/login', 'API\AuthController@login');
