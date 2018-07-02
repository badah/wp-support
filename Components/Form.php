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

	protected $page;

	public function __construct( $fields, $page ) {
		$this->fields = $fields;
		$this->page = $page;
	}

	/**
	 * @todo Improve method in order to detect if current page has a form to submit.
	 * @return bool
	 */
	public function is_submited() {
		if ( ! isset( $_POST ) && empty( $_POST ) ) {
			return false;
		}

		foreach ( $this->fields as $name => $properties ) {
			if ( isset( $_POST[ $name ] ) ) {
				continue;
			} else {
				return false;
			}
		}
		return true;
	}

	public static function get_value( $field, $default = '' ) {
		return isset( $_POST[ $field ] ) ? $_POST[ $field ] : $default;
	}
}
