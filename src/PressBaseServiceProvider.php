<?php

namespace Dzineer\Press;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Dzineer\Press\Facades\Press;

class PressBaseServiceProvider extends ServiceProvider {

	public function boot() {
		if ($this->app->runningInConsole()) {
			$this->registerPublishing();
		}
		$this->registerResources();
	}

	public function register() {
		$this->commands([
			Console\ProcessCommand::class,
		]);
	}

	private function registerResources() {

		$this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'press');

		$this->registerFacade();
		$this->registerRoutes();
		$this->registerFields();

	}

	protected function registerPublishing() {
		$this->publishes([
			__DIR__ . '/../config/press.php' => config_path('press.php'),
		], 'press-config');
	}

	protected function registerRoutes() {
		Route::group( $this->routeConfiguration(), function() {
			$this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );
		});
	}

	private function routeConfiguration() {
		return [
			'prefix' => Press::routePathPrefix(),
			'namespace' => 'Dzineer\Press\Http\Controllers',
		];
	}

	protected function registerFacade() {
		$this->app->singleton('Press', function($app) {
			return new \Dzineer\Press\Press();
		});
	}

	private function registerFields() {
		Press::fields([
			Fields\Body::class,
			Fields\Date::class,
			Fields\Extra::class,
			Fields\Title::class,
		]);
	}
}