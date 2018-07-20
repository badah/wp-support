<?php

namespace Badah\WpSupport\Components;

use Badah\WpSupport\Helpers\Text;

class Ajax_Request {

	protected $script_name;
	protected $script_file_name;
	protected $script_location;
	protected $script_object;
	protected $script_dependencies;
	protected $script_version;

	protected $prefix;
	protected $action;
	protected $arguments;
	protected $scope;
	protected $php_data;

	public function __construct( $prefix, $script_file_name, $script_location, $script_version, $action, $arguments = null, $php_data = [], $scope = 'global' ) {

		$this->scope     = $scope;
		$this->action    = $action;
		$this->arguments = $arguments;

		$this->script_file_name = $script_file_name;
		$this->script_name      = $prefix . '-' . $this->script_file_name;
		$this->script_location  = $script_location;
		$this->script_version   = $script_version;

		$this->script_object       = Text::to_camel_case( $this->script_file_name );
		$this->script_dependencies = [ 'jquery' ];

		$this->php_data = array_merge(
			[
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			],
			$php_data
		);
	}

	protected function register_scripts() {
		if ( ! $this->is_admin() ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		} else {
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->script_name,
			$this->script_location . "ajax-{$this->script_file_name}.js",
			$this->script_dependencies,
			$this->script_version,
			true
		);

		if ( ! $this->is_admin() ) {
			wp_localize_script(
				$this->script_name,
				$this->script_object,
				$this->php_data
			);
		}
	}

	public function register_handle() {
		$obj = Text::to_snake_case( $this->script_file_name );
		add_action( "wp_ajax_{$obj}", [ $this, 'handle' ] );

		if ( ! $this->is_admin() ) {
			add_action( "wp_ajax_no_priv_{$obj}", [ $this, 'handle' ] );
		}
	}

	public function handle() {
		$response = is_callable( $this->action ) ? call_user_func( $this->action, $this->arguments ) : false;
		wp_send_json( $response );
		exit;
	}

	public function register() {
		$this->register_scripts();
		$this->register_handle();
	}

	private function is_admin() {
		return 'admin' === $this->scope;
	}

	public function set_script_location( $location ) {
		$this->script_location = $location;
	}

	public function set_script_version( $script_version ) {
		$this->script_version = $script_version;
	}

	public function set_prefix( $prefix ) {
		$this->prefix = $prefix;
	}
}
