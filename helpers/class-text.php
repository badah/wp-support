<?php

namespace Badah\WpSupport\Helpers;

class Text {

	/**
	 * Converts text to snake case format
	 *
	 * @param  string $string   Text to be converted.
	 * @return string           Converted text.
	 */
	public static function to_snake_case( $string ) {
		return str_replace( '-', '_', $string );
	}

	/**
	 * Converts text to camel case format
	 *
	 * @param $string   Text to be converted.
	 * @return string   Converted text.
	 *
	 * @todo Cover more possible situations. E.g.: `foo`, `Foo Bar`,`['foo-bar', 'barFoo']`, ``, etc.
	 */
	public static function to_camel_case( $string ) {

		$pieces    = explode( '-', $string );
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

	/**
	 * Get only numbers from a query_string
	 *
	 * @param  string $subject   String to be filtered.
	 * @return string            Filtered string with only numbers.
	 */
	public static function only_numbers( $subject ) {
		return preg_replace( '/[^0-9]/', '', (string) $subject );
	}
}
