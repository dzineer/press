<?php

namespace Dzineer\Press\Factories;

use Illuminate\Support\Str;

class DriverFactory {
	public static function Create($driver) {
		$class = 'Dzineer\\Press\\Drivers\\' . Str::title( $driver ) . 'Driver';
		return new $class;
	}

}