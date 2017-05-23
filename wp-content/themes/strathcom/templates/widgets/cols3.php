<?php
/**
 * SideBySide twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_cols3
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_cols3( $atts ) {
	$atts = shortcode_atts( array(
		'title'                => '',
		'subtitle'             => '',
		'title_type'           => '',
		'content_left'         => '',
		'content_middle'       => '',
		'content_right'        => '',
		'background_hex_value' => '',
		'custom_class'         => '',
	), $atts, 'st_cols3' );

	return Timber::compile( 'templates/widgets/cols3.twig', $atts );
}

add_shortcode( 'st_cols3', 'shortcode_st_cols3' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_cols3() {
	shortcode_ui_register_for_shortcode( 'st_cols3',
		array(
			'label'         => esc_html__( 'Three Columns', 'strathcom' ),
			'listItemImage' => 'dashicons-text',
			'attrs'         => array(
				array(
					'label' => esc_html__( 'Title', 'strathcom' ),
					'attr'  => 'title',
					'type'  => 'text',
				),
				array(
					'label' => esc_html__( 'Subitle', 'strathcom' ),
					'attr'  => 'subtitle',
					'type'  => 'text',
				),
				array(
					'label' => esc_html__( 'Left Content', 'strathcom' ),
					'attr'  => 'content_left',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Right Content', 'strathcom' ),
					'attr'  => 'content_right',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Middle Content', 'strathcom' ),
					'attr'  => 'content_middle',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
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
			),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_cols3' );
