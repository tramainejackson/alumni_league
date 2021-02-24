<?php

namespace App\Providers;

use App\Admin;
use App\LeagueSeason;
use App\LeagueProfile;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		View::share('league', LeagueProfile::find(2));
		View::share('activeSeasons', LeagueProfile::find(2)->seasons()->active());
		View::share('completedSeasons', LeagueProfile::find(2)->seasons()->completed());
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
