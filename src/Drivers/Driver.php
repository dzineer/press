<?php

namespace Dzineer\Press\Drivers;

use Dzineer\Press\Factories\PressParserFactory;
use Illuminate\Support\Str;

abstract class Driver {

	protected $posts;
	protected $config;

	public function __construct()
	{
		$this->setConfig();
		$this->validateSource();
	}

	public abstract function fetchPosts();

	protected function validateSource() {
		return true;
	}

	protected function setConfig() {
		$this->config = config('press.' . config('press.driver'));
	}

	protected function parse( string $content, string $identifier ) {

		$this->posts[] = array_merge(
			(PressParserFactory::Create("string", $content, $identifier))->getData(),
			["identifier" => Str::slug($identifier)]
		);

	}

}