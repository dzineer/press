<?php

namespace Dzineer\Press;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PressParser
{
	protected $filename;
	protected $rawData;
	protected $data;
	protected $extraData = [];
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

	public function getRawData()
	{
		return $this->rawData;
	}

	private function splitFile() {

		$fileData = File::get( $this->filename );
		$this->matchData($this->templates[ "ALL_CONTENT" ], $fileData);

	}

	protected function matchData($expression, $text) {
		preg_match(
			$expression,
			$text,
			$this->rawData
		);
	}

	protected function explodeData() {

		$sections = explode("\n", trim($this->rawData[1]));

		foreach( $sections as $section ) {
			$pattern = $this->templates[ "SECTION" ];
			preg_match( $pattern, $section, $pieces);
			$this->data[ $pieces[1] ] = $pieces[2];
		}

		$this->data['body'] = trim($this->rawData[2]);
	}

	protected function processFields() {

		foreach ($this->data as $field => $value) {

			$class = "Dzineer\\Press\\Fields\\" . Str::title($field);
			if (! class_exists( $class ) && ! method_exists($class, 'process')) {
				$this->processExtraField( $field, $value );
			} else {
				$this->processField( $class, $field, $value );
			}

		}

		if($this->extraData) {
			$this->data['extra'] = $this->extraData;
			$this->data['extra_json'] = json_encode($this->extraData);
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
	/**
	 * @param $field
	 * @param $value
	 */
	protected function processExtraField( $field, $value ) {
		$class           = "Dzineer\\Press\\Fields\\Extra";
		$result          = $class::process( $field, $value );
		$this->extraData = array_merge( $this->extraData, $result );
	}

	/**
	 * @param string $class
	 * @param $field
	 * @param $value
	 * @param $result
	 */
	protected function processField( $class, $field, $value ) {
		$result     = $class::process( $field, $value );
		$this->data = array_merge( $this->data, $result );
	}
}