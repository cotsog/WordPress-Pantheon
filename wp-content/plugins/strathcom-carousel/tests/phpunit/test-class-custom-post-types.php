<?php
/**
 * Tests for Custom_Post_Types class.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Tests for Custom_Post_Types class.
 *
 * @package StrathcomCarousel
 */
class Test_Custom_Post_Types extends \WP_UnitTestCase {
	/**
	 * The Plugin class.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * Abbreviate the CPT class.
	 *
	 * @var Custom_Post_Types class.
	 */
	public $cpts;

	/**
	 * Set up testing.
	 */
	public function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();
		$this->cpts = $this->plugin->custom_post_types;
	}

	/**
	 * Tests Action/Filter hooks.
	 */
	public function test_construct() {
		$this->assertEquals( 5, has_action( 'init', array( $this->cpts, 'register_cpt_slide' ) ) );
		$this->assertEquals( 5, has_action( 'init', array( $this->cpts, 'register_cpt_carousel' ) ) );
		$this->assertEquals( 11, has_filter( 'strathcom_expire_posts_post_types', array( $this->cpts, 'add_slides_to_filter_array' ) ) );
	}
}
