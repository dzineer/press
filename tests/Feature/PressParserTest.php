<?php

namespace Dzineer\Press\Tests;

use Carbon\Carbon;
use Dzineer\Press\PressParser;

class PressParserTest extends TestCase {

	/** @test */
	public function the_head_and_body_gets_split() {
		$PressParser = (new PressParser("file",__DIR__ . '/../blogs/MarkFile1.md'));

		$data = $PressParser->getRawData();

		$this->assertStringContainsString(
			'title: My Title',
			$data[1]
		);

		$this->assertStringContainsString(
			'description: Description here',
			$data[1]
		);

		$this->assertStringContainsString(
			'Blog post body here',
			$data[2]
		);

	}

	/**
	 * @test
	 */
	public function each_head_field_gets_separated() {
		// title: My Title
		// 'title' => 'My Title'

		$PressParser = (new PressParser("file",__DIR__ . '/../blogs/MarkFile1.md'));
		$data = $PressParser->getData();

		$this->assertEquals(
			'<p>My Title</p>',
			$data['title']
		);

		$this->assertEquals(
			'<p>Description here</p>',
			$data['description']
		);

    }

	/**
	 * @test
	 */
	public function the_body_get_saved_and_trimmed() {

		$PressParser = (new PressParser( "file", __DIR__ . '/../blogs/MarkFile1.md'));
		$data = $PressParser->getData();

		$this->assertEquals(
			"<h1>Heading</h1>\n<p>Blog post body here</p>",
			$data['body']
		);

    }

	/**
	 * @test
	 */
	public function a_string_can_also_be_used_instead() {

		//$s = File::get( __DIR__ . "/../blogs/strings/MarkFile1.txt" );
		$PressParser = (new PressParser("string", "---\ntitle: My Title\ndescription: Description here\n---\n\n# Heading\n\nBlog post body here"));
		$data =  $PressParser->getData();

		$this->assertEquals(
			"<h1>Heading</h1>\n<p>Blog post body here</p>",
			$data['body']
		);

    }

	/**
	 * @test
	 */
	public function a_date_field_gets_parsed() {

		$PressParser = (new PressParser("string", "---\ndate: May 14, 1988\n---\n"));
		$data =  $PressParser->getData();

		$this->assertInstanceOf(Carbon::class, $data['date'] );
		$this->assertEquals('05/14/1988', $data['date']->format('m/d/Y') );

	}

	/**
	 * @test
	 */
	public function an_extra_field_gets_saved() {
		$PressParser = (new PressParser("string", "---\nauthor: John Doe\n---\n"));
		$data =  $PressParser->getData();
		$this->assertEquals( json_encode(['author' => 'John Doe']), $data['extra_json']);
    }

	/**
	 * @test
	 */
	public function two_additional_fields_are_put_into_extra() {
		$PressParser = (new PressParser("string", "---\nauthor: John Doe\nimage: some/image\n---\n"));
		$data =  $PressParser->getData();
		$this->assertEquals( json_encode(['author' => 'John Doe', 'image' => 'some/image']), $data['extra_json'] );
    }

}