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

// Route::get('/test', function () {
    // return view('welcome');
// });

Auth::routes();

/* Overwrite the default login controller */
	Route::post('/login', 'Auth\LoginController@authenticate');
	Route::get('/login', 'Auth\LoginController@index')->name('login');
/* Overwrite the default login controller */

Route::get('/', 'HomeController@about')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'HomeController@store');

Route::get('/league_standings', 'HomeController@standings')->name('league_standings');

Route::get('/league_info', 'HomeController@info')->name('league_info');

Route::resource('league_schedule', 'LeagueScheduleController');

Route::resource('league_players', 'LeaguePlayerController');

Route::resource('league_stat', 'LeagueStatController');

Route::resource('league_pictures', 'LeaguePictureController');

Route::resource('league_profile', 'LeagueProfileController');

Route::resource('league_season', 'LeagueSeasonController');