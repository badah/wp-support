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

		global $post;

		if ( ! has_shortcode( $post->post_content, $this->page ) ) {
			return false;
		}

		if ( empty( $_POST ) ) {
			return false;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				continue;
			} else {
				return false;
			}
		}
		return true;
	}

	public function get_value( $field, $default = '' ) {
		return isset( $_POST[ $field ] ) ? $_POST[ $field ] : $default;
	}
}
