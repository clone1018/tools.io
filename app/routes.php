<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'HomeController@getIndex');
Route::controller('/network/ip', 'IPController');
Route::controller('/website', 'WebsiteController');

Route::group(array('prefix' => 'api/v0', 'before' => 'api'), function () {
    Route::controller('network/ip', 'Api\VersionZero\Network\IPController');
});
