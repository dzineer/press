<?php

namespace Dzineer\Press\Fields;

class Extra {
	public static function process($type, $value) {
		return json_encode([
			$type => $value
		]);
	}
}