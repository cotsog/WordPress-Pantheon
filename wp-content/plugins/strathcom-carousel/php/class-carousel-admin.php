<?php
/**
 * Carousel admin interface
 *
 * @author  XWP
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Carousel_Admin
 *
 * @package StrathcomCarousel
 */
class Carousel_Admin {
	/**
	 * The Plugin instance.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * Enqueue handle name for Carousel Admin CSS
	 */
	const HANDLE_CSS = 'strathcom-carousel-admin-css';

	/**
	 * Enqueue handle name for Carousel Admin JS
	 */
	const HANDLE_JS = 'strathcom-carousel-admin-js';

	/**
	 * Constructor
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		add_action( 'add_meta_boxes_' . Plugin::CPT_SLUG_CAROUSEL, array( $this, 'custom_meta_boxes' ) );
		add_action( 'save_post_' . Plugin::CPT_SLUG_CAROUSEL, array( $this, 'save_carousel' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Add the custom metaboxes for the carousel creation page
	 *
	 * @action add_meta_boxes
	 *
	 * @return void
	 */
	public function custom_meta_boxes() {
		add_meta_box(
			'postcarouseldiv',
			__( 'Carousel Properties', 'strathcom-carousel' ),
			array( $this, 'custom_meta_boxes_html' ),
			Plugin::CPT_SLUG_CAROUSEL,
			'normal',
			'high'
		);
	}

	/**
	 * Create the custom metabox for carousel settings
	 *
	 * @return void
	 */
	public function custom_meta_boxes_html() {
		global $post;
		$display_mode = get_post_meta( $post->ID, Carousel::POST_META_DISPLAY_MODE, true );
		$display_mode = $display_mode ? $display_mode : Plugin::DEFAULT_DISPLAY_MODE;
		?>
		<div class="ar-radio-inputs">
			<label for="display-mode"><strong><?php esc_html_e( 'Carousel Display Mode', 'strathcom-carousel' ); ?></strong></label><br />
			<label class="ar-radio-button">
				<input type="radio" name="display-mode" value="slider" <?php checked( $display_mode, 'slider', true ); ?> /><span class="radio-span"><?php esc_html_e( 'Slider', 'strathcom-carousel' ); ?></span> <img src="<?php echo esc_attr( $this->plugin->dir_url . 'img/display_mode-slider.png' ); ?>" />
			</label>
			<label class="ar-radio-button">
				<input type="radio" name="display-mode" value="list" <?php checked( $display_mode, 'list', true ); ?> /><span class="radio-span"><?php esc_html_e( 'Static List', 'strathcom-carousel' ); ?></span> <img src="<?php echo esc_attr( $this->plugin->dir_url . 'img/display_mode-list.png' ); ?>" />
			</label>
			<label class="ar-radio-button">
				<input type="radio" name="display-mode" value="grid" <?php checked( $display_mode, 'grid', true ); ?> /><span class="radio-span"><?php esc_html_e( 'Static Grid', 'strathcom-carousel' ); ?></span> <img src="<?php echo esc_attr( $this->plugin->dir_url . 'img/display_mode-grid.png' ); ?>" />
			</label>
		</div>
		<?php
		$timing = get_post_meta( $post->ID, 'timing', true );
		$timing = $timing ? $timing : Plugin::DEFAULT_TIMING;
		?>

		<hr />
		<p class="carousel-timing" style="display:none;">
			<label><?php esc_html_e( 'Slide Display Time (in seconds)', 'strathcom-carousel' ); ?></label>
			<input name="timing" value="<?php echo intval( $timing ); ?>" />
		</p>
		<p>
			<label for="incentives"><?php esc_html_e( 'Enable Graphical Incentives', 'strathcom-carousel' ); ?></label>
			<input type="checkbox" name="incentives" <?php checked( get_post_meta( $post->ID, Carousel::POST_META_INCENTIVES, true ), 1, true ); ?> />
		</p>
		
		<?php
		$value = get_post_meta( $post->ID, Carousel::POST_META_ASPECT_RATIO, true );
		if ( empty( $value ) ) {
			$value = Image_Utils::SIXTEEN_NINE;
		}
		?>

		<hr />
		<div class="ar-radio-inputs">
			<label for="aspect-ratio"><strong><?php esc_html_e( 'Carousel Aspect Ratio', 'strathcom-carousel' ); ?></strong></label><br />
			<label class="ar-radio-button">
				<input type="radio" name="aspect-ratio" value="<?php echo esc_attr( Image_Utils::FOUR_THREE ); ?>" <?php checked( $value, Image_Utils::FOUR_THREE, true ); ?> /><span class="radio-span">4:3</span> <img src="http://placehold.it/100x75/?text=4:3" />
			</label>
			<label class="ar-radio-button">
				<input type="radio" name="aspect-ratio" value="<?php echo esc_attr( Image_Utils::SIXTEEN_NINE ); ?>" <?php checked( $value, Image_Utils::SIXTEEN_NINE, true ); ?> /><span class="radio-span">16:9</span> <img src="http://placehold.it/133x75/?text=16:9" />
			</label>
			<label class="ar-radio-button">
				<input type="radio" name="aspect-ratio" value="<?php echo esc_attr( Image_Utils::TWENTY_ONE_NINE ); ?>" <?php checked( $value, Image_Utils::TWENTY_ONE_NINE, true ); ?> /><span class="radio-span">21:9</span> <img src="http://placehold.it/175x75/?text=21:9" />
			</label>
			<label class="ar-radio-button">
				<input type="radio" name="aspect-ratio" value="<?php echo esc_attr( Image_Utils::SIXTY_EIGHT_SEVEN ); ?>" <?php checked( $value, Image_Utils::SIXTY_EIGHT_SEVEN, true ); ?> /><span class="radio-span">68:7</span> <img src="http://placehold.it/175x18/?text=68:7" />
			</label>
		</div>
		<?php
		wp_nonce_field( 'strathcom_carousel', 'strathcom_carousel_nonce' );
	}

	/**
	 * Handle saving the post_meta for a carousel.
	 *
	 * @return mixed $return return value for update_post_meta
	 */
	public function save_carousel() {
		global $post;
		$aspect_ratio = Image_Utils::SIXTEEN_NINE;

		if ( empty( $_POST['strathcom_carousel_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['strathcom_carousel_nonce'] ) ), 'strathcom_carousel' ) ) { // Input var okay.
			return false;
		}

		if ( ! isset( $_POST['display-mode'] ) ) { // Input var okay.
			return false;
		}

		$display_mode = sanitize_text_field( wp_unslash( $_POST['display-mode'] ) ); // Input var okay.

		update_post_meta( $post->ID, Carousel::POST_META_DISPLAY_MODE, $display_mode );

		if ( 'slider' === $display_mode ) {
			if ( ! isset( $_POST['timing'] ) ) { // Input var okay.
				return false;
			}

			update_post_meta( $post->ID, 'timing', intval( $_POST['timing'] ) ); // Input var okay.
		}

		if ( ! empty( $_POST['aspect-ratio'] ) ) { // Input var okay.
			$aspect_ratio = sanitize_text_field( wp_unslash( $_POST['aspect-ratio'] ) ); // Input var okay.
		}

		update_post_meta( $post->ID, Carousel::POST_META_ASPECT_RATIO, $aspect_ratio );

		if ( isset( $_POST['incentives'] ) ) { // Input var okay.
			update_post_meta( $post->ID, Carousel::POST_META_INCENTIVES, 1 );
		} else {
			update_post_meta( $post->ID, Carousel::POST_META_INCENTIVES, 0 );
		}

		do_action( 'strathcom_carousel_delete_transients' );

		return true;
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @action wp_enqueue_admin_scripts
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {

		wp_register_style( self::HANDLE_CSS, $this->plugin->dir_url . 'css/carousel-admin.css' );

		wp_enqueue_style( self::HANDLE_CSS );

		wp_register_script(
			self::HANDLE_JS,
			$this->plugin->dir_url . 'js/carousel-admin.js',
			array( 'jquery' ),
			'0.1',
			true
		);

		wp_enqueue_script( self::HANDLE_JS );
	}
}
