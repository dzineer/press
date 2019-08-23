<?php

namespace Dzineer\Press\Factories;

use Dzineer\Press\Parsers\PressFileParser;
use Dzineer\Press\Parsers\PressTextParser;

class PressParserFactory
{
	public static function Create($type, $s, $identifier)
	{
		switch ($type) {
			case 'string':
				return (new PressTextParser($s, $identifier));
				break;
			case 'file':
				$filename = $s;
				return (new PressFileParser($filename, $identifier));
		}

	}

}