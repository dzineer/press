<?php

namespace Dzineer\Press\Console;

use Dzineer\Press\Facades\Press;
use Dzineer\Press\Models\Post;
use Dzineer\Press\Repositories\PostRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ProcessCommand extends Command {

	protected $signature = 'press:process';
	protected $description = 'Updates blog posts.';

	public function handle(PostRepository $post_repository) {

		if (Press::configNotPublished()) {
			return $this->warn('Please publish the config file by running'.
			                        '\'php artisan vendor:publish --tag=press-config\'');
		}

		try {
			$posts = Press::fetchPosts();

			$this->info("Number of posts: " . count($posts));

			// Process each file
			foreach($posts as $post) {
				// Persist to the DB
				$post_repository->save( $post );
			}
		}
		catch(\Exception $e) {
			$this->error(
				$e->getMessage()
			);
		}

		$this->info("Command Successful");
	}
}