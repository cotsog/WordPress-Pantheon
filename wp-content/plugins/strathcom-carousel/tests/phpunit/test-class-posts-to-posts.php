<?php
/**
 * Tests for Posts_To_Posts class.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Tests for Posts_To_Posts class.
 *
 * @package StrathcomCarousel
 */
class Test_Posts_To_Posts extends \WP_UnitTestCase {
	/**
	 * The Plugin class.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * Abbreviate the Posts_To_Posts class.
	 *
	 * @var Posts_To_Posts class.
	 */
	public $p2p;

	/**
	 * Set up testing.
	 */
	public function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();
		$this->p2p = new Posts_To_Posts( $this->plugin );
	}

	/**
	 * Tests Action/Filter hooks.
	 */
	public function test_construct() {
		$this->assertEquals( 10, has_action( 'admin_enqueue_scripts', array( $this->p2p, 'admin_scripts' ) ) );
		$this->assertEquals( 10, has_action( 'p2p_init', array( $this->p2p, 'register_p2p_connection' ) ) );
		$this->assertEquals( 10, has_filter( 'p2p_connected_title', array( $this->p2p, 'add_image_to_p2p_title' ) ) );
		$this->assertEquals( 10, has_filter( 'p2p_candidate_title', array( $this->p2p, 'add_image_to_p2p_title' ) ) );
	}
}
