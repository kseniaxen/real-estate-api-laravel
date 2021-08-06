<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'auth'
    ],
    function ($router){
        Route::post('login', 'AuthController@login');
        Route::post('register','AuthController@register');
        Route::post('logout','AuthController@logout');
        Route::get('user','AuthController@userInfo');
        Route::get('refresh','AuthController@refresh');
        Route::get('check','AuthController@checkUser');
        Route::patch('edit','AuthController@editUser');
    }
);
