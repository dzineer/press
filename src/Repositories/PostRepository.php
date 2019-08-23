<?php

namespace Dzineer\Press\Repositories;

use Dzineer\Press\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostRepository {
	public function save($post) {

		Post::updateOrCreate([
			'identifier' => $post['identifier'],
		], [
			'slug' => Str::slug($post['title']),
			'title' => $post['title'],
			'body' => $post['body'],
			'extra' => $this->extra( $post )
		]);

	}

	/**
	 * @param $post
	 *
	 * @return false|mixed|string
	 */
	protected function extra( $post ) {
		// dd('post', $post);
		$extra = $post['extra'];
		$attributes = Arr::except($post, ['title', 'body', 'identifier', 'extra']);
		return json_encode(
			array_merge($extra, $attributes)
		);
	}
}