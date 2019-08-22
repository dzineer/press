<?php

namespace Dzineer\Press;

class MarkdownParser {
	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public static function parse( string $string ) {

		return \Parsedown::instance()->text( $string );

	}
}