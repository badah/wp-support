<?php

namespace StudioVisual\Support\Components;

use StudioVisual\Support\Contracts\TemplateInterface;

class Shortcode implements TemplateInterface
{
	protected $name;
	protected $data;
	protected $path;
	protected $atts;

	public function __construct( $name, $data, $path, $atts ) {
		$this->name = $name;
		$this->data = $data;
		$this->path = $path;
		$this->atts = $atts;
		$this->register();
	}

	public function register() {
		add_shortcode( $this->name, array( $this, 'build' ) );
	}

	public function getTemplatePath() {
		return $this->path . '/' . str_replace('_', '-', $this->name ) . '.php';
	}

	public function build( $atts, $content = null ) {

		$atts = shortcode_atts( $this->atts, $atts, $this->name );

		foreach ( $atts as $attr_name => $attr_value ) {
			$$attr_name = $attr_value;
		}

		foreach ( $this->get_data() as $key => $value ) {
			$$key = $value;
		}

		ob_start();
		include $this->getTemplatePath();
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	public function render() {
		echo do_shortcode( "[{$this->name}]" );
	}

	public function print_out( $data ) {
		$this->data = $data;
	}

	protected function get_data() {
		return $this->data;
	}

	public function the_attr( $attr ) {
		echo esc_attr__( $attr );
	}
}
