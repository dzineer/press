<?php

namespace Dzineer\Press\Fields;

class CustomField {
	public static function process($type, $value) {
		return json_encode([
			$type => $value
		]);
	}
}