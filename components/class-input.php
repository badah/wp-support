<?php
/**
 * Sanitize and validate user data
 *
 * @package WpSupport
 * @subpackage Components
 */

namespace Badah\WpSupport\Components;

/**
 * Deals with data sent to the system from user
 */
class Input {

	/**
	 * A WP nonce hash
	 *
	 * @var string
	 */
	protected $nonce_action;

	/**
	 * Field names or identification keys
	 *
	 * @var array
	 */
	protected $fields = [];

	/**
	 * All WP user input should contain a nonce
	 *
	 * @param array   $fields         Field names or identification keys.
	 * @param string  $nonce_action   WP nonce action defined with `wp_nonce_field()` or similar function.
	 */
	public function __construct( $fields, $nonce_action ) {
		$this->fields = $fields;
		$this->nonce_action = $nonce_action;
	}

	/**
	 * Returns clean and safe posted data from a form
	 *
	 * @link https://www.tipsandtricks-hq.com/introduction-to-wordpress-nonces-5357
	 *
	 * @return $mixed   Clean and safe posted data. If not safe, it returns false.
	 */
	public function get_posted() {
		$nonce = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : false;

		if ( ! $nonce || ! wp_verify_nonce( $nonce, $this->nonce_action ) ) {
			return false;
		}

		return array_map(
			function( $field ) {
				return isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( trim( $_POST[ $field ] ) ) ) : '';
			}, $this->fields
		);
	}

	/**
	 * Cleans data posted from a form
	 *
	 * Useful only when a nonce is verified by another part of the system
	 * and is not necessary to verify it again our the verification state is unknown.
	 *
	 * @param  string $field   Field name.
	 * @return string          Clean and safe posted value.
	 */
	public static function get_unverified_posted( $field ) {
		return isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : ''; // WPCS: CSRF ok.
	}
}
