<?php
/**
 * Tests for Archive class.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Tests for Archive class.
 *
 * @package StrathcomCarousel
 */
class Test_Archive extends \WP_UnitTestCase {
	/**
	 * The Plugin class.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * The Archive class.
	 *
	 * @var Archive class.
	 */
	public $archive;

	/**
	 * Our generated Post ID.
	 *
	 * @var int
	 */
	public $test_id;

	/**
	 * Holds our generated carousels.
	 *
	 * @var array
	 */
	public $carousels = array();

	/**
	 * Stores the original Carousel Connections.
	 *
	 * @var bool
	 */
	public $org_connections;

	/**
	 * Set up the Tests.
	 */
	public function setUp() {
		parent::setUp();
		$this->slide1 = $this->factory->post->create( array( 'post_type' => Plugin::CPT_SLUG_SLIDE ) );
		$this->slide2 = $this->factory->post->create( array( 'post_type' => Plugin::CPT_SLUG_SLIDE, 'post_status' => Archive::POST_STATUS ) );

		$this->plugin = get_plugin_instance();

		// Mock the P2P calls.
		$this->archive = $this->getMockBuilder( '\StrathcomCarousel\Archive' )
			->setConstructorArgs( array( $this->plugin ) )
			->setMethods( array( 'get_connected_slides', 'delete_p2p_connection' ) )
			->getMock();
	}

	/**
	 * Tear down the current test
	 */
	public function tearDown() {
		parent::tearDown();
		unset( $this->slide1 );
		unset( $this->slide2 );
	}

	/**
	 * Tests Action/Filter hooks.
	 */
	public function test_construct() {
		$this->assertEquals( 10, has_action( 'init', array( $this->archive, 'archived_post_status' ) ) );
		$this->assertEquals( 10, has_action( 'display_post_states', array( $this->archive, 'add_archived_post_state' ) ) );
		$this->assertEquals( 10, has_filter( 'post_submitbox_misc_actions', array( $this->archive, 'render_ui' ) ) );
		$this->assertEquals( 10, has_filter( 'edit_form_after_title', array( $this->archive, 'render_warnings' ) ) );
		$this->assertEquals( 10, has_filter( 'save_post', array( $this->archive, 'save_post' ) ) );
		$this->assertEquals( 10, has_filter( 'admin_enqueue_scripts', array( $this->archive, 'admin_scripts' ) ) );
	}

	/**
	 * Test archived_post_status
	 */
	public function test_archived_post_status() {
		$this->assertTrue( in_array( Archive::POST_STATUS, get_post_stati(), true ) );
	}

	/**
	 * Test save_post
	 */
	public function test_save_post() {
		// We expect these methods to get called once for the last test which would mean the connections have been removed.
		$this->archive->expects( $this->exactly( 1 ) )->method( 'get_connected_slides' )->will( $this->returnValue( (object) array( 'posts' => array( (object) array( 'p2p_id' => 1 ) ) ) ) );
		$this->archive->expects( $this->exactly( 1 ) )->method( 'delete_p2p_connection' )->will( $this->returnValue( true ) );

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );

		// This will fail because there is no $_POST input.
		$test_post_obj = get_post( $this->slide1 );
		$result = $this->archive->save_post( $this->slide1, $test_post_obj );
		$this->assertEquals( $this->slide1, $result );

		// Setup nonce.
		$nonce = wp_create_nonce( Archive::NONCE_ACTION );

		// Send nonce via $_POST.
		$_POST[ Archive::NONCE_NAME ] = $nonce;

		// Should return post ID due to empty hidden_post_status.
		$_POST['hidden_post_status'] = '';
		$result = $this->archive->save_post( $this->slide1, $test_post_obj );
		$this->assertEquals( $this->slide1, $result );

		// Should return false because checks have passed, but hidden post status is not "Archived".
		$_POST['hidden_post_status'] = 'publish';
		$result = $this->archive->save_post( $this->slide1, $test_post_obj );
		$this->assertEquals( false, $result );

		// Should pass the test by returning false because the post status is still "publish".
		$_POST['hidden_post_status'] = Archive::POST_STATUS;
		$result = $this->archive->save_post( $this->slide1, $test_post_obj );
		$this->assertEquals( false, $result );

		// Should return true.
		$_POST['hidden_post_status'] = Archive::POST_STATUS;
		$test_post_obj = get_post( $this->slide2 );
		$result = $this->archive->save_post( $this->slide2, $test_post_obj );
		$this->assertEquals( true, $result );
	}
}
