<?php

namespace Badah\WpSupport\Helpers;

class Word {

	static public function to_snake_case( $string ) {
		return str_replace( '-', '_', $string );
	}

	/**
	 * @param $string
	 * @return string
	 * @todo Cover all possible situations. E.g.: `foo`, `Foo Bar`,`['foo-bar', 'barFoo']`, ``, etc.
	 */
	static function to_camel_case( $string ) {
		$pieces = explode( '-', $string );
		$converted = [];

		foreach ( $pieces as $index => $piece ) {
			if ( 0 === $index ) {
				$converted[ $index ] = strtolower( $piece );
			} else {
				$converted[ $index ] = ucfirst( $piece );
			}
		}

		return implode( $converted );
	}
}
