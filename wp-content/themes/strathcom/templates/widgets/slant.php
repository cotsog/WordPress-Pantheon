<?php
/**
 * Slant twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_slant
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_slant( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'description'           => '',
		'secondary_description' => '',
		'background_image_id'   => '',
		'background_hex_value'  => '',
		'content_image_id'      => '',
		'content_position'      => '',
		'custom_class'          => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts, $macro_secondary_button_shortcode_atts ), $atts, 'st_slant' );

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
		'secondary_buttons'    => array(
			0 => array(
				'url'   => $atts['button6_url'],
				'text'  => $atts['button6_text'],
				'icon'  => $atts['button6_icon'],
				'class' => $atts['button6_class'],
			),
			1 => array(
				'url'   => $atts['button7_url'],
				'text'  => $atts['button7_text'],
				'icon'  => $atts['button7_icon'],
				'class' => $atts['button7_class'],
			),
			2 => array(
				'url'   => $atts['button8_url'],
				'text'  => $atts['button8_text'],
				'icon'  => $atts['button8_icon'],
				'class' => $atts['button8_class'],
			),
			3 => array(
				'url'   => $atts['button9_url'],
				'text'  => $atts['button9_text'],
				'icon'  => $atts['button9_icon'],
				'class' => $atts['button9_class'],
			),
			4 => array(
				'url'   => $atts['button10_url'],
				'text'  => $atts['button10_text'],
				'icon'  => $atts['button10_icon'],
				'class' => $atts['button10_class'],
			),
		),
	);

	return Timber::compile( 'templates/widgets/slant.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_slant', 'shortcode_st_slant' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_slant() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
		array(
			'label'       => esc_html__( 'Description (Over Background Image)', 'strathcom' ),
			'attr'        => 'description',
			'type'        => 'textarea',
			'description' => esc_html__( 'This description overlays the background image or color (set below)', 'strathcom' ),
			'encode'      => true,
			'meta'        => array(
				'class'     => 'shortcake-richtext',
			),
		),
		array(
			'label'       => esc_html__( 'Secondary Description (Over Background Color)', 'strathcom' ),
			'attr'        => 'secondary_description',
			'type'        => 'textarea',
			'description' => esc_html__( 'This description is coupled with "Content Image" and has no background', 'strathcom' ),
			'encode'      => true,
			'meta'        => array(
				'class' => 'shortcake-richtext',
			),
		),
		array(
			'label'       => esc_html__( 'Content Image (Over Background Color)', 'strathcom' ),
			'attr'        => 'content_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
			'description' => esc_html__( 'This image is placed on the side with no background', 'strathcom' ),
		),
		array(
			'label'       => esc_html__( 'Background Image', 'strathcom' ),
			'attr'        => 'background_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
			'description' => esc_html__( 'This will contain title, description and primary buttons', 'strathcom' ),
		),
		array(
			'label'       => esc_html__( 'Background Shade (Hex Value or RGB)', 'strathcom' ),
			'attr'        => 'background_hex_value',
			'type'        => 'text',
			'description' => esc_html__( 'In the event there is no background image, choose a color', 'strathcom' ),
		),
		array(
			'label'   => esc_html__( 'Background position', 'strathcom' ),
			'attr'    => 'content_position',
			'type'    => 'select',
			'options' => array(
				'right' => 'Right',
				'left'  => 'Left',
			),
		),
		array(
			'label' => esc_html__( 'Custom Class', 'strathcom' ),
			'attr'  => 'custom_class',
			'type'  => 'text',
		),
	);
	shortcode_ui_register_for_shortcode(
		'st_slant',
		array(
			'label'         => esc_html__( 'Slant', 'strathcom' ),
			'listItemImage' => 'dashicons-tickets-alt',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts, $macro_secondary_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_slant' );
