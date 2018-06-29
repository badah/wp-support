<?php

namespace Badah\WpSupport\Components;

class Admin_Page {

	protected $title;
	protected $slug;
	protected $view;
	protected $parent;
	protected $position;

	public function add( $title, callable $view, $parent = null, $position = null ) {
		$this->title = $title;
		$this->slug = sanitize_title( $this->title ) . 'php';
		$this->view = $view;
		$this->parent = $parent;
		$this->position = $position;

		add_action( 'admin_menu', [ $this, 'add_menu_page' ] );

		return $this;
	}

	public function add_menu_page() {
		if ( null !== $this->parent ) {
			add_submenu_page(
				$this->parent->slug,
				$this->title,
				$this->title,
				'manage_options',
				$this->slug,
				$this->view
			);
			return;
		}

		add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->slug,
			$this->view,
			'dashicons-tickets',
			$this->position
		);
	}
}
