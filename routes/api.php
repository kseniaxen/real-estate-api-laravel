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
    function (){
        Route::post('login', 'AuthController@login');
        Route::post('register','AuthController@register');
        Route::post('logout','AuthController@logout');
        Route::get('user','AuthController@userInfo');
        Route::get('refresh','AuthController@refresh');
        Route::post('/check','AuthController@checkUser');
        Route::patch('edit','AuthController@editUser');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'country'
    ],
    function (){
        Route::post('', 'CountryController@create');
        Route::patch('{id}', 'CountryController@edit');
        Route::delete('{id}', 'CountryController@delete');
        Route::get('', 'CountryController@getAll');
        Route::get('/city', 'CountryController@getByName');
        Route::get('{id}', 'CountryController@getCountryById');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'city'
    ],
    function (){
        Route::post('', 'CityController@create');
        Route::patch('{id}', 'CityController@edit');
        Route::delete('{id}', 'CityController@delete');
        Route::get('/', 'CityController@getCityByCountryId');
        Route::get('/{id}', 'CityController@getCityById');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'type'
    ],
    function (){
        Route::post('', 'TypeController@create');
        Route::patch('{id}', 'TypeController@edit');
        Route::delete('{id}', 'TypeController@delete');
        Route::get('', 'TypeController@getAll');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'typeproperty'
    ],
    function(){
        Route::post('', 'TypePropertyController@create');
        Route::patch('{id}', 'TypePropertyController@edit');
        Route::delete('{id}', 'TypePropertyController@delete');
        Route::get('', 'TypePropertyController@getAll');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'currency'
    ],
    function(){
        Route::post('', 'CurrencyController@create');
        Route::patch('{id}', 'CurrencyController@edit');
        Route::delete('{id}', 'CurrencyController@delete');
        Route::get('', 'CurrencyController@getAll');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'unit'
    ],
    function(){
        Route::post('', 'UnitController@create');
        Route::patch('{id}', 'UnitController@edit');
        Route::delete('{id}', 'UnitController@delete');
        Route::get('', 'UnitController@getAll');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'apartmentuser'
    ],
    function(){
        Route::post('', 'ApartmentController@create');
        Route::patch('{id}','ApartmentController@edit');
        Route::delete('{id}','ApartmentController@delete');
        Route::get('','ApartmentController@getAll');
        Route::get('/count','ApartmentController@getTotalCount');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'apartment'
    ],
    function(){
        Route::get('', 'ApartmentCommonController@getAllBySection');
        Route::get('/count', 'ApartmentCommonController@getTotalCount');
        Route::get('/filter','ApartmentCommonController@filter');
        Route::get('/last', 'ApartmentCommonController@getLastFour');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'houseuser'
    ],
    function(){
        Route::post('', 'HouseController@create');
        Route::patch('{id}','HouseController@edit');
        Route::delete('{id}','HouseController@delete');
        Route::get('','HouseController@getAll');
        Route::get('/count','HouseController@getTotalCount');
    }
);

Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'house'
    ],
    function(){
        Route::get('', 'HouseCommonController@getAllBySection');
        Route::get('/count', 'HouseCommonController@getTotalCount');
        Route::get('/filter','HouseCommonController@filter');
        Route::get('/last', 'HouseCommonController@getLastFour');
    }
);
