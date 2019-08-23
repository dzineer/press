<?php

namespace Dzineer\Press\Fields;

use Dzineer\Press\MarkdownParser;

class Extra {
	public static function process($type, $value) {
		return json_encode([
			$type => $value
		]);
	}
}