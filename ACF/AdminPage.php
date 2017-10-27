<?php

namespace Badah\WpSupport\ACF;

class AdminPage {

	protected $parent;

	public function add( $title, $is_parent = true ) {
		$page_title = $title;
		$menu_title = $title;

		if ( is_array( $title ) ) {
			$menu_title = $title[1];
		}

		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return new WP_Error( 'dependency', MISSING_ACF );
		}

		if ( $is_parent ) {
			return $this->parent = acf_add_options_page(
				[
					'page_title' => $page_title,
					'menu_title' => $menu_title,
					'redirect' => true,
				]
			);
		}

		if ( ! $is_parent ) {
			return acf_add_options_sub_page(
				[
					'page_title' => $page_title,
					'menu_title' => $menu_title,
					'parent_slug' => $this->parent['menu_slug'],
				]
			);
		}
	}

	public function setParentSlug( $parent_slug ) {
		$this->parent['menu_slug'] = $parent_slug;
	}

	public function getParentSlug() {
		return $this->parent['menu_slug'];
	}
}
