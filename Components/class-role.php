<?php

namespace Badah\WpSupport\Components;

class Role {

	/**
	 * @var \WP_Roles WordPress Roles object.
	 */
	protected $wp_roles;

	public function set_wp_roles() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$this->wp_roles = new \WP_Roles();
		}
	}

	public static function remove( $roles ) {
		return array_map(
			function ( $roles ) {
				if ( get_role( $roles ) ) {
					remove_role( $roles );
				}
			}, $roles
		);
	}

	public function add( $role, $display_name, $capabilities ) {
		if ( ! get_role( $role ) ) {
			add_role( $role, $display_name, $capabilities );
		}
	}
}
