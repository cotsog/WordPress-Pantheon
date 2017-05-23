<?php
/**
 * Smoke and mirrors twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function st_smokenmirrors
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 * @return string
 */
function shortcode_st_smokenmirrors( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'background_image_id' => '',
		'height' => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts ), $atts, 'st_smokenmirrors' );

	$background_image_src = wp_get_attachment_url( $atts['background_image_id'] );

	$computed_atts = array(
		'background_image_src' => $background_image_src,
	);

	return Timber::compile( 'templates/widgets/smokenmirrors.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_smokenmirrors', 'shortcode_st_smokenmirrors' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_smokenmirrors() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
		array(
			'label'  => esc_html__( 'Background Image', 'strathcom' ),
			'attr'   => 'background_image_id',
			'type'   => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label'  => esc_html__( 'Height (pixels)', 'strathcom' ),
			'attr'   => 'height',
			'type'   => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'st_smokenmirrors',
		array(
			'label' => esc_html__( 'SmokeNMirrors', 'strathcom' ),
			'listItemImage' => 'dashicons-welcome-view-site',
			'attrs' => $shortcake_atts,
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_smokenmirrors' );
