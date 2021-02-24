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

 Route::get('/test', function () {
 	$user = \App\User::find(1);
     return view('emails.new_contact', compact('user'));
 });

Auth::routes();

/* Overwrite the default login controller */
	Route::post('/login', 'Auth\LoginController@authenticate');
	Route::get('/register', 'Auth\RegisterController@register');
/* Overwrite the default login controller */

Route::get('/', 'HomeController@about')->name('welcome');

//Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/test_drive', 'HomeController@test_drive')->name('test_drive');

//Route::post('/remove_test_drive', 'HomeController@remove_test_drive')->name('remove_test_drive');

Route::post('/home', 'HomeController@store');

Route::get('/archives', 'LeagueSeasonController@archive_index')->name('archives_index');

Route::get('/archives/show/{season}', 'LeagueSeasonController@archive_show')->name('archives_show');

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

Route::patch('/update_game', 'LeagueScheduleController@update_game');

Route::get('/league_stats/all_star_game/{game}', 'LeagueStatController@edit_asg')->name('league_stats.all_star_game');

Route::get('/league_stats/edit_week/{week}', 'LeagueStatController@edit_week')->name('league_stats.edit_week');

Route::get('/league_stats/edit_round/{round}', 'LeagueStatController@edit_round')->name('league_stats.edit_round');

Route::patch('/league_stats/edit_week/{week}', 'LeagueStatController@update');

Route::post('create_playoffs', 'LeagueSeasonController@create_playoffs');

Route::post('complete_season', 'LeagueSeasonController@complete_season');

Route::delete('league_rules/{ruleID}', 'LeagueSeasonController@destroy_rule');

Route::get('league_profile/{league}/{season}', 'LeagueProfileController@show_season')->name('league_profile.season');

Route::get('settings', 'HomeController@show_setting')->name('settings');

Route::post('settings/{setting}', 'HomeController@edit_setting');

Route::post('/restore_team/{id}', 'LeagueTeamController@restore');

Route::post('/create_all_star_team/', 'LeagueSeasonController@create_all_star_team');

/* Resource Controllers */
Route::resource('league_schedule', 'LeagueScheduleController');
Route::resource('league_players', 'LeaguePlayerController');
Route::resource('league_teams', 'LeagueTeamController');
Route::resource('league_pictures', 'LeaguePictureController');
Route::resource('league_profile', 'LeagueProfileController');
Route::resource('league_seasons', 'LeagueSeasonController');
Route::resource('league_stats', 'LeagueStatController');
Route::resource('news', 'NewsArticleController');
Route::resource('messages', 'MessagesController');
Route::resource('users', 'UserController');
Route::resource('settings', 'AdminController');
/* Resource Controllers */

/** MDB Templates **/
//Route::get('/templates/about_us', 'TemplateController@about_us');
//Route::get('/templates/blog_post', 'TemplateController@blog_post');
//Route::get('/templates/contact_us', 'TemplateController@contact_us');
//Route::get('/templates/ecommerce', 'TemplateController@ecommerce');
//Route::get('/templates/log_in', 'TemplateController@log_in');
//Route::get('/templates/pricing', 'TemplateController@pricing');
//Route::get('/templates/profile_page', 'TemplateController@profile_page');
//Route::get('/templates/signup', 'TemplateController@signup');
//Route::get('/templates/landing', 'TemplateController@landing');
/** MDB Templates **/