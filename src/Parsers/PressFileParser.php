<?php

namespace Dzineer\Press\Parsers;

use Illuminate\Support\Facades\File;

class PressFileParser extends PressBaseParser
{
	protected $filename;

	public function __construct($s, $identifier, $templates = [])
	{
		$this->identifier = $identifier;
		$this->filename = $s;

		$this->splitFile();
		$this->explodeData();
		$this->processFields();
	}

	private function splitFile() {

		$this->rawData = File::get( $this->filename );
		$this->matchData($this->templates[ "ALL_CONTENT" ], $this->rawData);

	}
}