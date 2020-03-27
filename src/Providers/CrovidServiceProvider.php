<?php

namespace Alfanjauhari\Crovid\Providers;

use Illuminate\Support\ServiceProvider;
use Alfanjauhari\Crovid\Crovid;

class CrovidServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->alias(Crovid::class, 'crovid');
	}

	/**
	 * Regiter any application services
	 *
	 * @return  void
	 */
	public function register()
	{
		//
	}
}