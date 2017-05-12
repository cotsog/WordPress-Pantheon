<?php
/**
 * Sets up the carousel shortcode and shortcake item
 *
 * @author  XWP
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Shortcode
 *
 * @package StrathcomCarousel
 */
class Shortcode {
	/**
	 * The Plugin instance.
	 *
	 * @var Plugin.
	 */
	public $plugin;

	/**
	 * Carousel shortcode name
	 */
	const CAROUSEL_SHORTCODE = 'strathcom_carousel';

	/**
	 * Constructor
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		add_shortcode( self::CAROUSEL_SHORTCODE, array( $this, 'render_shortcode' ) );
		add_action( 'register_shortcode_ui', array( $this, 'register_shortcode_ui' ) );
	}

	/**
	 * Render Shortcode
	 *
	 * Fetches the Carousel markup from the Carousel class and outputs it via the shortcode action.
	 *
	 * @param array $atts Arguments passed in to the shortcode.
	 *
	 * @return string|void
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts( array( 'id' => 0 ), $atts );

		if ( 0 === $atts['id'] ) {
			return;
		}

		ob_start();
		$this->plugin->carousel->render_carousel( intval( $atts['id'] ) );
		return ob_get_clean();
	}

	/**
	 * Register Shortcode UI
	 *
	 * Registers the UI elements that are needed for the Shortcake UI item.
	 *
	 * @return void
	 */
	function register_shortcode_ui() {
		$options    = array();
		$carousels  = $this->plugin->carousel->get_carousels();

		if ( count( $carousels ) > 0 ) {
			$options[0] = esc_html__( 'Select a Carousel', 'strathcom-carousel' );

			foreach ( $carousels as $carousel ) {
				$options[ $carousel['ID'] ] = $carousel['title'];
			}
		} else {
			$options[0] = esc_html__( 'Please create a Carousel first', 'strathcom-carousel' );
		}

		shortcode_ui_register_for_shortcode( self::CAROUSEL_SHORTCODE,
			array(
				'label' => esc_html__( 'Carousel', 'strathcom-carousel' ),
				'listItemImage' => 'dashicons-slides',
				'attrs' => array(
					array(
						'label'  => esc_html__( 'Select Carousel', 'strathcom-carousel' ),
						'attr'   => 'id',
						'type'    => 'select',
						'options' => $options,
					),
				),
			)
		);
	}
}
