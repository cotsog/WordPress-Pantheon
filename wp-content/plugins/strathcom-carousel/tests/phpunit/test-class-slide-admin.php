<?php
/**
 * Tests for the Slide Admin class.
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Test_Slide_Admin.
 *
 * @package StrathcomCarousel
 */
class Test_Slide_Admin extends \WP_UnitTestCase {
	/**
	 * The Plugin Instance.
	 *
	 * @var class Plugin.
	 */
	public $plugin;

	/**
	 * The Slide_Admin Instance.
	 *
	 * @var class Slide_Admin.
	 */
	public $slide_admin;

	/**
	 * Setup the tests
	 */
	public function setUp() {
		$this->plugin       = get_plugin_instance();
		$this->slide_admin  = $this->getMockBuilder( '\StrathcomCarousel\Slide_Admin' )
			->setConstructorArgs( array( $this->plugin ) )
			->setMethods( array( 'get_image_size' ) )
			->getMock();
	}

	/**
	 * Test check_image_size
	 */
	public function test_check_image_size() {
		// Mock the get_image_size method since we're going to use fake images.
		$this->slide_admin->method( 'get_image_size' )->will( $this->onConsecutiveCalls( array( 800, 450 ), array( 100, 100 ) ) );

		// Empty image.
		$this->assertEquals( $this->slide_admin->check_image_size( false ), true );

		// Valid image size.
		$this->assertEquals( $this->slide_admin->check_image_size( 'test.jpg' ), true );

		// Invalid image size.
		$this->assertEquals( $this->slide_admin->check_image_size( 'test.jpg' ), false );
	}
}
