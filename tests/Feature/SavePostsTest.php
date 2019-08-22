<?php

namespace Dzineer\Press\Tests;

use Dzineer\Press\MarkdownParser;
use Dzineer\Press\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SavePostsTest extends TestCase
{
	/** @test */
	public function a_post_can_be_created_with_the_factory() {

		$post = factory(Post::class)->create();

		var_dump($post);

		$this->assertCount(1, Post::all());

	}
}