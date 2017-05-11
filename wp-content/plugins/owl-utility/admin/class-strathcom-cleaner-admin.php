<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version.
 *
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/admin
 * @author     Strathcom <obinna@strathcom.com>
 */
class Strathcom_Cleaner_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {


        if ( 'settings_page_strathcom-cleaner' == get_current_screen() -> id ) {
            // Css rules for Color Picker
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/strathcom-cleaner-admin.css', array('wp-color-picker'), $this->version, 'all' );
        }

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {


        if ( 'settings_page_strathcom-cleaner' == get_current_screen() -> id ) {
            wp_enqueue_media();
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/strathcom-cleaner-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
        }

    }

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

	    add_options_page( 'Strathcom Web Manager', 'Strathcom Web', 'manage_options', $this->plugin_name, [$this, 'display_plugin_setup_page']
	    );

	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/strathcom-cleaner-admin-display.php' );
	}

	public function options_update() {
	    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	/**
	* Validate all
	*
	*
	**/
	public function validate($input) {
	    // All checkboxes inputs
	    $valid = [];

	    // Cleanup
	    $valid['cleanup'] = (isset($input['cleanup']) && !empty($input['cleanup'])) ? 1 : 0;
	    $valid['comments_css_cleanup'] = (isset($input['comments_css_cleanup']) && !empty($input['comments_css_cleanup'])) ? 1: 0;
	    $valid['gallery_css_cleanup'] = (isset($input['gallery_css_cleanup']) && !empty($input['gallery_css_cleanup'])) ? 1 : 0;
	    $valid['body_class_slug'] = (isset($input['body_class_slug']) && !empty($input['body_class_slug'])) ? 1 : 0;

	    $valid['remove_unwanted_js'] = (isset($input['remove_unwanted_js']) && !empty($input['remove_unwanted_js'])) ? 1 : 0;
	    $valid['remove_unwanted_css'] = (isset($input['remove_unwanted_css']) && !empty($input['remove_unwanted_css'])) ? 1 : 0;

	    // Optimize
	    $valid['clear_db'] = (isset($input['clear_db']) && !empty($input['clear_db'])) ? 1 : 0;
	    $valid['spam_comments'] = (isset($input['spam_comments']) && !empty($input['spam_comments'])) ? 1 : 0;
	    $valid['awaiting_moderation'] = (isset($input['awaiting_moderation']) && !empty($input['awaiting_moderation'])) ? 1 : 0;
	    $valid['post_revisions'] = (isset($input['post_revisions']) && !empty($input['post_revisions'])) ? 1 : 0;

	    return $valid;
	 }

}
