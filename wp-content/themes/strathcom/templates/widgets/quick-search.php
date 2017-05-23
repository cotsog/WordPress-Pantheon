<?php
/**
 * SideBySide twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_quick_search
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_quick_search( $atts ) {
	$atts = shortcode_atts( array(
		'title'                => '',
		'title_type'           => '',
		'title_display'        => '',
		'background_hex_value' => '',
		'add_quick_search'     => '',
		'background_hex_value' => '',
		'custom_class'         => '',
		'button_text'          => '',
	), $atts, 'st_quick_search' );

	return Timber::compile( 'templates/widgets/quick-search.twig', $atts );
}

add_shortcode( 'st_quick_search', 'shortcode_st_quick_search' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_quick_search() {
	shortcode_ui_register_for_shortcode( 'st_quick_search',
		array(
			'label'         => esc_html__( 'Add Search Bar', 'strathcom' ),
			'listItemImage' => 'dashicons-search',
			'attrs'         => array(
				array(
					'label' => esc_html__( 'Title', 'strathcom' ),
					'attr'  => 'title',
					'type'  => 'text',
				),
				array(
					'label'   => esc_html__( 'Title Identifier', 'strathcom' ),
					'attr'    => 'title_type',
					'type'    => 'select',
					'options' => array(
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
					),
				),
				array(
					'label'   => esc_html__( 'Title Display (Should the title be to the left or on top of the search?)', 'strathcom' ),
					'attr'    => 'title_display',
					'type'    => 'select',
					'options' => array(
						'top' => 'Top',
						'left' => 'Left',
					),
				),
				array(
					'label'   => esc_html__( 'Add Search', 'strathcom' ),
					'attr'    => 'add_quick_search',
					'type'    => 'select',
					'options' => array(
						'quick-search-on' => 'Quick Search (Dropdown)',
						'keyword-search-on' => 'Keyword Search (Query)',
						'both-search-on' => 'Both',
					),
				),
				array(
					'label' => esc_html__( 'Background Color (Hex Value or RGB)', 'strathcom' ),
					'attr'  => 'background_hex_value',
					'type'  => 'text',
				),
				array(
					'label' => esc_html__( 'Custom Class', 'strathcom' ),
					'attr'  => 'custom_class',
					'type'  => 'text',
				),
				array(
					'label' => esc_html__( 'Button Text', 'strathcom' ),
					'attr'  => 'button_text',
					'type'  => 'text',
				),
			),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_quick_search' );
