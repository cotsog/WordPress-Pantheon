<?php
/**
 * Fluid Boxes twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_fluid_boxes
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_fluid_boxes( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'title'                => '',
		'title_type'           => '',
		'description'          => '',
		'content_image_id'     => '',
		'background_hex_value' => '',
		'background_image_id'  => '',
		'content_position'     => '',
		'custom_class'         => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts ), $atts, 'st_fluid_boxes' );

	$background_image_src = wp_get_attachment_url( $atts['background_image_id'] );
	$content_image_src    = wp_get_attachment_url( $atts['content_image_id'] );

	$computed_atts = array(
		'background_image_src' => $background_image_src,
		'content_image_src'    => $content_image_src,
		'buttons'              => array(
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
		),
	);

	return Timber::compile( 'templates/widgets/fluid-boxes.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_fluid_boxes', 'shortcode_st_fluid_boxes' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_fluid_boxes() {
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
			'label' => esc_html__( 'Description', 'strathcom' ),
			'attr'  => 'description',
			'type'  => 'textarea',
			'encode' => true,
			'meta'  => array(
				'class' => 'shortcake-richtext',
			),
		),
		array(
			'label'       => esc_html__( 'Background Image', 'strathcom' ),
			'attr'        => 'background_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label'       => esc_html__( 'Background Shade (Hex Value or RGB)', 'strathcom' ),
			'attr'        => 'background_hex_value',
			'type'        => 'text',
			'description' => esc_html__( 'Background of the content box (no image).', 'strathcom' ),
		),
		array(
			'label'       => esc_html__( 'Content Image (not required)', 'strathcom' ),
			'attr'        => 'content_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label'   => esc_html__( 'Content position', 'strathcom' ),
			'attr'    => 'content_position',
			'type'    => 'select',
			'options' => array(
				'left'  => 'Left',
				'right' => 'Right',
			),
		),
		array(
			'label' => esc_html__( 'Custom Class', 'strathcom' ),
			'attr'  => 'custom_class',
			'type'  => 'text',
		),
	);
	shortcode_ui_register_for_shortcode(
		'st_fluid_boxes',
		array(
			'label'         => esc_html__( 'Fluid Boxes', 'strathcom' ),
			'listItemImage' => 'dashicons-tickets-alt',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_fluid_boxes' );
