<?php

namespace Badah\WpSupport\Components;

use Badah\WpSupport\Contracts\TemplateInterface;

class View implements TemplateInterface {

	private $name;
	private $data;

	public function __construct( $name, $data ) {
		$this->name = $name;
		$this->data = $data;
		$this->register();
	}

	public function getTemplatePath() {
		return $this->getPath( $this->name );
	}

	public function register() {
		ob_start();
		include $this->getTemplatePath();
		$html = ob_get_contents();
		ob_end_clean();

		echo $html;
	}

	public static function getPath( $filename ) {
		return PLUGIN_ROOT_PATH . 'app/Partials/Views/' . $filename . '.php';
	}
}
