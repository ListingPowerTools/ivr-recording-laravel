<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(
    ['prefix' => 'ivr', 'middleware' => 'starReturn'], function () {
        Route::post(
            '/welcome', [
                'as' => 'welcome', 'uses' => 'IvrController@showWelcome'
            ]
        );
        Route::get(
            '/main-menu', [
                'as' => 'main-menu', 'uses' => 'MainMenuController@showMenuResponse'
            ]
        );
        Route::get(
            '/extension', [
                'as' => 'extension-connection',
                'uses' => 'IvrController@showExtensionConnection'
            ]
        );
    }
);
