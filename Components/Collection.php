<?php

namespace StudioVisual\Support\Components;

/**
 * Class Collection
 *
 * @package StudioVisual\Support\Components
 */
class Collection
{
	public static function order_by( $field, $array ) {
		usort( $array, function( $a, $b ) use ( $field, $array ) {
			return $a[$field] - $b[$field];
		});
		return $array;
	}
}
