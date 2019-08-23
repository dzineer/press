<?php

namespace Dzineer\Press\Parsers;

use Illuminate\Support\Str;

abstract class PressBaseParser
{
	protected $rawData;
	protected $data;
	protected $extra = [];
	protected $type;

	protected $templates = [
		"ALL_CONTENT" => '/^\-{3}(.*?)\-{3}(.*)/s',
		"SECTION" => '/(.*):\s?(.*)/'
	];

	protected $identifier;

	public function __construct($s, $identifier, $templates = [])
	{
		$this->identifier = $identifier;

		if (count($templates)) {
			$this->templates = $templates;
		}

		$this->matchData( $this->templates[ "ALL_CONTENT" ], $s);
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

	protected function matchData($expression, $text) {

		// dd([$expression, $text, $this->rawData]);
		//dnd("text: ", $this->rawData);
		//var_dump($this->rawData);
		preg_match(
			$expression,
			$text,
			$this->rawData
		);
		//echo "\nafter preg_match\n";
	}

	protected function explodeData() {
		$sections = explode("\n", trim($this->rawData[1]));

		foreach( $sections as $section ) {
			//var_dump($section);
			$pattern = $this->templates[ "SECTION" ];
			preg_match( $pattern, $section, $pieces);
			$this->data[ $pieces[1] ] = $pieces[2];
		}

		$this->data['body'] = trim($this->rawData[2]);
	}

	protected function processFields() {

		foreach ($this->data as $field => $value) {

			$class = "Dzineer\\Press\\Fields\\" . Str::title($field);

			if ( class_exists( $class ) && method_exists($class, 'process')) {
				$this->processField( $class, $field, $value );
			} else {
				$this->processExtraField( $field, $value );
			}
		}

		if (count($this->extra)) {
			$this->data['extra'] = $this->extra;
		}

	}

	/**
	 * @param $field
	 * @param $value
	 */
	protected function processExtraField( $field, $value ) {
		$class           = "Dzineer\\Press\\Fields\\Extra";
		$result          = $class::process( $field, $value );

		if (!count($this->extra)) {
			$this->extra = [];
		}

		$this->extra = array_merge( $this->extra, json_decode($result, true) );
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