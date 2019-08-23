<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Data Driver
	|--------------------------------------------------------------------------
	|
	| Here you can specify the driver class that you want to support.
	| This allows us to extend the Driver class to anything we want.
	|
	*/

	'driver' => 'file',

	/*
	|--------------------------------------------------------------------------
	| File Driver Options
	|--------------------------------------------------------------------------
	|
	| Here you can specify any configuration options that should be used with
	| the file driver. The path option is a path to the directory with all
	| the markdown files that will be processed inside the command.
	|
	| Supported: "file", "database"
	|
	*/

	'file' => [
		'path' => 'blogs',
	],

	/*
	|--------------------------------------------------------------------------
	| Routes Options
	|--------------------------------------------------------------------------
	|
	| Here you can specify any configuration options that should be used with
	| routes. To prevent URL path collisions, the path option is a prefix to
	| the URL when accessing our unique defined routes.
	|
	*/

	'routes' => [
		'path' => 'blogs'
	]

];