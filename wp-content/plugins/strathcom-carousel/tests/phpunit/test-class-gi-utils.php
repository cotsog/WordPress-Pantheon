<?php
/**
 * Tests for the GI_Utils class.
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Test_GI_Utils.
 *
 * @package StrathcomCarousel
 */
class Test_GI_Utils extends \WP_UnitTestCase {
	/**
	 * The Plugin Instance.
	 *
	 * @var class Plugin.
	 */
	public $plugin;

	/**
	 * The GI_Utils class.
	 *
	 * @var GI_Utils class.
	 */
	public $utils;

	/**
	 * Setup the tests
	 */
	public function setUp() {
		parent::setup();
		$this->plugin = get_plugin_instance();
		$this->utils = $this->plugin->gi_utils;
	}

	/**
	 * Test get_incentives.
	 */
	public function test_get_incentives() {
		// Should return an array.
		$incentives = $this->utils->get_incentives();
		$this->assertTrue( is_array( $incentives ) );

		// Should actually return results.
		switch_to_blog( 1 );
		$this->factory()->post->create_and_get( array( 'post_type' => Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES ) );
		restore_current_blog();

		$this->assertEquals( count( $this->utils->get_incentives() ), 1 );
	}

	/**
	 * Test save_post.
	 */
	public function test_save_post() {
		/*
		 * save_post() should work with empty input data, however,
		 * it depends upon validate_input_data to ensure all keys are set.
		 *
		 * Once these keys are set, save_post() should always generate a post.
		 *
		 * save_post() is called from within ajax_save_incentive(), which always
		 * uses validate_input_data().
		 *
		 * What follows is a quick way to ensure all expected array keys are set.
		 */
		$test_data = $this->utils->validate_input_data( array() );

		$id = $this->utils->save_post( $test_data );
		$this->assertTrue( is_numeric( $id ) );

		// Ensure the post has data.
		$post = get_post( $id );
		$this->assertTrue( is_string( $post->post_status ) );
		$this->assertEquals( Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES, $post->post_type );

		/*
		 * Ensure save_post saves expected post meta.
		 */

		// Test that save_post saves the Carousel post meta.
		$carousels = get_post_meta( $id, GI_Utils::POST_META_CAROUSELS, true );
		$this->assertTrue( is_array( $carousels ) );

		// Test that save_post saves the "Time" post meta.
		$time_array = get_post_meta( $id, GI_Utils::POST_META_TIME, true );
		$this->assertTrue( is_array( $time_array ) );
		$this->assertTrue( ! empty( $time_array ) );

		// Test that save_post saves the slide select post meta.
		$slide_select = get_post_meta( $id, Slide_Admin::POST_META_SLIDE_SELECT, true );
		$this->assertEquals( 'manual', $slide_select );

		// Test that save_post saves the slide url post meta.
		$slide_url = get_post_meta( $id, Slide_Admin::POST_META_SLIDE_URL, true );
		$this->assertEquals( '', $slide_url );
	}

	/**
	 * Test delete_transients();
	 */
	public function test_delete_transients() {
		set_site_transient( GI_Utils::TRANSIENT_GET_INCENTIVES, array(), 60 * 60 * 24 );
		set_site_transient( GI_Utils::TRANSIENT_GET_SINGLE_INCENTIVE_CAROUSELS, array(), 60 * 60 * 24 );

		$this->utils->delete_transients();
		$this->assertEquals( false, get_site_transient( GI_Utils::TRANSIENT_GET_INCENTIVES ) );
		$this->assertEquals( false, get_site_transient( GI_Utils::TRANSIENT_GET_SINGLE_INCENTIVE_CAROUSELS ) );

	}

	/**
	 * Test explode_carousel_values.
	 */
	public function test_explode_carousel_values() {

		// Test no input array.
		$output = $this->utils->explode_carousel_values();
		$this->assertTrue( is_array( $output ) );
		$this->assertTrue( empty( $output ) );

		// Test vaild input.
		$test_input = array(
			'1|11',
			'1|22',
			'2|33',
			'3',
		);

		$expected_output = array(
			'1' => array(
				'11',
				'22',
			),
			'2' => array(
				'33',
			),
		);

		$output = $this->utils->explode_carousel_values( $test_input );
		$this->assertTrue( is_array( $output ) );
		$this->assertEquals( $expected_output, $output );
	}

	/**
	 * Test test_input_to_data.
	 */
	public function test_input_to_date() {

		// Test what happens if no input is found.
		$output = $this->utils->input_to_date();
		$this->assertEquals( '', $output );

		// Test to ensure a date comes out correctly.
		$output = $this->utils->input_to_date( '4/3/2017', '01', '15' );
		$this->assertEquals( '2017-04-03 01:15:00', $output );
	}

	/**
	 * Test validate_input_data.
	 */
	public function test_validate_input_data() {
		$output = $this->utils->validate_input_data();
		$count = count( $output );
		$this->assertEquals( '13', $count );

		// Make sure data fields get set.
		$result = $this->utils->validate_input_data(
			array(
				'post_id'          => 1,
				'title'            => 'Test',
				'img_id'           => 2,
				'start_date'       => '2016-01-01',
				'end_date'         => '2016-01-02',
				'slide_url'        => 'http://test.com',
				'slide_url_target' => '_blank',
				'slide_page'       => 3,
				'start_hours'      => '01',
				'start_mins'       => '01',
				'end_hours'        => '02',
				'end_mins'         => '02',
				'carousels'        => array( 'test' ),
			)
		);

		$this->assertEquals( 1, $result['post_id'] );
		$this->assertEquals( 'Test', $result['title'] );
		$this->assertEquals( 2, $result['img_id'] );
		$this->assertEquals( '2016-01-01', $result['start_date'] );
		$this->assertEquals( '2016-01-02', $result['end_date'] );
		$this->assertEquals( 'http://test.com', $result['slide_url'] );
		$this->assertEquals( '_blank', $result['slide_url_target'] );
		$this->assertEquals( 3, $result['slide_page'] );
		$this->assertEquals( '01', $result['start_hours'] );
		$this->assertEquals( '01', $result['start_mins'] );
		$this->assertEquals( '02', $result['end_hours'] );
		$this->assertEquals( '02', $result['end_mins'] );
		$this->assertEquals( array( 'test' ), $result['carousels'] );
	}

	/**
	 * Test validate_post_data.
	 */
	public function test_validate_post_data() {
		$output = $this->utils->validate_post_data( '1' );
		$count = count( $output );
		$this->assertEquals( '15', $count );

		// Make sure the correct data is returned.
		$date    = date( 'Y/m/d H:i', time() );
		$post_id = $this->factory()->post->create(
			array(
				'post_title' => 'Test',
				'post_date'  => $date,
			)
		);

		$attachment_id = $this->factory->attachment->create_object( 'test.jpg', $post_id, array(
			'post_mime_type' => 'image/jpeg',
			'post_type' => 'attachment',
		) );

		set_post_thumbnail( $post_id, $attachment_id );

		update_post_meta( $post_id, GI_Utils::POST_META_TIME, array(
			'start_date'  => '01',
			'start_hours' => '01',
			'start_mins'  => '01',
			'end_date'    => '02',
			'end_hours'   => '02',
			'end_mins'    => '02',
		) );

		update_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_URL, 'http://test.com' );
		update_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_URL_TARGET, '_blank' );
		update_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_PAGE, 1 );
		update_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_SELECT, 'page' );
		update_post_meta( $post_id, GI_Utils::POST_META_CAROUSELS, array( 'test' ) );

		$result = $this->utils->validate_post_data( $post_id );

		$this->assertEquals( $post_id, $result['post_id'] );
		$this->assertEquals( 'Test', $result['title'] );
		$this->assertEquals( $date, $result['post_date'] );
		$this->assertEquals( $attachment_id, $result['img_id'] );
		$this->assertEquals( '01', $result['start_date'] );
		$this->assertEquals( '01', $result['start_hours'] );
		$this->assertEquals( '01', $result['start_mins'] );
		$this->assertEquals( '02', $result['end_date'] );
		$this->assertEquals( '02', $result['end_hours'] );
		$this->assertEquals( '02', $result['end_mins'] );
		$this->assertEquals( 'http://test.com', $result['slide_url'] );
		$this->assertEquals( '_blank', $result['slide_url_target'] );
		$this->assertEquals( 1, $result['slide_page'] );
		$this->assertEquals( 'page', $result['slide_select'] );
		$this->assertEquals( array( 'test' ), $result['carousels'] );
	}
}
