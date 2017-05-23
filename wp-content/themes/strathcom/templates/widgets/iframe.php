<?php
/**
 * Iframe twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Function iframe_shortcode
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_iframe_shortcode( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	$shortcode_atts = array(
		'source'    => '',
		'name'      => '',
		'id'        => '',
		'class'     => '',
		'width'     => '',
		'height'    => '',
		'scrolling' => '',
		'border'    => '',
		'style'     => '',
	);

	$atts = shortcode_atts( $shortcode_atts, $atts, 'iframe_shortcode' );

	$source    = trim( $atts['source'] );
	$name      = $atts['name'];
	$id        = $atts['id'];
	$class     = $atts['class'];
	$width     = $atts['width'];
	$height    = $atts['height'];
	$scrolling = $atts['scrolling'];
	$border    = $atts['border'];
	$style     = $atts['style'];

	$computed_atts = array(
		'source'     => $source,
		'name'       => $name,
		'id'         => $id,
		'class'      => $class,
		'width'      => $width,
		'height'     => $height,
		'scrolling'  => $scrolling,
		'border'     => $border,
		'style'      => $style,
	);

	return Timber::compile( 'templates/widgets/iframe.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'iframe_shortcode', 'shortcode_iframe_shortcode' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_iframe_shortcode() {
	require get_template_directory() . '/templates/widgets/shortcake-macros.php';

	$shortcake_atts = array(
		array(
			'label' => esc_html__( 'Source', 'strathcom' ),
			'attr'  => 'source',
			'type'  => 'url',
		),
		array(
			'label' => esc_html__( 'Name', 'strathcom' ),
			'attr'  => 'name',
			'type'  => 'text',
		),
		array(
			'label' => esc_html__( 'ID', 'strathcom' ),
			'attr'  => 'id',
			'type'  => 'text',
		),
		array(
			'label' => esc_html__( 'Class', 'strathcom' ),
			'attr'  => 'class',
			'type'  => 'text',
		),
		array(
			'label' => esc_html__( 'Width', 'strathcom' ),
			'attr'  => 'width',
			'type'  => 'text',
		),
		array(
			'label' => esc_html__( 'Height', 'strathcom' ),
			'attr'  => 'height',
			'type'  => 'text',
		),
		array(
			'label'   => esc_html__( 'Scrolling', 'strathcom' ),
			'attr'    => 'scrolling',
			'type'    => 'select',
			'options' => array(
				'yes'  => 'Yes',
				'no'   => 'No',
				'auto' => 'Auto',
			),
		),
		array(
			'label'   => esc_html__( 'Disable Border?', 'strathcom' ),
			'attr'    => 'border',
			'type'    => 'select',
			'options' => array(
				'yes'  => 'Yes',
				'no'   => 'No',
			),
		),
		array(
			'label' => esc_html__( 'Inline Styles', 'strathcom' ),
			'attr'  => 'style',
			'type'  => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'iframe_shortcode',
		array(
			'label'         => esc_html__( 'Iframe Shortcode', 'strathcom' ),
			'listItemImage' => 'dashicons-welcome-view-site',
			'attrs'         => $shortcake_atts,
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_iframe_shortcode' );
