<?php

namespace Dzineer\Press;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PressParser
{
	protected $filename;
	protected $data;
	protected $type;
	protected $templates = [
		"ALL_CONTENT" => '/^\-{3}(.*?)\-{3}(.*)/s',
		"SECTION" => '/(.*):\s?(.*)/'
	];

	public function __construct($type, $s)
	{
		$this->type = $type;

		switch ($this->type) {
			case 'string':
				$this->matchData( $this->templates[ "ALL_CONTENT" ], $s);
				break;
			case 'file':
				$this->filename = $s;
				$this->splitFile();
		}

		$this->explodeData();
		$this->processFields();
	}

	public function getData()
	{
		return $this->data;
	}

	private function splitFile() {

		$fileData = File::get( $this->filename );
		$this->matchData($this->templates[ "ALL_CONTENT" ], $fileData);

	}

	protected function matchData($expression, $text) {
		preg_match(
			$expression,
			$text,
			$this->data
		);
	}

	protected function explodeData() {

		$sections = explode("\n", trim($this->data[1]));

		foreach( $sections as $section ) {
			$pattern = $this->templates[ "SECTION" ];
			preg_match( $pattern, $section, $pieces);
			$this->data[ $pieces[1] ] = $pieces[2];
		}

		$this->data['body'] = trim($this->data[2]);
	}

	protected function processFields() {

		foreach ($this->data as $field => $value) {
			$class = "Dzineer\\Press\\Fields\\" . Str::title($field);
			if (class_exists( $class ) && method_exists($class, 'process')) {
				$result = $class::process($field, $value);
				$this->data = array_merge( $this->data, $result );
			}
		}

	}

/*	protected function processFields() {
		foreach ($this->data as $field => $value) {
			if ($field === 'date') {
				$this->data['date'] = Carbon::parse( $value );
			} else if ($field === 'body') {
				$this->data['body'] = MarkdownParser::parse( $value );
			}
		}
	}
*/

}