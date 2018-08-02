<?php

namespace Badah\WpSupport\Components;

use Badah\WpSupport\Contracts\Template_Interface;

class View implements Template_Interface {

	protected $data;
	protected $path;

	public function __construct( $path, $data = null ) {
		$this->data = $data;
		$this->path = $path;

		$this->register();
	}

	public function register() {
		ob_start();
		include $this->path;
		$html = ob_get_contents();
		ob_end_clean();

		echo $html; // WPCS: XSS ok.
	}
}
