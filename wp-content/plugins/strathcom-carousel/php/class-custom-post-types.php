<?php
/**
 * Slide and Carousel Custom Post Types.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Custom_Post_Types
 *
 * @package StrathcomCarousel
 */
class Custom_Post_Types {
	/**
	 * The plugin instance
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Constructor
	 *
	 * @see    Plugin::init()
	 * @see    Plugin::__construct()
	 *
	 * @action after_setup_theme.
	 *
	 * @param object $plugin the plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		add_action( 'init', array( $this, 'register_cpt_carousel' ), 5 );
		add_action( 'init', array( $this, 'register_cpt_slide' ), 5 );

		// Function get_current_blog_id() returns an int.
		if ( 1 === get_current_blog_id() ) {
			add_action( 'init', array( $this, 'register_cpt_graphical_incentives' ), 5 );
		}

		// Add slides CPT to the list of expirable CPTs.
		add_filter( 'strathcom_expire_posts_post_types', array( $this, 'add_slides_to_filter_array' ), 11 );

		// Add graphical incentive CPT to the list of expirable CPTs.
		add_filter( 'strathcom_expire_posts_post_types', array( $this, 'add_incentives_to_filter_array' ), 11 );
	}

	/**
	 * Register the Slide CPT
	 *
	 * @return void
	 */
	public function register_cpt_slide() {
		$labels = array(
			'name'                  => __( 'Slides', 'strathcom-carousel' ),
			'add_new_item'          => __( 'New Slide', 'strathcom-carousel' ),
			'add_new'               => __( 'New Slide', 'strathcom-carousel' ),
			'new_item'              => __( 'New Slide', 'strathcom-carousel' ),
			'edit_item'             => __( 'Edit Slide', 'strathcom-carousel' ),
			'update_item'           => __( 'Update Slide', 'strathcom-carousel' ),
			'view_item'             => __( 'View Slide', 'strathcom-carousel' ),
			'search_items'          => __( 'Search Slides', 'strathcom-carousel' ),
			'not_found'             => __( 'Not found', 'strathcom-carousel' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'strathcom-carousel' ),
			'featured_image'        => __( 'Featured Image', 'strathcom-carousel' ),
			'set_featured_image'    => __( 'Set featured image', 'strathcom-carousel' ),
			'remove_featured_image' => __( 'Remove featured image', 'strathcom-carousel' ),
			'use_featured_image'    => __( 'Use as featured image', 'strathcom-carousel' ),
			'insert_into_item'      => __( 'Insert into Slide', 'strathcom-carousel' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Slide', 'strathcom-carousel' ),
			'items_list'            => __( 'Slides list', 'strathcom-carousel' ),
			'items_list_navigation' => __( 'Slides list navigation', 'strathcom-carousel' ),
			'filter_items_list'     => __( 'Filter Slides list', 'strathcom-carousel' ),
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=' . Plugin::CPT_SLUG_CAROUSEL,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'show_in_customizer'  => false,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		register_post_type( Plugin::CPT_SLUG_SLIDE, $args );
	}

	/**
	 * Register the carousel CPT
	 *
	 * @return void
	 */
	public function register_cpt_carousel() {
		$labels = array(
			'name'                  => __( 'Carousels', 'strathcom-carousel' ),
			'add_new_item'          => __( 'New Carousel', 'strathcom-carousel' ),
			'add_new'               => __( 'New Carousel', 'strathcom-carousel' ),
			'new_item'              => __( 'New Carousel', 'strathcom-carousel' ),
			'edit_item'             => __( 'Edit Carousel', 'strathcom-carousel' ),
			'update_item'           => __( 'Update Carousel', 'strathcom-carousel' ),
			'view_item'             => __( 'View Carousel', 'strathcom-carousel' ),
			'search_items'          => __( 'Search Carousels', 'strathcom-carousel' ),
			'not_found'             => __( 'Not found', 'strathcom-carousel' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'strathcom-carousel' ),
			'featured_image'        => __( 'Featured Image', 'strathcom-carousel' ),
			'set_featured_image'    => __( 'Set featured image', 'strathcom-carousel' ),
			'remove_featured_image' => __( 'Remove featured image', 'strathcom-carousel' ),
			'use_featured_image'    => __( 'Use as featured image', 'strathcom-carousel' ),
			'insert_into_item'      => __( 'Insert into Carousel', 'strathcom-carousel' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Carousel', 'strathcom-carousel' ),
			'items_list'            => __( 'Carousels list', 'strathcom-carousel' ),
			'items_list_navigation' => __( 'Carousels list navigation', 'strathcom-carousel' ),
			'filter_items_list'     => __( 'Filter Carousels list', 'strathcom-carousel' ),
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'show_in_customizer'  => false,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'menu_icon'           => 'dashicons-slides',
		);

		register_post_type( Plugin::CPT_SLUG_CAROUSEL, $args );
	}

	/**
	 * Register the Graphical Incentives CPT.
	 *
	 * @action init
	 *
	 * @return void
	 */
	public function register_cpt_graphical_incentives() {
		$labels = array(
			'name'                  => __( 'Graphical Incentives', 'strathcom-carousel' ),
			'add_new_item'          => __( 'Add Graphical Incentive', 'strathcom-carousel' ),
			'add_new'               => __( 'New Graphical Incentive', 'strathcom-carousel' ),
			'new_item'              => __( 'New Graphical Incentive', 'strathcom-carousel' ),
			'edit_item'             => __( 'Edit Graphical Incentive', 'strathcom-carousel' ),
			'update_item'           => __( 'Update Graphical Incentive', 'strathcom-carousel' ),
			'view_item'             => __( 'View Graphical Incentive', 'strathcom-carousel' ),
			'search_items'          => __( 'Search Graphical Incentives', 'strathcom-carousel' ),
			'not_found'             => __( 'Not found', 'strathcom-carousel' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'strathcom-carousel' ),
			'featured_image'        => __( 'Featured Image', 'strathcom-carousel' ),
			'set_featured_image'    => __( 'Set featured image', 'strathcom-carousel' ),
			'remove_featured_image' => __( 'Remove featured image', 'strathcom-carousel' ),
			'use_featured_image'    => __( 'Use as featured image', 'strathcom-carousel' ),
			'insert_into_item'      => __( 'Insert into Graphical Incentive', 'strathcom-carousel' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Graphical Incentive', 'strathcom-carousel' ),
			'items_list'            => __( 'Graphical Incentives list', 'strathcom-carousel' ),
			'items_list_navigation' => __( 'Graphical Incentives list navigation', 'strathcom-carousel' ),
			'filter_items_list'     => __( 'Filter Graphical Incentives list', 'strathcom-carousel' ),
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'revisions' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'show_in_customizer'  => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'menu_icon'           => 'dashicons-slides',
		);

		register_post_type( Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES, $args );
	}

	/**
	 * Add slides to an array of post types from a filter.
	 *
	 * @filter strathcom_expire_posts_post_type
	 *
	 * @param array $default_array The array param from the filter.
	 *
	 * @return array
	 */
	public function add_slides_to_filter_array( $default_array = array() ) {
		$default_array[] = Plugin::CPT_SLUG_SLIDE;
		return $default_array;
	}

	/**
	 * Add incentives to an array of post types from a filter.
	 *
	 * @filter strathcom_expire_posts_post_type
	 *
	 * @param array $default_array The array param from the filter.
	 *
	 * @return array
	 */
	public function add_incentives_to_filter_array( $default_array = array() ) {
		$default_array[] = Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES;
		return $default_array;
	}
}
