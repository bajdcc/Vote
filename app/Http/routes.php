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

//Route::get('/', 'HomeController@index');

Route::get('/jump', 'JumpController@index');

Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));

//TODO: /vote/...

\App\Http\Controllers\VoteController::registerRoute();