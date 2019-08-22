<?php

namespace Dzineer\Press\Fields;

use Dzineer\Press\MarkdownParser;

class Body {
	public static function process($type, $value) {
		return [
			$type => MarkdownParser::parse( $value )
		];
	}
}