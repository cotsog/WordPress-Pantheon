<?php
/**
 * Graphical Incentives Utility Helper Methods.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class GI_Utils
 *
 * @package StrathcomCarousel
 */
class GI_Utils {
	/**
	 * Graphical Incentives CPT Slug.
	 */
	const CPT_SLUG_GRAPHICAL_INCENTIVES = 'strathcom-gincentive';

	/**
	 * Nonce Name.
	 */
	const NONCE_NAME = 'strathcom-graphical-incentives-nonce-name';

	/**
	 * CSS Handle.
	 */
	const CSS_HANDLE = 'strathcom-graphical-incentives-css';

	/**
	 * Script Handle.
	 */
	const SCRIPT_HANDLE = 'strathcom-graphical-incentives-js';

	/**
	 * Get Graphical Incentives Transient label.
	 */
	const TRANSIENT_GET_INCENTIVES = 'strathcom-gi-trnsnt';

	/**
	 * Get Carousels Transient label.
	 */
	const TRANSIENT_GET_SINGLE_INCENTIVE_CAROUSELS = 'strathcom-crsl-trnst';

	/**
	 * Post Meta for holding assigned carousels.
	 */
	const POST_META_CAROUSELS = 'strathcom_graphical_incentives_carousels';

	/**
	 * Post Meta for holding time values.
	 */
	const POST_META_TIME = 'strathcom_graphical_incentives_time';

	/**
	 * Save Action.
	 */
	const SAVE_ACTION = 'strathcom-graphical-incentives-save-action';

	/**
	 * Delete Action.
	 */
	const DELETE_ACTION = 'strathcom-graphical-incentives-delete-action';

	/**
	 * Network Admin Page Slug.
	 */
	const ADMIN_MENU_SLUG = 'strathcom_graphical_incentives';

	/**
	 * Network Admin Page Slug.
	 */
	const ADD_EDIT_SCREEN = 'strathcom_add_edit_graphical_incentive';

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
		$this->init();
	}

	/**
	 * Initiate this class' resources.
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'network_admin_menu', array( $this, 'admin_menu_page' ) );
		add_action( 'wp_ajax_' . self::SAVE_ACTION, array( $this, 'ajax_save_incentive' ) );
		add_action( 'wp_ajax_' . self::DELETE_ACTION, array( $this, 'ajax_delete_incentive' ) );
		add_action( 'strathcom_carousel_delete_transients', array( $this, 'delete_transients' ) );
		add_action( 'future_to_publish', array( $this, 'transition_future_to_publish' ), 10, 1 );
	}

	/**
	 * Register the Admin Menu pages.
	 */
	public function admin_menu_page() {
		if ( is_network_admin() ) {
			add_menu_page(
				__( 'Graphical Incentives', 'strathcom-carousel' ),
				__( 'Graphical Incentives', 'strathcom-carousel' ),
				'manage_network_options',
				self::ADMIN_MENU_SLUG,
				array( $this->plugin->gi_list, 'init' ),
				'dashicons-slides'
			);

			add_submenu_page(
				self::ADMIN_MENU_SLUG,
				__( 'New Graphical Incentive', 'strathcom-carousel' ),
				__( 'New Graphical Incentive', 'strathcom-carousel' ),
				'manage_network_options',
				self::ADD_EDIT_SCREEN,
				array( $this->plugin->gi_add_edit, 'init' )
			);
		}
	}

	/**
	 * Fetch all incentives.
	 *
	 * Uses a transient for front-end display so a query isn't run
	 * on every page load.  If a transient is used on in the admin,
	 * posts won't expire at the set time.
	 *
	 * @see class-gi-list.php
	 *
	 * @param array $args Supplemental query args.
	 *
	 * @return mixed
	 */
	public function get_incentives( $args = array() ) {
		$this->plugin->gi_utils->reset_expiration();

		$incentives = array();

		if ( ! is_user_logged_in() ) {
			// If not logged in, use the data from the transient.
			$incentives = get_site_transient( self::TRANSIENT_GET_INCENTIVES ) ? get_site_transient( self::TRANSIENT_GET_INCENTIVES ) : array();
		}

		if ( empty( $incentives ) ) {

			$default_args = array(
				'post_type'              => Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES,
				'numposts'               => 100,
				'orderby'                => 'date',
				'order'                  => 'DESC',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			);

			$args = array_merge( $default_args, $args );

			$query = new \WP_Query( $args );

			if ( empty( $query->posts ) || ! is_array( $query->posts ) ) {
				return array();
			}

			// Rename for clarity.
			$incentives = $query->posts;

			// Set for 5 min.
			set_site_transient( self::TRANSIENT_GET_INCENTIVES, $incentives, 60 * 5 );
		}

		return $incentives;
	}

	/**
	 * Fetch all carousels in network which have been marked as incentive carousels.
	 *
	 * Uses a transient to cache this briefly so
	 * it doesn't run a full query on every page load.
	 *
	 * @return mixed
	 */
	public function get_carousels_from_network() {
		$query = new \WP_Query(
			array(
				'post_type'              => Plugin::CPT_SLUG_CAROUSEL,
				'post_status'            => array( 'publish', 'future' ),
				'numposts'               => 100,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'meta_key'               => Carousel::POST_META_INCENTIVES,
				'meta_value'             => 1,
			)
		);

		return $query->posts;
	}

	/**
	 * Get all carousels associated with all Graphical Incentives.
	 *
	 * This creates an array in this format:
	 *
	 * array(
	 *    [Incentive Post ID] => [array of selected carousels from Incentive post meta],
	 *    [Incentive Post ID] => [array of selected carousels from Incentive post meta],
	 * );
	 *
	 * The carousels are those chosen via checkbox in the Edit
	 * Graphical Incentive screen.
	 *
	 * @return array
	 */
	public function get_single_incentives_carousels() {
		switch_to_blog( 1 );

		$incentives = array();
		$args = array( 'post_status' => 'publish' );
		$all_incentives = $this->get_incentives( $args );
		foreach ( $all_incentives as $incentive ) {
			$incentives[ $incentive->ID ] = get_post_meta( $incentive->ID, self::POST_META_CAROUSELS, true );
		}

		restore_current_blog();
		return $incentives;
	}

	/**
	 * Save the Incentive via ajax.
	 */
	public function ajax_save_incentive() {
		check_ajax_referer( self::NONCE_NAME, 'nonce' );

		if ( empty( $_POST['data'] ) ) { // WPCS: Input var okay.
			wp_send_json_error( 'No input data.' );
		}

		$data = $this->sanitize_array_recursive( wp_unslash( $_POST['data'] ) ); // WPCS: Input var okay.

		if ( empty( $data ) || ! is_array( $data ) ) {
			wp_send_json_error( __( 'No input data for saving.', 'strathcom-carousel' ) );
		};

		// Ensure everything expected to exist actually exists.
		$output = $this->validate_input_data( $data );

		$slide_id = $this->save_post( $output );

		if ( ! empty( $slide_id ) && is_numeric( $slide_id ) ) {
			wp_send_json_success( $slide_id );
		};

		wp_send_json_error( __( 'Graphical Incentive Not Saved.', 'strathcom-carousel' ) );
	}

	/**
	 * Save form data as a WP Post.
	 *
	 * Will either insert or update a post if it already exists.
	 *
	 * @param array $data Form data.
	 *
	 * @return mixed New Post ID, else false.
	 */
	public function save_post( $data ) {

		// Basic Post settings.
		$args = array(
			'post_title'   => $data['title'],
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES,
			'meta_input'   => array(
				self::POST_META_CAROUSELS => $data['carousels'],
				Slide_Admin::POST_META_SLIDE_SELECT => wp_slash( 'manual' ),
				Slide_Admin::POST_META_SLIDE_URL => '',
				Slide_Admin::POST_META_SLIDE_PAGE => '0',
				Slide_Admin::POST_META_SLIDE_URL_TARGET => wp_slash( $data['slide_url_target'] ),
			),
		);

		// Set the Start Date as the Published Date, then maybe set the post status.
		if ( ! empty( $data['start_date'] ) ) {
			$start_date = $this->input_to_date( $data['start_date'], $data['start_hours'], $data['start_mins'] );
			$args['post_date'] = $start_date;

			if ( $start_date < current_time( 'Y-m-d HH:MM:s' ) ) {
				$args['post_status'] = 'future';
			}
		}

		/*
		 * If start or end date are empty, don't save hour/min values.
		 */
		$time_array = array(
			'start_date'  => '',
			'start_hours' => '00',
			'start_mins'  => '00',
			'end_date'    => '',
			'end_hours'   => '00',
			'end_mins'    => '00',
		);

		if ( ! empty( $data['start_date'] ) ) {
			$time_array['start_date']  = wp_slash( $data['start_date'] );
			$time_array['start_hours'] = wp_slash( $data['start_hours'] );
			$time_array['start_mins']  = wp_slash( $data['start_mins'] );
		}

		if ( ! empty( $data['end_date'] ) ) {
			$time_array['end_date']  = wp_slash( $data['end_date'] );
			$time_array['end_hours'] = wp_slash( $data['end_hours'] );
			$time_array['end_mins']  = wp_slash( $data['end_mins'] );
		}

		$args['meta_input'][ self::POST_META_TIME ] = $time_array;

		// Set the Slide Link URL.
		if ( ! empty( $data['slide_url'] ) ) {
			$args['meta_input'][ Slide_Admin::POST_META_SLIDE_URL ] = wp_slash( $data['slide_url'] );
		}

		/*
		 * Use Expire Posts, if active.
		 */
		$args = $this->maybe_set_incentive_expiration( $data, $args );

		/*
		 * If this Incentive post already exists,
		 * add the ID so it is updated, not created new.
		 */
		if ( is_string( get_post_status( $data['post_id'] ) ) ) {
			$args['ID'] = $data['post_id'];
		}

		/*
		 * Insert The Post.
		 */
		$post_id = wp_insert_post( $args );

		if ( ! is_numeric( $post_id ) ) {
			return false;
		}

		// After the post is set up, set the post thumbnail.
		set_post_thumbnail( $post_id, $data['img_id'] );

		// Generate Carousel Aspect Ratio images.
		$this->plugin->image_utils->save_img_aspect_ratios( $post_id );

		// Ensure everything's current.
		clean_post_cache( $post_id );

		$this->delete_transients();
		$this->reset_expiration();

		return $post_id;
	}

	/**
	 * Delete the incentive via ajax.
	 *
	 * The JS includes a confirmation popup before deletion.
	 */
	public function ajax_delete_incentive() {
		check_ajax_referer( self::NONCE_NAME, 'nonce' );

		if ( empty( $_POST['data'] ) || empty( $_POST['data']['post_id'] ) ) { // WPCS: Input var okay.
			wp_send_json_error( __( 'No data sent.', 'strathcom-carousel' ) );
		}

		$id = intval( wp_unslash( $_POST['data']['post_id'] ) ); // Input var okay.

		// Use force delete since user is unable to view "Trash" posts.
		if ( ! empty( wp_delete_post( $id, true ) ) ) {
			$this->delete_transients();
			wp_send_json_success( $id );
		}
		wp_send_json_error( __( 'Incentive did not delete', 'strathcom-carousel' ) );
	}

	/**
	 * Fetch an image URL.
	 *
	 * @param mixed  $img_id String/int of the image.
	 * @param string $size Optional. Requested image size. Defaults to 'full'.
	 *
	 * @return bool|mixed
	 */
	public function get_incentive_img_url( $img_id = 0, $size = 'full' ) {
		$size = empty( $size ) ? 'full' : $size;
		$attachment_src = array();

		// Get the attachment source of the id.
		if ( ! empty( $img_id ) && is_numeric( $img_id ) ) {
			$attachment_src = wp_get_attachment_image_src( $img_id, $size );
		}

		if ( ! empty( $attachment_src[0] ) ) {
			return $attachment_src[0];
		}
		return false;
	}

	/**
	 * Delete GI Transients.
	 */
	public function delete_transients() {
		delete_site_transient( self::TRANSIENT_GET_INCENTIVES );
		delete_site_transient( self::TRANSIENT_GET_SINGLE_INCENTIVE_CAROUSELS );
	}

	/**
	 * Format the carousel save values.
	 *
	 * Carousel values from the site (network) option
	 * are in the following format: 1|23,
	 * where the digits on the left of the pipe
	 * represent the blog ID, and on the right represent
	 * the Carousel CPT post ID.
	 *
	 * This method separates them into an array, grouping all
	 * post IDs into an array under the blog ID.
	 *
	 * Input:
	 *   array(
	 *     '1|23',
	 *     '1|79',
	 *     '3|34',
	 *     '6|83',
	 *   );
	 *
	 * Output:
	 *  array(
	 *     '1' => array{
	 *        23,
	 *        79,
	 *     ),
	 *     '3' => array{
	 *        34,
	 *     ),
	 *     '6' => array{
	 *        83,
	 *     ),
	 *  );
	 *
	 * @param array $carousels An array of carousels.
	 *
	 * @return array An array of exploded carousel values.
	 */
	public function explode_carousel_values( $carousels = array() ) {
		$output = array();
		if ( ! empty( $carousels ) && is_array( $carousels ) ) {
			foreach ( $carousels as $carousel_string ) {
				if ( false !== strpos( $carousel_string, '|' ) ) {
					$pieces = explode( '|', $carousel_string );
					$output[ $pieces[0] ][] = $pieces[1];
				}
			}
		}
		return $output;
	}

	/**
	 * Validate input data from Ajax.
	 *
	 * Ensures that all expected keys are set.
	 *
	 * @param array $data Data to be validated.
	 *
	 * @return array Validated data.
	 */
	public function validate_input_data( $data = array() ) {
		$output = array();

		// Basic "empty" check.
		$basic_fields = array(
			'post_id',
			'title',
			'img_id',
			'start_date',
			'end_date',
			'slide_url',
			'slide_url_target',
			'slide_page',
		);

		foreach ( $basic_fields as $label ) {
			$output[ $label ] = empty( $data[ $label ] ) ? '' : $data[ $label ];
		}

		$output['start_hours'] = empty( $data['start_hours'] ) ? '00' : $data['start_hours'];
		$output['start_mins']  = empty( $data['start_mins'] ) ? '00' : $data['start_mins'];
		$output['end_hours']   = empty( $data['end_hours'] ) ? '00' : $data['end_hours'];
		$output['end_mins']    = empty( $data['end_mins'] ) ? '00' : $data['end_mins'];
		$output['carousels']   = empty( $data['carousels'] ) ? array() : $data['carousels'];

		// If the start date is empty, empty out hour/min information.
		if ( empty( $output['start_date'] ) ) {
			$output['start_hours'] = empty( $data['start_hours'] ) ? '00' : $data['start_hours'];
			$output['start_mins']  = empty( $data['start_mins'] ) ? '00' : $data['start_mins'];
		}

		// If the end date is empty,  empty out hour/min information.
		if ( empty( $output['end_date'] ) ) {
			$output['end_hours'] = empty( $data['end_hours'] ) ? '00' : $data['end_hours'];
			$output['end_mins']  = empty( $data['end_mins'] ) ? '00' : $data['end_mins'];
		}

		return $output;
	}

	/**
	 * Validate post data before rendering Add/Edit form.
	 *
	 * Ensures that all expected keys are set.
	 *
	 * @param string $post_id Post ID to be validated.
	 *
	 * @return array Validated data.
	 */
	public function validate_post_data( $post_id ) {
		$output = array();

		if ( is_object( $post_id ) && ! empty( $post_id->ID ) ) {
			$post_id = $post_id->ID;
		}

		$output['post_id']    = $post_id;
		$output['title']      = empty( $post_id ) ? '' : get_the_title( $post_id );
		$output['img_id']     = get_post_thumbnail_id( $post_id );
		$output['post_date']  = get_the_date( 'Y/m/d H:i', $post_id );

		$time = get_post_meta( $post_id, self::POST_META_TIME, true );
		$output['start_date']  = empty( $time['start_date'] ) ? '' : $time['start_date'];
		$output['start_hours'] = empty( $time['start_hours'] ) ? '00' : $time['start_hours'];
		$output['start_mins']  = empty( $time['start_mins'] ) ? '00' : $time['start_mins'];

		$output['end_date']  = empty( $time['end_date'] ) ? '' : $time['end_date'];
		$output['end_hours'] = empty( $time['end_hours'] ) ? '00' : $time['end_hours'];
		$output['end_mins']  = empty( $time['end_mins'] ) ? '00' : $time['end_mins'];

		$output['slide_url']        = get_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_URL, true );
		$output['slide_url_target'] = get_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_URL_TARGET, true );
		$output['slide_page']       = get_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_PAGE, true );
		$output['slide_select']     = get_post_meta( $post_id, Slide_Admin::POST_META_SLIDE_SELECT, true );

		$output['carousels'] = is_array( get_post_meta( $post_id, self::POST_META_CAROUSELS, true ) ) ? get_post_meta( $post_id, self::POST_META_CAROUSELS, true ) : array();

		return $output;
	}

	/**
	 * Set Incentive Expiration.
	 *
	 * If the Strathcom Expire Posts plugin is found,
	 * then check to see if we need to schedule expiration.
	 *
	 * @param array $data Input data array from Ajax.
	 * @param array $args Array of output passed through this method.
	 *
	 * @return array
	 */
	public function maybe_set_incentive_expiration( $data, $args ) {
		if ( class_exists( '\\Strathcom_Expire_Posts\\Plugin' ) ) {
			$expire_posts = new \Strathcom_Expire_Posts\Plugin();
			$expire_posts->init();

			if ( ! empty( $data['end_date'] ) ) {

				// First, modify time for UTC time zone.
				$tz_offset = $this->custom_offset();
				$adjusted_hours = $data['end_hours'] - $tz_offset;
				$end_date = $data['end_date'];

				if ( 24 <= $adjusted_hours ) {
					$end_date_array    = explode( '/', $data['end_date'] );
					$end_date_array[1] = $end_date_array[1] + 1;
					$end_date          = implode( '/', $end_date_array );
					$adjusted_hours    = ( $adjusted_hours - 24 );
				}

				// Set expiration post meta.
				$end_date = strtotime( $end_date . ' ' . $adjusted_hours . ':' . $data['end_mins'] );
				$args['meta_input'][ $expire_posts->config['meta_field'] ] = date( 'U', (int) $end_date );
				$args['meta_input'][ $expire_posts->config['meta_field_pending'] ] = true;
				$expire_posts->worker->reset_expiration_event();
			} else {
				$expire_posts->worker->unschedule_expired_post( $data['post_id'] );
			}
		}
		return $args;
	}

	/**
	 * Update/Unschedule Post Expiration times.
	 */
	public function reset_expiration() {
		if ( class_exists( '\\Strathcom_Expire_Posts\\Plugin' ) ) {
			$expire_posts = new \Strathcom_Expire_Posts\Plugin();
			$expire_posts->init();
			$expire_posts->worker->reset_expiration_event();
		}
	}

	/**
	 * Convert our inputs into a usable date.
	 *
	 * @param string $date The Date input.
	 * @param string $hours The Hours input.
	 * @param string $mins The minutes input.
	 *
	 * @return mixed
	 */
	public function input_to_date( $date = '', $hours = '0', $mins = '0' ) {
		if ( empty( $date ) ) {
			return '';
		}
		$timestamp = strtotime( $date . ' ' . $hours . ':' . $mins );
		return date( 'Y-m-d H:i:s', $timestamp );
	}

	/**
	 * Delete transients when Incentive is transitioned.
	 *
	 * @action future_to_publish
	 *
	 * @param object $post WP Post object.
	 */
	public function transition_future_to_publish( $post ) {
		if ( Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES === $post->post_type ) {
			$this->delete_transients();
		}
	}

	/**
	 * Convert the GMT Offset into something JS can use.
	 *
	 * The 'gmt_offset' must be zeroised to be used for our purposes.
	 *
	 * Pulls out the +/-, then zeroises the rest, then reassembles the string.
	 * Finally, it converts it to a float so the leading zero gets passed.
	 *
	 * @return float
	 */
	public function custom_offset() {
		$offset = get_option( 'gmt_offset' );
		$prefix = '';
		$first_char = substr( (string) $offset, 0, 1 );
		if ( '+' === $first_char || '-' === $first_char ) {
			$prefix = $first_char;
			$offset = substr( $offset, 1 );
		}
		$offset = zeroise( $offset, 2 );

		return ( (float) ($prefix . $offset) );
	}

	/**
	 * Sanitize an array recursively.
	 *
	 * @param array $data The input array.
	 *
	 * @return array
	 */
	public function sanitize_array_recursive( $data = array() ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$data[ $key ] = $this->sanitize_array_recursive( $value );
			}
		} else {
			return sanitize_text_field( $data );
		}

		return $data;
	}

	/**
	 * Enqueue Admin scripts and styles.
	 */
	public function admin_scripts() {

		wp_register_style( self::CSS_HANDLE, $this->plugin->dir_url . '/css/graphical-incentives.css' );
		wp_enqueue_style( self::CSS_HANDLE );

		wp_register_script(
			self::SCRIPT_HANDLE,
			$this->plugin->dir_url . 'js/graphical-incentives.js',
			array( 'jquery', 'jquery-ui-datepicker' )
		);

		$exports = array(
			'nonce'             => wp_create_nonce( self::NONCE_NAME ),
			'saveAction'        => self::SAVE_ACTION,
			'deleteAction'      => self::DELETE_ACTION,
			'modalTitle'        => __( 'Select or upload a slide image', 'strathcom-carousel' ),
			'buttonText'        => __( 'Insert slide image', 'strathcom-carousel' ),
			'confirmDeleteText' => __( 'This Graphical Incentive will be permanently deleted.  Do you want to proceed?', 'strathcom-carousel' ),
			'now'               => current_time( 'F d, Y H:i' ),
		);

		wp_scripts()->add_data(
			self::SCRIPT_HANDLE,
			'data',
			sprintf( 'var _strathcomGraphicalIncentivesExports = %s;', wp_json_encode( $exports ) )
		);

		wp_add_inline_script( self::SCRIPT_HANDLE, 'strathcomGraphicalIncentives.init();', 'after' );
		wp_enqueue_script( self::SCRIPT_HANDLE );
	}
}
