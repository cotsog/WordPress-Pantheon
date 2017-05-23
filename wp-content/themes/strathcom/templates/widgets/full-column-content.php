<?php
/**
 * Full Content twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_fullcontent
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_fullcontent( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'title'                => '',
		'subtitle'             => '',
		'title_type'           => '',
		'description'          => '',
		'background_hex_value' => '',
		'content_image_id'     => '',
		'custom_class'         => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts ), $atts, 'st_fullcontent' );

	$content_image_src = wp_get_attachment_url( $atts['content_image_id'] );

	$computed_atts = array(
		'content_image_src' => $content_image_src,
		'buttons'           => array(
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
			4 => array(
				'url'   => $atts['button5_url'],
				'text'  => $atts['button5_text'],
				'icon'  => $atts['button5_icon'],
				'class' => $atts['button5_class'],
			),
		),
	);

	return Timber::compile( 'templates/widgets/full-column-content.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_fullcontent', 'shortcode_st_fullcontent' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_fullcontent() {
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
			'label' => esc_html__( 'Description', 'strathcom' ),
			'attr'  => 'description',
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
			'label'       => esc_html__( 'Content Image', 'strathcom' ),
			'attr'        => 'content_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label' => esc_html__( 'Custom Class', 'strathcom' ),
			'attr'  => 'custom_class',
			'type'  => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'st_fullcontent',
		array(
			'label'         => esc_html__( 'One Column', 'strathcom' ),
			'listItemImage' => 'dashicons-admin-appearance',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_fullcontent' );
