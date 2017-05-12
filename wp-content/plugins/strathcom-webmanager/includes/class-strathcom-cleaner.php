<?php
/**
 *
 *
 * @link       https://github.com/oldmanobi
 * @since      1.0.0
 *
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/includes
 */

class Strathcom_Cleaner {

	/**
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Strathcom_Cleaner_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 *
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'strathcom-cleaner';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-strathcom-cleaner-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-strathcom-cleaner-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-strathcom-cleaner-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-strathcom-cleaner-public.php';

		$this->loader = new Strathcom_Cleaner_Loader();

	}

	/**
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Strathcom_Cleaner_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Strathcom_Cleaner_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

	}

	/**
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Strathcom_Cleaner_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_public, 'strat_cleanup' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'strat_remove_comments_inline_styles' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'strat_remove_gallery_styles' );
		$this->loader->add_action( 'wp_enqueue_style', $plugin_public, 'dequeue_styles', PHP_INT_MAX );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'dequeue_scripts', PHP_INT_MAX );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'strat_clear_post_revisions' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'strat_clear_spam_comments' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'strat_clear_awaiting_moderation' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'disable_front_page_redirect' );

		   // Filters
		$this->loader->add_filter( 'wp_headers', $plugin_public, 'strat_remove_x_pingback' );
		$this->loader->add_filter( 'body_class', $plugin_public, 'strat_ob_class_slug' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
