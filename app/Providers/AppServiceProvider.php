<?php

namespace App\Providers;

use App\Admin;
use App\LeagueSeason;
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
		View::share('settings', Admin::first());
		View::share('showSeason', LeagueSeason::active()->get()->last());
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
