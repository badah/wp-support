<?php
/**
 * Admin Page
 *
 * @package Badah\WpSupport\ACF
 */

namespace Badah\WpSupport\ACF;

/**
 * Class Admin_Page
 *
 * @package Badah\WpSupport\ACF
 */
class Admin_Page {

	/**
	 * Parent Page
	 *
	 * @var array - final page settings.
	 */
	protected $parent;

	/**
	 * Add an admin page
	 *
	 * @param string $title     - page title.
	 * @param bool   $is_parent - add as a parent page if true.
	 *
	 * @return \WP_Error
	 */
	public function add( $title, $is_parent = false ) {
		$page_title = $title;
		$menu_title = $title;

		if ( is_array( $title ) ) {
			$menu_title = $title[1];
		}

		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return new WP_Error( 'dependency', MISSING_ACF );
		}

		if ( $is_parent ) {
			$this->parent = acf_add_options_page(
				[
					'page_title' => $page_title,
					'menu_title' => $menu_title,
					'redirect'   => true,
				]
			);

			return $this->parent;
		}

		if ( ! $is_parent ) {
			return acf_add_options_sub_page(
				[
					'page_title'  => $page_title,
					'menu_title'  => $menu_title,
					'parent_slug' => $this->parent['menu_slug'],
				]
			);
		}
	}

	/**
	 * Set up Parent Slug
	 *
	 * @param string $parent_slug - parent slug name.
	 */
	public function set_parent_slug( $parent_slug ) {
		$this->parent['menu_slug'] = $parent_slug;
	}

	/**
	 * Get Parent Slug
	 *
	 * @return mixed
	 */
	public function get_parent_slug() {
		return $this->parent['menu_slug'];
	}
}
