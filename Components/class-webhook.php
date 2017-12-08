<?php

namespace Badah\WpSupport\Components;

/**
 * Class Webhook
 *
 * Example/Usage:
 *
 * $conditions = ! isset( $body['form_response']['hidden']['user_id'] ) || ! isset( $body['form_response']['hidden']['post_id'] );
 * $action = function() {
 *     if ( learndash_process_mark_complete( $body['form_response']['hidden']['user_id'], $body['form_response']['hidden']['post_id'] ) ) {
 *          $body['learndash_process_mark_complete'] = 'true';
 *     } else {
 *          $body['learndash_process_mark_complete'] = 'false';
 *     }
 * };
 * $webhook = new Webhook( $conditions, $action );
 * $webhook->call()->log();
 *
 * @package Badah\WpSupport\Components
 */
class Webhook {

	/**
	 * @var array
	 */
	protected $payload = [];

	public function __construct( $conditions, callable $action ) {
		$this->watch();
	}

	public function watch() {
		$this->payload = file_get_contents( 'php://input' );
		$this->payload = ! empty( $this->payload ) ? json_decode( $this->payload, true ) : $this->payload;
		return $this;
	}

	public function call( $conditions, $action ) {
		if ( $conditions ) {
			call_user_func( $action );
		}
		return $this;
	}

	public function log() {
		$file = fopen( getcwd() . '/webhook.log', 'a' );
		$txt = '';
		$txt .= '[' . date( 'Y/m/d H:i:s' ) . '] ' . json_encode( $this->payload ) . PHP_EOL;
		fwrite( $file, $txt );
		fclose( $file );
	}
}
