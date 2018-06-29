<?php

namespace Badah\WpSupport\Components;

use Badah\WpSupport\Contracts\Template_Interface;

class Shortcode implements Template_Interface {

	protected $name;
	protected $data;
	protected $path;

	public function __construct( $name, $data, $path ) {
		$this->name = $name;
		$this->data = $data;
		$this->path = $path;
		$this->register();
	}

	public function register() {
		add_shortcode( $this->name, array( $this, 'build' ) );
	}

	public function getTemplatePath() {
		return $this->path . '/' . $this->name . '.php';
	}

	public function build( $atts, $content = null ) {
		ob_start();
		include $this->getTemplatePath();
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	public function render() {
		echo do_shortcode( "[{$this->name}]" );
	}
}
