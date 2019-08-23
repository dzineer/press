<?php

namespace Dzineer\Press;

use Dzineer\Press\Factories\DriverFactory;
use Illuminate\Support\Str;

class Press {

	private $driver;

	public function __construct()
	{
		$this->loadDriver();
	}

	public static function configNotPublished() {
		return is_null( config('press') );
	}

	private function loadDriver() {
		$driver_config =  config( 'press.driver' );
		$this->driver = DriverFactory::Create( $driver_config );
	}

	public static function routePathPrefix() {
		return config( 'press.routes.path', 'blogs' );
	}

	public function fetchPosts() {
		return $this->driver->fetchPosts();
	}

}