<?php

namespace Dzineer\Press\Parsers;

use Carbon\Carbon;

class DateParser {
	public static function parse($type, $value) {
		return [
			$type => Carbon::parse( $value )
		];
	}
}