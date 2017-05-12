<?php
/**
 * Bootstraps the Strathcom Carousel plugin.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {
	/**
	 * The Carousel class.
	 *
	 * @var Carousel class.
	 */
	public $carousel;

	/**
	 * The Custom_Post_Types class.
	 *
	 * @var Custom_Post_Types class.
	 */
	public $custom_post_types;

	/**
	 * The Admin class.
	 *
	 * @var Admin class.
	 */
	public $admin;

	/**
	 * The Archive class.
	 *
	 * @var Archive class.
	 */
	public $archive;

	/**
	 * The Carousel_Admin class.
	 *
	 * @var Carousel_Admin class.
	 */
	public $carousel_admin;

	/**
	 * The Slide_Admin class.
	 *
	 * @var Slide_Admin class.
	 */
	public $slide_admin;

	/**
	 * The Posts_To_Posts class.
	 *
	 * @var Posts_To_Posts class.
	 */
	public $posts_to_posts;

	/**
	 * Shortcode.
	 *
	 * @var Shortcode class.
	 */
	public $shortcode;

	/**
	 * Image_Utils.
	 *
	 * @var Image_Utils class.
	 */
	public $image_utils;

	/**
	 * Graphical Incentives Utilities.
	 *
	 * @var GI_Utils class.
	 */
	public $gi_utils;

	/**
	 * Graphical Incentives Add/Edit Screen.
	 *
	 * @var GI_Add_Edit class.
	 */
	public $gi_add_edit;

	/**
	 * Graphical Incentives List Screen.
	 *
	 * @var GI_List class.
	 */
	public $gi_list;

	/**
	 * Slide Custom Post Type slug.
	 *
	 * @var string Slides slug.
	 */
	const CPT_SLUG_SLIDE = 'strathcom_slide';

	/**
	 * Carousel Custom Post Type slug.
	 *
	 * @var string Carousels slug.
	 */
	const CPT_SLUG_CAROUSEL = 'strathcom_carousel';

	/**
	 * Graphical Incentives CPT Slug.
	 */
	const CPT_SLUG_GRAPHICAL_INCENTIVES = 'strathcom_gincentive';

	/**
	 * The default time between slides in seconds.
	 *
	 * @var int Delay in seconds.
	 */
	const DEFAULT_TIMING = 5;

	/**
	 * The default display mode (slider/list/grid).
	 *
	 * @var string Carousel display mode.
	 */
	const DEFAULT_DISPLAY_MODE = 'slider';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		parent::__construct();

		$priority = 9; // Because WP_Customize_Widgets::register_settings() happens at after_setup_theme priority 10.
		add_action( 'after_setup_theme', array( $this, 'init' ), $priority );
		add_action( 'plugins_loaded', array( $this, 'load_languages' ) );
	}

	/**
	 * Initiate the plugin resources.
	 *
	 * @action after_setup_theme
	 */
	public function init() {
		if ( ! class_exists( '\StrathcomUtilities\Utilities' ) || ! \StrathcomUtilities\Utilities::is_plugin_active( 'strathcom-api/strathcom-api.php' ) ) {
			return;
		}

		$this->config = apply_filters( 'strathcom_carousel_plugin_config', $this->config, $this );

		add_action( 'wp_default_scripts', array( $this, 'register_scripts' ), 11 );
		add_action( 'wp_default_styles', array( $this, 'register_styles' ), 11 );

		$this->image_utils       = new Image_Utils( $this );
		$this->custom_post_types = new Custom_Post_Types( $this );
		$this->posts_to_posts    = new Posts_To_Posts( $this );
		$this->admin             = new Admin( $this );
		$this->carousel_admin    = new Carousel_Admin( $this );
		$this->carousel          = new Carousel( $this );
		$this->slide_admin       = new Slide_Admin( $this );
		$this->archive           = new Archive( $this );
		$this->shortcode         = new Shortcode( $this );

		$this->gi_utils    = new GI_Utils( $this );
		$this->gi_add_edit = new GI_Add_Edit( $this );
		$this->gi_list     = new GI_List( $this );

		add_action( 'widgets_init', function() {
			register_widget( '\StrathcomCarousel\Carousel_Widget' );
		} );
	}

	/**
	 * Register scripts.
	 *
	 * @param \WP_Scripts $wp_scripts Instance of \WP_Scripts.
	 *
	 * @action wp_default_scripts
	 */
	public function register_scripts( \WP_Scripts $wp_scripts ) {
	}

	/**
	 * Register styles.
	 *
	 * @param \WP_Styles $wp_styles Instance of \WP_Styles.
	 *
	 * @action wp_default_styles
	 */
	public function register_styles( \WP_Styles $wp_styles ) {
	}

	/**
	 * Load Languages
	 *
	 * Loads the language files for the plugin
	 */
	public function load_languages() {
		load_plugin_textdomain( 'strathcom-carousel', false, trailingslashit( dirname( dirname( plugin_basename( __FILE__ ) ) ) ) . 'languages/' );
	}
}
