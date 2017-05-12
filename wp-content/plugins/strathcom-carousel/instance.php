<?php
/**
 * Instantiates the Strathcom Carousel plugin
 *
 * @author XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

global $strathcom_carousel_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

$strathcom_carousel_plugin = new Plugin();

/**
 * Strathcom Carousel Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $strathcom_carousel_plugin;
	return $strathcom_carousel_plugin;
}
