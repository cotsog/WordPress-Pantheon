<?php
/**
 * Carousel scripts to show carousel/slider to the user.
 *
 * @author  XWP
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Carousel
 *
 * @package StrathcomCarousel
 */
class Carousel {
	/**
	 * Enqueue handle name for slider
	 */
	const HANDLE_FLEXSLIDER = 'strathcom-flexslider';

	/**
	 * Enqueue handle name for carousel
	 */
	const HANDLE_CAROUSEL = 'strathcom-carousel';

	/**
	 * The Post Meta for saving the Carousel aspect ratio.
	 */
	const POST_META_ASPECT_RATIO = 'strathcom-carousel-aspect_ratio';

	/**
	 * The Post Meta for saving the Carousel incentive switch.
	 */
	const POST_META_INCENTIVES = 'strathcom-carousel-incentives';

	/**
	 * The Post Meta for saving the Carousel display mode.
	 */
	const POST_META_DISPLAY_MODE = 'strathcom-carousel-display_mode';

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin.
	 */
	public $plugin;

	/**
	 * Array of slides contained within carousel.
	 *
	 * @var array
	 */
	public $slides;

	/**
	 * The filter name for modifying slides.
	 */
	const SLIDES_FILTER_NAME = 'strathcom-carousel-insert-slides';

	/**
	 * Constructor
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_filter( self::SLIDES_FILTER_NAME, array( $this, 'add_graphical_incentives' ), 10, 3 );
	}

	/**
	 * Enqueue scripts
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_register_script(
			Carousel::HANDLE_FLEXSLIDER,
			$this->plugin->dir_url . 'js/flexslider/jquery.flexslider-min.js',
			array( 'jquery' ),
			'0.1',
			true
		);

		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script(
			Carousel::HANDLE_CAROUSEL,
			$this->plugin->dir_url . 'js/carousel' . $min . '.js',
			array( 'jquery', Carousel::HANDLE_FLEXSLIDER ),
			'0.1',
			true
		);

		wp_add_inline_script( Carousel::HANDLE_CAROUSEL, 'strathcomCarousel.init();', 'after' );
		wp_enqueue_script( Carousel::HANDLE_CAROUSEL );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @action wp_enqueue_admin_scripts
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {

		wp_register_script(
			Carousel::HANDLE_FLEXSLIDER,
			$this->plugin->dir_url . 'js/flexslider/jquery.flexslider-min.js',
			array( 'jquery' ),
			'0.1',
			true
		);

		wp_register_script(
			Carousel::HANDLE_CAROUSEL,
			$this->plugin->dir_url . 'js/carousel.js',
			array( 'jquery', 'wp-util', 'shortcode-ui', Carousel::HANDLE_FLEXSLIDER ),
			'0.1',
			true
		);

		wp_add_inline_script( Carousel::HANDLE_CAROUSEL, 'strathcomCarousel.init();', 'after' );
		wp_enqueue_script( Carousel::HANDLE_CAROUSEL );
	}

	/**
	 * Render Carousel Markup
	 *
	 * Construct and render carousel markup.
	 *
	 * @param int $carousel_id The ID of the carousel post.
	 *
	 * @return void
	 */
	public function render_carousel( $carousel_id ) {
		$slides       = $this->get_slides( $carousel_id );
		$display_mode = $this->get_carousel_display_mode( $carousel_id );

		if ( 'slider' === $display_mode ) :
		?>
		<div class="carousel" data-toggle="carousel" data-timing="<?php echo intval( $this->get_carousel_timing( $carousel_id ) ); ?>">
		<?php
		else :
		?>
		<div class="carousel-static <?php echo esc_attr( $display_mode ); ?>">
		<?php endif; ?>
			<ul class="slides">
			<?php
			foreach ( $slides as $slide ) :
				$this->render_slide_markup( $slide );
			endforeach;
			?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Render Slide Markup
	 *
	 * Construct and render slide markup.
	 *
	 * @param object $slide Slide object.
	 *
	 * @return void
	 */
	public function render_slide_markup( $slide ) {
		?>
		<li>
			<a href="<?php echo esc_url( $slide->link ); ?>"<?php if ( 1 === (int) $slide->link_target ) { echo ' target="_blank"'; } ?>>
				<img src="<?php echo esc_url( $slide->image->url ); ?>" width="<?php echo esc_attr( $slide->image->width ); ?>" height="<?php echo esc_attr( $slide->image->height ); ?>" alt="<?php echo esc_attr( $slide->image->alt ); ?>" title="<?php echo esc_attr( $slide->image->title ); ?>" />
			</a>
		</li>
		<?php
	}

	/**
	 * Get Carousel Timing
	 *
	 * Fetches the millisecond value of the delay set between slides from the Carousel meta data.
	 *
	 * @param int $carousel_id The ID of the carousel post.
	 *
	 * @return int
	 */
	public function get_carousel_timing( $carousel_id ) {
		$timing = intval( get_post_meta( $carousel_id, 'timing', true ) );

		if ( $timing > 0 ) {
			return $timing * 1000;
		} else {
			return Plugin::DEFAULT_TIMING * 1000;
		}
	}

	/**
	 * Get Carousel display mode
	 *
	 * Fetches the display mode (slider/list/grid) from the Carousel meta data.
	 *
	 * @param int $carousel_id The ID of the carousel post.
	 *
	 * @return int
	 */
	public function get_carousel_display_mode( $carousel_id ) {
		$display_mode = get_post_meta( $carousel_id, Carousel::POST_META_DISPLAY_MODE, true );

		if ( ! empty( $display_mode ) ) {
			return $display_mode;
		} else {
			return Plugin::DEFAULT_DISPLAY_MODE;
		}
	}

	/**
	 * Get Carousels
	 *
	 * Returns a list of all the Carousels setup on the site.
	 *
	 * @return array
	 */
	public function get_carousels() {
		$carousels = array();
		$posts = get_posts( array( 'post_type' => Plugin::CPT_SLUG_CAROUSEL ) );

		if ( count( $posts ) > 0 ) {
			foreach ( $posts as $carousel ) {
				$carousels[] = array(
					'ID'    => $carousel->ID,
					'title' => $carousel->post_title,
				);
			}
		}

		return $carousels;
	}

	/**
	 * Get Slides
	 *
	 * Gets the slides that have been added to a Carousel.
	 *
	 * @param int $carousel_id The ID of the carousel post.
	 *
	 * @return array
	 */
	public function get_slides( $carousel_id ) {
		$blog_id      = get_current_blog_id();
		$slides       = $this->get_connected_slides( $carousel_id );
		$slides       = apply_filters( self::SLIDES_FILTER_NAME, $slides, $carousel_id, $blog_id );
		$slides_array = array();
		$aspect_ratio = get_post_meta( $carousel_id, Carousel::POST_META_ASPECT_RATIO, true );

		if ( ! empty( $slides->posts ) && is_array( $slides->posts ) ) {
			foreach ( $slides->posts as $slide ) {

				if ( Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES === $slide->post_type ) {
					switch_to_blog( 1 );
				}

				if ( has_post_thumbnail( $slide ) && 'publish' === $slide->post_status ) {

					if ( 'select' === get_post_meta( $slide->ID, Slide_Admin::POST_META_SLIDE_SELECT, true ) ) {
						$slide_url = get_permalink( intval( get_post_meta( $slide->ID, Slide_Admin::POST_META_SLIDE_PAGE, true ) ) );
					} else {
						$slide_url = get_post_meta( $slide->ID, Slide_Admin::POST_META_SLIDE_URL, true );
					}

					$thumbnail_id = get_post_thumbnail_id( $slide->ID );
					$slide_image = wp_get_attachment_image_src( $thumbnail_id, 'full' ); // Full resolution, original size uploaded.

					if ( ! empty( $aspect_ratio ) ) {

						// This $image value is in the same format as wp_get_attachment_image_src().
						$image = $this->plugin->image_utils->get_slide_attachment_src_by_aspect_ratio( $slide->ID, $aspect_ratio );

						// If the image is smaller than the standard, use fall back sizing.
					} else {

						if ( ( $slide_image[1] < Slide_Admin::SLIDE_WIDTH ) || ( $slide_image[2] < Slide_Admin::SLIDE_HEIGHT ) ) {
							$slide_size_thumbnail = Slide_Admin::SLIDE_THUMBNAIL;
						} else {
							$slide_size_thumbnail = Slide_Admin::SLIDE_THUMBNAIL;
						}

						$image = wp_get_attachment_image_src( $thumbnail_id, $slide_size_thumbnail );
					}

					// Images that are too small are not to be rendered.
					if (
						( $slide_image[1] > Slide_Admin::SLIDE_MINIMUM_WIDTH )
						&&
						( $slide_image[2] > Slide_Admin::SLIDE_MINIMUM_HEIGHT )
						&&
					    ! empty( $image )
					) {
						$slides_array[] = (object) array(
							'link'        => $slide_url,
							'link_target' => get_post_meta( $slide->ID, Slide_Admin::POST_META_SLIDE_URL_TARGET, true ),
							'image'       => (object) array(
								'url'     => $image[0],
								'width'   => $image[1],
								'height'  => $image[2],
								'alt'     => get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ),
								'title'   => get_post_field( 'post_content', $thumbnail_id ),
							),
						);
					}
				}// End if().

				if ( Plugin::CPT_SLUG_GRAPHICAL_INCENTIVES === $slide->post_type ) {
					restore_current_blog();
				}
			}// End foreach().
		}// End if().

		wp_reset_postdata();

		return $slides_array;
	}

	/**
	 * Get Connected Slides
	 *
	 * Fetch connected slides from the P2P plugin.
	 *
	 * @param int $carousel_id The ID of the carousel.
	 *
	 * @return array
	 */
	public function get_connected_slides( $carousel_id ) {
		return p2p_type( Posts_To_Posts::CONNECTION_NAME )->get_connected( get_post( $carousel_id ) );
	}

	/**
	 * Insert incentive object into Carousel.
	 *
	 * Adds the incentive post object to the
	 * array of posts sent in the $slides object.
	 *
	 * "selected carousels" are those set via checkbox
	 * in the Edit Graphical Incentives screen.
	 *
	 * @uses get_single_incentives_carousels
	 * @uses explode_carousel_values
	 *
	 * @filter strathcom-carousel-insert-slides
	 *
	 * @param object $slides Query object sent from filter.
	 * @param string $carousel_id The ID of the present Carousel (CPT).
	 * @param string $blog_id The requested Blog (Network Site) ID.
	 *
	 * @return object
	 */
	public function add_graphical_incentives( $slides, $carousel_id = '', $blog_id = '' ) {
		if ( empty( $slides->posts ) ) {
			return $slides;
		}

		$incentives = $this->plugin->gi_utils->get_single_incentives_carousels();

		if ( ! empty( $incentives ) && is_array( $incentives ) ) {
			foreach ( $incentives as $incentive_id => $incentive_carousels ) {

				// Get an array of selected carousels broken down by blog id.
				$selected_carousels_array = $this->plugin->gi_utils->explode_carousel_values( $incentive_carousels );

				// If the requested blog_id is found in the selected carousels array...
				if ( ! empty( $selected_carousels_array[ $blog_id ] ) ) {

					// Get the selected carousel ids that are found in the requested blog.
					$carousel_ids = $selected_carousels_array[ $blog_id ];

					// Check if the requested carousel ID is found in the array of selected carousels.
					if ( ! empty( $carousel_ids ) && is_array( $carousel_ids ) && in_array( (string) $carousel_id, $carousel_ids, true ) ) {

						// Push the incentive post object.
						switch_to_blog( 1 );
						array_unshift( $slides->posts, get_post( $incentive_id ) );
						restore_current_blog();
					}
				}
			}
		}
		return $slides;
	}
}
