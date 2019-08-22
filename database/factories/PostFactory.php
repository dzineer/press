<?php

use Dzineer\Press\Models\Post;
use Illuminate\Support\Str;

$factory->define(
	Post::class,
	function (Faker\Generator $faker) {
		return [
			'identifier' => Str::random(),
			'slug' => Str::slug($faker->word),
			'title' => $faker->sentence,
			'body' => $faker->paragraph,
			'extra' => json_encode(['test' => 'value'])
		];
	}
);