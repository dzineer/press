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

	public function extra($field) {
		return optional(json_decode($this->extra))->$field;
	}
}