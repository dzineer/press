<?php

namespace Dzineer\Press\Facades;

use Illuminate\Support\Facades\Facade;

class Press extends Facade {

	protected static function getFacadeAccessor() {
		return 'Press';
	}
	
}