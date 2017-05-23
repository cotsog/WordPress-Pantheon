<?php
/**
 * Sidebar Content twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_content_sidebar
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_content_sidebar( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'title'               => '',
		'title_type'          => '',
		'description'         => '',
		'content_image_id'    => '',
		'content_position'    => '',
		'custom_class'        => '',
		'description_sidebar' => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts ), $atts, 'st_content_sidebar' );

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

	return Timber::compile( 'templates/widgets/content-sidebar.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_content_sidebar', 'shortcode_st_content_sidebar' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_content_sidebar() {
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
			'label'       => esc_html__( 'Content Image (not required)', 'strathcom' ),
			'attr'        => 'content_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label' => esc_html__( 'Content (Sidebar)', 'strathcom' ),
			'attr'  => 'description_sidebar',
			'type'  => 'textarea',
			'encode' => true,
			'meta'  => array(
				'class' => 'shortcake-richtext',
			),
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
		'st_content_sidebar',
		array(
			'label'         => esc_html__( 'Content w/ Sidebar', 'strathcom' ),
			'listItemImage' => 'dashicons-tickets-alt',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_content_sidebar' );
