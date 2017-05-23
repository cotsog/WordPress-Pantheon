<?php
/**
 * Intro twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_intro
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_intro( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'title'             => '',
		'subtitle'          => '',
		'description'       => '',
		'description_style' => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts, $macro_secondary_button_shortcode_atts ), $atts, 'st_intro' );

	$computed_atts = array(
		'desktop_buttons'   => array(
			0 => array(
				'url'  => $atts['button1_url'],
				'text' => $atts['button1_text'],
				'icon' => $atts['button1_icon'],
			),
			1 => array(
				'url'  => $atts['button2_url'],
				'text' => $atts['button2_text'],
				'icon' => $atts['button2_icon'],
			),
			2 => array(
				'url'  => $atts['button3_url'],
				'text' => $atts['button3_text'],
				'icon' => $atts['button3_icon'],
			),
			3 => array(
				'url'  => $atts['button4_url'],
				'text' => $atts['button4_text'],
				'icon' => $atts['button4_icon'],
			),
			4 => array(
				'url'  => $atts['button5_url'],
				'text' => $atts['button5_text'],
				'icon' => $atts['button5_icon'],
			),
		),
		'secondary_buttons' => array(
			0 => array(
				'url'  => $atts['button6_url'],
				'text' => $atts['button6_text'],
				'icon' => $atts['button6_icon'],
			),
			1 => array(
				'url'  => $atts['button7_url'],
				'text' => $atts['button7_text'],
				'icon' => $atts['button7_icon'],
			),
			2 => array(
				'url'  => $atts['button8_url'],
				'text' => $atts['button8_text'],
				'icon' => $atts['button8_icon'],
			),
			3 => array(
				'url'  => $atts['button9_url'],
				'text' => $atts['button9_text'],
				'icon' => $atts['button9_icon'],
			),
			4 => array(
				'url'  => $atts['button10_url'],
				'text' => $atts['button10_text'],
				'icon' => $atts['button10_icon'],
			),
		),
	);

	return Timber::compile( 'templates/widgets/intro.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_intro', 'shortcode_st_intro' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_intro() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
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
			'label' => esc_html__( 'Description', 'strathcom' ),
			'attr'  => 'description',
			'type'  => 'textarea',
		),
		array(
			'label'   => esc_html__( 'Description style', 'strathcom' ),
			'attr'    => 'description_style',
			'type'    => 'select',
			'options' => array(
				''      => 'Normal',
				'story' => 'Story (Italic)',
			),
		),
	);

	shortcode_ui_register_for_shortcode( 'st_intro',
		array(
			'label'         => esc_html__( 'Intro', 'strathcom' ),
			'listItemImage' => 'dashicons-businessman',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts, $macro_secondary_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_intro' );
