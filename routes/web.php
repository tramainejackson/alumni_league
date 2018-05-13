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

Route::post('league_schedule/add_game/', 'LeagueScheduleController@add_game');

Route::post('league_schedule/add_week/', 'LeagueScheduleController@add_week');

Route::patch('league_schedule/{week}/', 'LeagueScheduleController@update_week');

Route::get('league_stat', 'LeagueStatController@index')->name('league_stat.index');

Route::get('league_stat/edit_week/{week}', 'LeagueStatController@edit_week')->name('league_stat.edit_week');

Route::patch('league_stat/edit_week/{week}', 'LeagueStatController@update');

Route::resource('league_schedule', 'LeagueScheduleController');

Route::resource('league_players', 'LeaguePlayerController');

Route::resource('league_teams', 'LeagueTeamController');

Route::resource('league_pictures', 'LeaguePictureController');

Route::resource('league_profile', 'LeagueProfileController');

Route::resource('league_season', 'LeagueSeasonController');

/** MDB Templates **/
Route::get('/templates/about_us', 'TemplateController@about_us');
Route::get('/templates/blog_post', 'TemplateController@blog_post');
Route::get('/templates/contact_us', 'TemplateController@contact_us');
Route::get('/templates/ecommerce', 'TemplateController@ecommerce');
Route::get('/templates/log_in', 'TemplateController@log_in');
Route::get('/templates/pricing', 'TemplateController@pricing');
Route::get('/templates/profile_page', 'TemplateController@profile_page');
Route::get('/templates/signup', 'TemplateController@signup');
Route::get('/templates/landing', 'TemplateController@landing');
/** MDB Templates **/