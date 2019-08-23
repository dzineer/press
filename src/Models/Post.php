<?php

namespace Dzineer\Press\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $guarded = [];

	protected $fillable = [
		'identifier',
		'slug',
		'title',
		'body',
		'extra'
	];
}