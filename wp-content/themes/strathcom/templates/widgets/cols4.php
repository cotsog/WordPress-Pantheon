<?php
/**
 * SideBySide twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_cols4
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_cols4( $atts ) {
	$atts = shortcode_atts( array(
		'title'                => '',
		'subtitle'             => '',
		'title_type'           => '',
		'content_one'          => '',
		'content_two'          => '',
		'content_three'        => '',
		'content_four'         => '',
		'background_hex_value' => '',
		'custom_class'         => '',
	), $atts, 'st_cols4' );

	return Timber::compile( 'templates/widgets/cols4.twig', $atts );
}

add_shortcode( 'st_cols4', 'shortcode_st_cols4' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_cols4() {
	shortcode_ui_register_for_shortcode( 'st_cols4',
		array(
			'label'         => esc_html__( 'Four Columns', 'strathcom' ),
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
					'label'   => esc_html__( 'Title Identifier', 'strathcom' ),
					'attr'    => 'title_type',
					'type'    => 'select',
					'options' => array(
						'h2' => 'H2',
						'h3' => 'H3',
						'h1' => 'H1',
					),
				),
				array(
					'label' => esc_html__( 'Column One Content', 'strathcom' ),
					'attr'  => 'content_one',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Column Two Content', 'strathcom' ),
					'attr'  => 'content_two',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Column Three Content', 'strathcom' ),
					'attr'  => 'content_three',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Column Four Content', 'strathcom' ),
					'attr'  => 'content_four',
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

add_action( 'register_shortcode_ui', 'shortcode_ui_st_cols4' );
