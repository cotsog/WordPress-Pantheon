<?php
/**
 * SideBySide twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_sidebyside
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_sidebyside( $atts ) {
	$atts = shortcode_atts( array(
		'title'                => '',
		'subtitle'             => '',
		'title_type'           => '',
		'content_left'         => '',
		'content_right'        => '',
		'background_hex_value' => '',
		'custom_class'         => '',
	), $atts, 'st_sidebyside' );

	return Timber::compile( 'templates/widgets/side-by-side.twig', $atts );
}

add_shortcode( 'st_sidebyside', 'shortcode_st_sidebyside' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_sidebyside() {
	shortcode_ui_register_for_shortcode( 'st_sidebyside',
		array(
			'label'         => esc_html__( 'Two Columns', 'strathcom' ),
			'listItemImage' => 'dashicons-editor-table',
			'attrs'         => array(
				array(
					'label' => esc_html__( 'Title', 'strathcom' ),
					'attr'  => 'title',
					'type'  => 'text',
				),
				array(
					'label' => esc_html__( 'Sub Title', 'strathcom' ),
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
					'label' => esc_html__( 'Content (Left)', 'strathcom' ),
					'attr'  => 'content_left',
					'type'  => 'textarea',
					'encode' => true,
					'meta'  => array(
						'class' => 'shortcake-richtext',
					),
				),
				array(
					'label' => esc_html__( 'Content (Right)', 'strathcom' ),
					'attr'  => 'content_right',
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

add_action( 'register_shortcode_ui', 'shortcode_ui_st_sidebyside' );
