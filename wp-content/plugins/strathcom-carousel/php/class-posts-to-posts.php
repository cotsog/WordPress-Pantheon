<?php
/**
 * Posts to Posts Config.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Posts_To_Posts
 *
 * @package StrathcomCarousel
 */
class Posts_To_Posts {
	/**
	 * CSS Handle
	 */
	const CSS_HANDLE = 'strathcom-carousel-p2p-css';

	/**
	 * Connection name.
	 */
	const CONNECTION_NAME = 'slide_to_carousel';

	/**
	 * The plugin instance
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Constructor
	 *
	 * @see    Plugin::init()
	 * @see    Plugin::__construct()
	 *
	 * @action after_setup_theme.
	 *
	 * @param object $plugin the plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'p2p_init', array( $this, 'register_p2p_connection' ) );
		add_filter( 'p2p_connected_title', array( $this, 'add_image_to_p2p_title' ), 10, 2 );
		add_filter( 'p2p_candidate_title', array( $this, 'add_image_to_p2p_title' ), 10, 2 );
	}

	/**
	 * Register CPT connections with Posts 2 Posts plugin.
	 *
	 * @action p2p_init
	 */
	public function register_p2p_connection() {
		p2p_register_connection_type( array(
			'name'              => self::CONNECTION_NAME,
			'from'              => Plugin::CPT_SLUG_CAROUSEL,
			'to'                => Plugin::CPT_SLUG_SLIDE,
			'reciprocal'        => true,
			'admin_column'      => 'any',
			'admin_dropdown'    => 'any',
			'sortable'          => 'any',
			'title'             => array(
			'from'  => __( 'Connected Slides', 'strathcom-carousel' ),
			'to'    => __( 'Connected Carousels', 'strathcom-carousel' ),
			),
			'from_labels'       => array(
			'singular_name' => __( 'Carousels', 'strathcom-carousel' ),
			'search_items'  => __( 'Search Carousels', 'strathcom-carousel' ),
			'not_found'     => __( 'No Carousels found.', 'strathcom-carousel' ),
			'create'        => __( 'Add to Carousel', 'strathcom-carousel' ),
			'column_title'  => __( 'Connected Slides', 'strathcom-carousel' ),
			),
			'to_labels'         => array(
			'singular_name' => __( 'Slides', 'strathcom-carousel' ),
			'search_items'  => __( 'Search Slides', 'strathcom-carousel' ),
			'not_found'     => __( 'No Slides found.', 'strathcom-carousel' ),
			'create'        => __( 'Add Slide', 'strathcom-carousel' ),
			'column_title'  => __( 'Connected Carousels', 'strathcom-carousel' ),
			),
			'admin_box'         => array(
			'show'      => 'any',
			'context'   => 'advanced',
			),
		) );
	}

	/**
	 * Add the Featured Image to the slide display in P2P metabox.
	 *
	 * @param string $title Post title.
	 * @param object $post The WP Post object.
	 *
	 * @return string
	 */
	public function add_image_to_p2p_title( $title, $post ) {
		if ( Plugin::CPT_SLUG_SLIDE === $post->post_type ) {
			if ( has_post_thumbnail( $post ) ) {
				$url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), Slide_Admin::SLIDE_THUMBNAIL );
				if ( true !== $this->plugin->slide_admin->check_image_size( $url[0] ) ) {
					$title .= '</a><br /><br /><div class="slide-size-warning"><p>' . sprintf( esc_html__( 'Warning! This image is smaller than the minimum size of %dx%d pixels and will not be displayed.', 'strathcom-carousel' ), intval( Slide_Admin::SLIDE_MINIMUM_WIDTH ), intval( Slide_Admin::SLIDE_MINIMUM_HEIGHT ) ) . '</p></div>
					<a href="' . esc_url( get_edit_post_link( $post ) ) . '">';
				}
				$title .= '<br /><img class="strathcom-carousel-preview-image" src="' . esc_url( $url[0] ) . '" />';

			} else {
				$title .= '<br /><img class="strathcom-carousel-preview-image" src="' . esc_url( 'http://placehold.it/350x197/?text=No+Slide+Found' ) . '" />';
			}
		}

		return $title;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @action admin_enqueue_scripts
	 *
	 * @param string $page The page file.
	 */
	public function admin_scripts( $page ) {
		if ( 'edit.php' !== $page && 'post.php' !== $page && 'post-new.php' !== $page ) {
			return;
		}
		wp_register_style( self::CSS_HANDLE, $this->plugin->dir_url . 'css/posts-to-posts.css' );
		wp_enqueue_style( self::CSS_HANDLE );
	}
}
