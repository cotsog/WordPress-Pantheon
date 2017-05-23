<?php
/**
 * Call to Action Block twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_cta_block
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_cta_block( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'columns_number'       => '',
		'background_hex_value' => '',
		'custom_class'         => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts ), $atts, 'st_cta_block' );

	$computed_atts = array(
		'buttons' => array(
			0 => array(
				'url'   => $atts['button1_url'],
				'text'  => $atts['button1_text'],
				'icon'  => $atts['button1_icon'],
				'class' => $atts['button1_class'],
			),
			1 => array(
				'url'   => $atts['button2_url'],
				'text'  => $atts['button2_text'],
				'icon'  => $atts['button2_icon'],
				'class' => $atts['button2_class'],
			),
			2 => array(
				'url'   => $atts['button3_url'],
				'text'  => $atts['button3_text'],
				'icon'  => $atts['button3_icon'],
				'class' => $atts['button3_class'],
			),
			3 => array(
				'url'   => $atts['button4_url'],
				'text'  => $atts['button4_text'],
				'icon'  => $atts['button4_icon'],
				'class' => $atts['button4_class'],
			),
		),
	);

	return Timber::compile( 'templates/widgets/cta-block.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_cta_block', 'shortcode_st_cta_block' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_cta_block() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
		array(
			'label'   => esc_html__( 'Columns #', 'strathcom' ),
			'attr'    => 'columns_number',
			'type'    => 'select',
			'options' => array(
				'one-cta-col' => 'One Column',
				'three-cta-col' => 'Three Columns',
				'four-cta-col'  => 'Four Columns',
				'two-cta-col'   => 'Two Columns',
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
	);

	shortcode_ui_register_for_shortcode( 'st_cta_block',
		array(
			'label'         => esc_html__( 'Call to Action Block', 'strathcom' ),
			'listItemImage' => 'dashicons-exerpt-view',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_cta_block' );
