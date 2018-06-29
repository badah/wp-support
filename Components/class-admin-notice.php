<?php

namespace Badah\WpSupport\Components;

class Admin_Notice {

	private $message;
	private $type;
	private $is_dismissible;

	public function __construct( $message, $type, $is_dismissible = true ) {
		$this->message = $message;
		$this->type = $type;
		$this->is_dismissible = $is_dismissible;

		add_action( 'admin_notices', [ $this, 'render' ] );
	}

	public function render() {
		$dismissible = ($this->is_dismissible) ? 'is-dismissible' : ''; ?>
		<div class="notice notice-<?php echo $this->type; // WPCS: XSS ok. ?> <?php echo $dismissible; // WPCS: XSS ok. ?>">
			<p><?php echo $this->message; // WPCS: XSS ok. ?></p>
		</div> 
		<?php
	}

	public static function display( $message, $type = 'info', $is_dismissible = true ) {
		new self( $message, $type, $is_dismissible );
	}
}
