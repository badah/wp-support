<?php

namespace StudioVisual\Support\Components;

/**
 * Class Form
 *
 * @package StudioVisual\Support\Components
 */
class Form
{
	protected $fields = [];

	public function __construct( $fields ) {
		$this->fields = $fields;
	}

	public function is_submited() {

		if ( empty( $_POST ) ) {
			return false;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				continue;
			} else {
				echo '<pre>', var_dump($field), '</pre>';
				return false;
			}
		}
		return true;
	}

	public function get_value( $field, $default = '' ) {
		return isset( $_POST[ $field ] ) ? $_POST[ $field ] : $default;
	}
}
