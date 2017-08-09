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

	public function is_submited() {

//		global $post;
//
//		// TODO: Improve target specificity and maybe remove this check.
//		if ( ! is_object( $post ) ) {
//			return false;
//		}
//
//		if ( ! has_shortcode( $post->post_content, str_replace( '-', '_', $this->page ) ) ) {
//			return false;
//		}

		if ( empty( $_POST ) ) {
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
