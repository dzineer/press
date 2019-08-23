<?php

namespace Dzineer\Press;

use Dzineer\Press\Factories\DriverFactory;
use Illuminate\Support\Str;

class Press {

	private $driver;
	protected $fields;

	public function __construct()
	{
		$this->loadDriver();
		$this->fields = [];
	}

	public function configNotPublished() {
		return is_null( config('press') );
	}

	private function loadDriver() {
		$driver_config =  config( 'press.driver' );
		$this->driver = DriverFactory::Create( $driver_config );
	}

	public function routePathPrefix() {
		return config( 'press.routes.path', 'blogs' );
	}

	public function fetchPosts() {
		return $this->driver->fetchPosts();
	}

	public function fields($fields = []) {
		// dd($fields);
		$this->fields = array_merge($this->fields, $fields);
	}

	public function availableFields() {
		return $this->fields;
	}

}