<?php
/**
 * Calculator twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_calc
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_calc( $atts ) {
	$atts = shortcode_atts( array(
		'title'                => '',
		'title_type'           => '',
		'custom_class'         => '',
		'disclaimer'         => '',
	), $atts, 'st_calc' );

	return Timber::compile( 'templates/widgets/calculator.twig', $atts );
}

add_shortcode( 'st_calc', 'shortcode_st_calc' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_calc() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
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
				'h2' => 'H2',
				'h3' => 'H3',
				'h1' => 'H1',
			),
		),
		array(
			'label' => esc_html__( 'Custom Class', 'strathcom' ),
			'attr'  => 'custom_class',
			'type'  => 'text',
		),
		array(
			'label' => esc_html__( 'Disclaimer', 'strathcom' ),
			'attr'  => 'disclaimer',
			'type'  => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'st_calc',
		array(
			'label'         => esc_html__( 'Calculator', 'strathcom' ),
			'listItemImage' => 'dashicons-editor-table',
			'attrs'         => array_merge( $shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_calc' );
