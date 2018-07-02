<?php

namespace StudioVisual\Support\Components;

class StringFormat {

	public static function convert_camel_case( $string, $us = '-' ) {
		$regex = '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/';
	    return strtolower( preg_replace( $regex, $us, $string ) );
	}

	public static function price( $string ) {
		return number_format( (string) $string, 2, ',', '.' );
	}

	public static function only_numbers( $string ) {
		return preg_replace( '/[^0-9]/', '', $string );
	}
}
