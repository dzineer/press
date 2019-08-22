<?php

namespace Dzineer\Press\Tests\Feature;

use Dzineer\Press\MarkdownParser;
use Orchestra\Testbench\TestCase;

class MarkdownTest extends TestCase
{
	/** @test */
	public function simple_markdown_is_parsed() {

		$this->assertEquals(
			"<h1>Heading</h1>",
			MarkdownParser::parse('# Heading')
		);

	}
}