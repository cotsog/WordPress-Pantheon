<?php
/**
 * Tests for Plugin class.
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Tests for Plugin class.
 *
 * @package StrathcomCarousel
 */
class Test_Plugin extends \WP_UnitTestCase {

	/**
	 * Test constructor.
	 *
	 * @see Plugin::__construct()
	 */
	public function test_construct() {
		$plugin = get_plugin_instance();
		$this->assertEquals( 9, has_action( 'after_setup_theme', array( $plugin, 'init' ) ) );
	}

	/**
	 * Test for init() method.
	 *
	 * @see Plugin::init()
	 */
	public function test_init() {
		$plugin = get_plugin_instance();

		add_filter( 'strathcom_carousel_plugin_config', array( $this, 'filter_config' ), 10, 2 );
		$plugin->init();

		$this->assertInternalType( 'array', $plugin->config );
		$this->assertArrayHasKey( 'foo', $plugin->config );
		$this->assertEquals( 11, has_action( 'wp_default_scripts', array( $plugin, 'register_scripts' ) ) );
		$this->assertEquals( 11, has_action( 'wp_default_styles', array( $plugin, 'register_styles' ) ) );
	}

	/**
	 * Filter to test 'strathcom_carousel_plugin_config'.
	 *
	 * @see Plugin::init()
	 * @param array       $config Plugin config.
	 * @param Plugin_Base $plugin Plugin instance.
	 * @return array
	 */
	public function filter_config( $config, $plugin ) {
		unset( $config, $plugin ); // Test should actually use these.
		return array( 'foo' => 'bar' );
	}

	/* Put other test functions here... */
}
