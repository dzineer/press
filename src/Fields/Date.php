<?php

namespace Dzineer\Press\Fields;

use Carbon\Carbon;
use Dzineer\Press\Contracts\FieldContract;

class Date extends FieldContract {
	public static function process($type, $value) {
		return [
			$type => Carbon::parse( $value ),
			"parsed_at" => Carbon::now()
		];
	}
}