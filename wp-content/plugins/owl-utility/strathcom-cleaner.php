<?php

/**
 *
 * @link              https://github.com/Strathcom
 * @since             1.0.0
 * @package           Strathcom_Cleaner
 *
 * @wordpress-plugin
 * Plugin Name:       Strathcom Web Manager
 * Plugin URI:        https://github.com/Strathcom/strathcom-cms
 * Description:       This is an in-house utility plugin for managing strathcom powered websites.
 * Version:           1.0.1
 * Author:            Strathcom
 * Author URI:        https://github.com/oldmanobi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       strathcom-cleaner
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_strathcom_cleaner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strathcom-cleaner-activator.php';
	Strathcom_Cleaner_Activator::activate();
}

function deactivate_strathcom_cleaner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strathcom-cleaner-deactivator.php';
	Strathcom_Cleaner_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_strathcom_cleaner' );
register_deactivation_hook( __FILE__, 'deactivate_strathcom_cleaner' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-strathcom-cleaner.php';

function run_strathcom_cleaner() {

	$plugin = new Strathcom_Cleaner();
	$plugin->run();

}
run_strathcom_cleaner();
