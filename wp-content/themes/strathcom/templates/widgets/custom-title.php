<?php
/**
 * Smoke and mirrors twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_customtitle
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 * @return string
 */
function shortcode_st_customtitle( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'title' => '',
		'subtitle' => '',
		'title_image_id' => '',
		'title_image_url' => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts ), $atts, 'st_customtitle' );

	$title_image_src = wp_get_attachment_url( $atts['title_image_id'] );

	$computed_atts = array(
		'title_image_src' => $title_image_src,
	);

	return Timber::compile( 'templates/widgets/custom-title.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_customtitle', 'shortcode_st_customtitle' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_customtitle() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
		array(
			'label'  => esc_html__( 'Title', 'strathcom' ),
			'attr'   => 'title',
			'type'   => 'text',
		),
		array(
			'label'  => esc_html__( 'Subtitle', 'strathcom' ),
			'attr'   => 'subtitle',
			'type'   => 'text',
		),
		array(
			'label'  => esc_html__( 'Image (Recommended width: 1150px)', 'strathcom' ),
			'attr'   => 'title_image_id',
			'type'   => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label'  => esc_html__( 'Image link', 'strathcom' ),
			'attr'   => 'title_image_url',
			'type'   => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'st_customtitle',
		array(
			'label' => esc_html__( 'Custom Title', 'strathcom' ),
			'listItemImage' => 'dashicons-editor-aligncenter',
			'attrs' => $shortcake_atts,
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_customtitle' );
