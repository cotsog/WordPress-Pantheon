<?php
/**
 * Splash twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Registers the quick search script
 */
function quick_search() {
	wp_register_script( 'quick-search', get_template_directory_uri() . '/assets/src/js/quick-search.js', '', '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'quick_search', 11 );

/**
 * Function st_splash
 * Defining the shortcode.
 *
 * @param array $atts Twig specific variables.
 *
 * @return string
 */
function shortcode_st_splash( $atts ) {
	require get_template_directory() . '/templates/widgets/shortcode-macros.php';

	// Loads the quick search script!
	wp_enqueue_script( 'quick-search' );

	$shortcode_atts = array(
		'title'                 => '',
		'subtitle'              => '',
		'title_type'            => '',
		'description'           => '',
		'background_image_id'   => '',
		'background_video_url'  => '',
		'add_quick_search'      => '',
		'custom_class'          => '',
	);

	$atts = shortcode_atts( array_merge( $shortcode_atts, $macro_button_shortcode_atts ), $atts, 'st_splash' );

	$background_image_src        = wp_get_attachment_url( $atts['background_image_id'] );
	$background_video_src        = trim( $atts['background_video_url'] );
	$background_video_src_params = null;

	if ( strlen( $background_video_src ) > 0 ) {
		$background_video_id = YouTubeURL::parse_video_id( $background_video_src );

		if ( null !== $background_video_id ) {
			$background_video_src_params = array(
				'origin' => $_SERVER['SERVER_NAME'],
			);
			$background_video_src        = $background_video_id;
		} else {
			$background_video_src = null;
		}
	}

	$computed_atts = array(
		'background_image_src'        => $background_image_src,
		'background_video_src'        => $background_video_src,
		'background_video_src_params' => $background_video_src_params,
		'buttons'                     => array(
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

	return Timber::compile( 'templates/widgets/splash.twig', array_merge( $atts, $computed_atts ) );
}

add_shortcode( 'st_splash', 'shortcode_st_splash' );

/**
 * Defining the UI for editing the shortcode.
 */
function shortcode_ui_st_splash() {
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
			'label'       => esc_html__( 'Description', 'strathcom' ),
			'attr'        => 'description',
			'type'        => 'textarea',
			'description' => esc_html__( 'This description overlays the background image or color (set below)', 'strathcom' ),
			'encode'      => true,
			'meta'        => array(
				'class' => 'shortcake-richtext',
			),
		),
		array(
			'label'       => esc_html__( '* Background Image (required field)', 'strathcom' ),
			'attr'        => 'background_image_id',
			'type'        => 'attachment',
			'libraryType' => array( 'image' ),
			'addButton'   => esc_html__( 'Select Image', 'strathcom' ),
			'frameTitle'  => esc_html__( 'Select Image', 'strathcom' ),
		),
		array(
			'label'       => esc_html__( 'Background Video URL', 'strathcom' ),
			'attr'        => 'background_video_url',
			'type'        => 'url',
			'description' => esc_html__( 'When setting a video, a background image acts as backup to display on mobile or when video is not available.', 'strathcom' ),
		),
		array(
			'label'   => esc_html__( 'Add Search', 'strathcom' ),
			'attr'    => 'add_quick_search',
			'type'    => 'select',
			'options' => array(
				'off' => 'No Search',
				'quick-search-on' => 'Quick Search (Dropdown)',
				'keyword-search-on' => 'Keyword Search (Query)',
			),
		),
		array(
			'label' => esc_html__( 'Custom Class', 'strathcom' ),
			'attr'  => 'custom_class',
			'type'  => 'text',
		),
	);

	shortcode_ui_register_for_shortcode( 'st_splash',
		array(
			'label'         => esc_html__( 'Hero (Image/Video)', 'strathcom' ),
			'listItemImage' => 'dashicons-art',
			'attrs'         => array_merge( $shortcake_atts, $macro_button_shortcake_atts ),
		)
	);
}

add_action( 'register_shortcode_ui', 'shortcode_ui_st_splash' );
