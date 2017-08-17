<?php

namespace StudioVisual\Support\Components;

/**
 * Class Collection
 *
 * @package StudioVisual\Support\Components
 */
class Collection
{
	public static function order_by( $field, &$array ) {
		usort( $array, function( $a, $b ) use ( $field, $array ) {
			return $a[$field] - $b[$field];
		});
	}

	/**
	 * @param $array
	 * @param $callback
	 * @param $field
	 * @todo verify if callback is callable
	 */
	public static function format( &$array, $callback, $field ) {
		array_walk_recursive( $array, function( &$input, $key, $field ) use ( $callback ) {
			if ( $key === $field ) {
				$input = call_user_func( $callback, $input );
			}
		}, $field );
	}
}
