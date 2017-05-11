<?php
/**
 *
 *
 * @since      1.0.0
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/includes
 * @author     Strathcom <obinna@strathcom.com>
 */
class Strathcom_Cleaner_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'strathcom-cleaner',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
