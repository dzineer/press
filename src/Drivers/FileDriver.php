<?php

namespace Dzineer\Press\Drivers;

use Dzineer\Press\Exceptions\FileDriverDirectoryNotFoundException;
use Dzineer\Press\Factories\PressParserFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileDriver extends Driver {

	public function fetchPosts() {
		// Fetch all posts
		$files = File::files(
			$this->config['path']
		);

		foreach($files as $file) {

			$this->parse(
				$file->getPathname(),
				$file->getFilename()
			);

		}

		return $this->posts ?? [];
	}


	protected function validateSource() {
		if ( ! File::exists(
			$this->config['path']
		)) {
			throw new FileDriverDirectoryNotFoundException(
			'Directory at \''. $this->config['path'] . '\' does not exist.' .
			         'Check the directory path in the config file.'
			);
		}
	}

	protected function parse( string $content, string $identifier ) {
		// $this->posts = (new PressTextParser($content, [], $identifier));
		$this->posts[] = array_merge(
			(PressParserFactory::Create("file", $content, $identifier))->getData(),
			["identifier" => Str::slug($identifier)]
		);
	}

}