<?php

namespace Badah\WpSupport\Components;

class Page {

	public static function is_login() {
		return 'wp-login.php' === $GLOBALS['pagenow']
			|| '/login' === $_SERVER['REQUEST_URI']
			|| '/login-dev' === $_SERVER['REQUEST_URI'];
	}

	public static function is_logout() {
		return isset( $_REQUEST['action'] ) && 'logout' === $_REQUEST['action']; // WPCS: CSRF ok.
	}
}
