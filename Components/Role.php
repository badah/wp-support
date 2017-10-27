<?php

namespace Badah\WpSupport\Components;

class Role {

	public function setWpRoles() {
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
