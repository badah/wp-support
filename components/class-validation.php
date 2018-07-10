<?php

namespace Badah\WpSupport\Components;

/**
 * Validation class
 */
class Validation {

	protected $error_handler;

	protected $rules;

	public function __construct( $input, $rules, $error_handler ) {
		$this->error_handler = $error_handler;
	}
}
