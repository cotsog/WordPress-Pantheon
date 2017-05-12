<?php
/**
 * Tests for the Carousel class.
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Test_Carousel.
 *
 * @package StrathcomCarousel
 */
class Test_Carousel extends \WP_UnitTestCase {
	/**
	 * The Plugin Instance.
	 *
	 * @var class Plugin.
	 */
	public $plugin;

	/**
	 * Setup the tests
	 */
	public function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();

		// Mock the P2P calls.
		$this->carousel = $this->getMockBuilder( '\StrathcomCarousel\Carousel' )
			->setConstructorArgs( array( $this->plugin ) )
			->setMethods( array( 'get_connected_slides' ) )
			->getMock();

		// Factory data.
		$slide_id = $this->factory()->post->create();

		$attachment_id = $this->factory->attachment->create_object( 'test.jpg', $slide_id, array(
			'post_mime_type' => 'image/jpeg',
			'post_type' => 'attachment',
		) );

		wp_update_attachment_metadata( $attachment_id, array( 'width' => 1200, 'height' => 675 ) );

		set_post_thumbnail( $slide_id, $attachment_id );

		update_post_meta( $slide_id, 'slide_url', 'http://test.com' );
		update_post_meta( $slide_id, 'slide_url_target', '1' );
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', 'Test Alt' );

		$connected_slides = (object) array( 'posts' => array( (object) array( 'ID' => $slide_id, 'post_status' => 'publish', 'post_type' => Plugin::CPT_SLUG_SLIDE ) ) );
		$this->carousel->method( 'get_connected_slides' )->will( $this->returnValue( $connected_slides ) );
	}

	/**
	 * Test get_carousel_timing
	 */
	public function test_get_carousel_timing() {
		$carousel_id = $this->factory()->post->create();
		update_post_meta( $carousel_id, 'timing', 10 );

		$this->assertEquals( $this->carousel->get_carousel_timing( $carousel_id ), 10000 );

		wp_delete_post( $carousel_id );
	}

	/**
	 * Test get_carousels
	 */
	public function test_get_carousels() {
		$carousel_1 = $this->factory()->post->create( array( 'post_type' => Plugin::CPT_SLUG_CAROUSEL, 'post_title' => 'Carousel 1' ) );
		$carousel_2 = $this->factory()->post->create( array( 'post_type' => Plugin::CPT_SLUG_CAROUSEL, 'post_title' => 'Carousel 2' ) );

		$this->assertEquals( $this->carousel->get_carousels(), [ [ 'ID' => $carousel_2, 'title' => 'Carousel 2' ], [ 'ID' => $carousel_1, 'title' => 'Carousel 1' ] ] );

		wp_delete_post( $carousel_1 );
		wp_delete_post( $carousel_2 );
	}

	/**
	 * Test get_slides
	 */
	public function test_get_slides() {
		$carousel_id = $this->factory()->post->create();

		$slides = array(
			(object) array(
				'link'          => 'http://test.com',
				'link_target'   => '1',
				'image'         => (object) array(
					'url'    => 'http://example.org/wp-content/uploads/test.jpg',
					'width'  => 1200,
					'height' => 675,
					'alt'    => 'Test Alt',
					'title'  => '',
				),
			),
		);

		$this->assertEquals( $this->carousel->get_slides( $carousel_id ), $slides );

		wp_delete_post( $carousel_id );
	}
}
