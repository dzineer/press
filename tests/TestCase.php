<?php

namespace Dzineer\Press\Tests;

use Dzineer\Press\Providers\PressBaseServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase {

	use RefreshDatabase;

	protected function setUp(): void {
		parent::setUp();
		$this->loadMigrationsFrom( __DIR__ . '/../database/migrations');
		$this->withFactories( __DIR__ . '/../database/factories');
	}

	/**
	 * Resolve application aliases.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 *
	 * @return array
	 */
	protected function getPackageProviders( $app ) {
		return [
			PressBaseServiceProvider::class
		];
	}

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application   $app
	 *
	 * @return void
	 */
	protected function getEnvironmentSetUp( $app ) {
		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'testdb');
		$app['config']->set('database.connections.testdb', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		]);
	}
}