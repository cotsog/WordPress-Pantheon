<?php
/**
 * Add submenus to the Carousel menu.
 *
 * @author  XWP
 *
 * @package StrathcomPersonalization
 */

namespace StrathcomCarousel;

/**
 * Class Admin
 *
 * @package StrathcomCarousel
 */
class Admin {
	/**
	 * The plugin instance
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Class Constructor.
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		add_action( 'admin_menu', array( $this, 'add_submenu_pages' ) );
	}

	/**
	 * Include the CPTs under the Carousel menu item.
	 */
	function add_submenu_pages() {
		add_submenu_page(
			'edit.php?post_type=' . Plugin::CPT_SLUG_CAROUSEL,
			__( 'New Slide', 'strathcom-carousel' ),
			__( 'New Slide', 'strathcom-carousel' ),
			'manage_options',
			'post-new.php?post_type=' . Plugin::CPT_SLUG_SLIDE
		);
	}
}
