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
	Route::get('/login/{user}', 'Auth\LoginController@ttr_user');
/* Overwrite the default login controller */

Route::get('/', 'HomeController@about')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'HomeController@store');

Route::get('/archives/{season}', 'HomeController@archive')->name('archives');

Route::get('/league_standings', 'HomeController@standings')->name('league_standings');

Route::get('/league_info', 'HomeController@info')->name('league_info');

Route::post('/league_schedule/add_game/', 'LeagueScheduleController@add_game');

Route::post('/league_schedule/add_week/', 'LeagueScheduleController@add_week');

Route::patch('/league_schedule/{week}/', 'LeagueScheduleController@update_week');

Route::delete('/league_schedule/{week}/', 'LeagueScheduleController@delete_week');

Route::get('/edit_playoffs/playins/', 'LeagueScheduleController@edit_playins')->name('edit_playins');

Route::get('/edit_playoffs/round/{round}', 'LeagueScheduleController@edit_round')->name('edit_round');

Route::post('/edit_playoffs/', 'LeagueScheduleController@update_playoff_week')->name('update_playoff_week');

Route::delete('/delete_game/{league_schedule}/', 'LeagueScheduleController@delete_game');

Route::patch('/update_game/', 'LeagueScheduleController@update_game');

Route::get('/league_stat', 'LeagueStatController@index')->name('league_stat.index');

Route::get('league_stat/edit_week/{week}', 'LeagueStatController@edit_week')->name('league_stat.edit_week');

Route::get('league_stat/edit_round/{round}', 'LeagueStatController@edit_round')->name('league_stat.edit_round');

Route::patch('league_stat/edit_week/{week}', 'LeagueStatController@update');

Route::resource('league_schedule', 'LeagueScheduleController');

Route::resource('league_players', 'LeaguePlayerController');

Route::resource('league_teams', 'LeagueTeamController');

Route::resource('league_pictures', 'LeaguePictureController');

Route::resource('league_profile', 'LeagueProfileController');

Route::resource('league_season', 'LeagueSeasonController');

Route::post('create_playoffs', 'LeagueSeasonController@create_playoffs');

Route::post('complete_season', 'LeagueSeasonController@complete_season');

Route::get('league_profile/{league}/{season}', 'LeagueProfileController@show_season')->name('league_profile.season');

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