<?php

namespace Dzineer\Press\Console;

use Dzineer\Press\Factories\DriverFactory;
use Dzineer\Press\Factories\PressParserFactory;
use Dzineer\Press\Models\Post;
use Dzineer\Press\Press;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProcessCommand extends Command {

	protected $signature = 'press:process';
	protected $description = 'Updates blog posts.';

	public function handle() {

		if (Press::configNotPublished()) {
			return $this->warn('Please publish the config file by running'.
			                        '\'php artisan vendor:publish --tag=press-config\'');
		}

		try {
			$posts = (new Press)->fetchPosts();

			// dd($posts);

			// Process each file
			foreach($posts as $post) {

				// Persist to the DB
				Post::create([
					'identifier' => $post['identifier'],
					'slug' => Str::slug($post['title']),
					'title' => $post['title'],
					'body' => $post['body'],
					'extra' => isset($post['extra_json']) ?? ''
				]);

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