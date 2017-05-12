<?php
/**
 * Tests for the Graphical Incentives List class
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Test_GI_List
 *
 * @package StrathcomCarousel
 */
class Test_GI_List extends \WP_UnitTestCase {
	/**
	 * The Plugin class.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * Setup the tests
	 */
	public function setUp() {
		parent::setUp();

		$this->plugin = get_plugin_instance();
	}

	/**
	 * Test get_carousel_count
	 */
	public function test_get_carousel_count() {
		$this->assertEquals( $this->plugin->gi_list->get_carousel_count( array( 1 ) ), '1 Carousel' );
		$this->assertEquals( $this->plugin->gi_list->get_carousel_count( array( 1, 2, 3 ) ), '3 Carousels' );
	}

	/**
	 * Test is_expired
	 */
	public function test_is_expired() {
		$post_id1 = $this->factory()->post->create( array( 'post_status' => 'expired' ) );
		$post_id2 = $this->factory()->post->create( array( 'post_status' => 'publish' ) );

		$this->assertTrue( $this->plugin->gi_list->is_expired( $post_id1 ) );
		$this->assertFalse( $this->plugin->gi_list->is_expired( $post_id2 ) );
	}

	/**
	 * Test maybe_render_deleted_message
	 */
	public function test_maybe_render_deleted_message() {
		/**
		 * Test that the message will not be displayed (no GET variable set)
		 */
		ob_start();
		$this->plugin->gi_list->maybe_render_deleted_message();
		$message = ob_get_clean();

		$this->assertTrue( 0 === strlen( $message ) );

		/**
		 * Now test that there a message is going to be dislayed.
		 */
		$_GET['deleted_id'] = 1;

		ob_start();
		$this->plugin->gi_list->maybe_render_deleted_message();
		$message = ob_get_clean();

		$this->assertTrue( strlen( $message ) > 0 );
	}
}
