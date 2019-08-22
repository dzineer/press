<?php

namespace Dzineer\Press\Contracts;

use Dzineer\Press\MarkdownParser;

abstract class FieldContract
{
	public static function process($fieldType, $fieldValue) {
		return [$fieldType => MarkdownParser::parse( $fieldValue )];
	}
}