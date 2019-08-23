<?php

namespace Dzineer\Press\Fields;

use Dzineer\Press\Contracts\FieldContract;

class Title extends FieldContract {
	public static function process($type, $value) {
		return [
			$type => $value
		];
	}
}