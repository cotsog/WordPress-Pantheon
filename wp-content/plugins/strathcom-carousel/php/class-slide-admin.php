<?php
/**
 * Carousel scripts to show carousel/slider to the user.
 *
 * @author  XWP
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Slide_Admin
 *
 * @package StrathcomCarousel
 */
class Slide_Admin {
	/**
	 * Nonce Name.
	 */
	const NONCE_NAME = 'strathcom-slide-nonce-name';

	/**
	 * Nonce Action.
	 */
	const NONCE_ACTION = 'strathcom-slide-nonce-action';

	/**
	 * Slide Thumbnail label.
	 */
	const SLIDE_THUMBNAIL = 'strathcom-slide';

	/**
	 * Slide Width.
	 */
	const SLIDE_WIDTH = 1200;

	/**
	 * Slide Height.
	 */
	const SLIDE_HEIGHT = 675;

	/**
	 * Slide Minimum Width.
	 */
	const SLIDE_MINIMUM_WIDTH = 800;

	/**
	 * Slide Minimum Height.
	 */
	const SLIDE_MINIMUM_HEIGHT = 50;

	/**
	 * Handle for the scripts
	 */
	const SCRIPTS_HANDLE = 'strathcom-slide-admin';

	/**
	 * Label for slide Post Meta.
	 */
	const POST_META_SLIDE_URL_TARGET = 'slide_url_target';

	/**
	 * Label for slide Post Meta.
	 */
	const POST_META_SLIDE_SELECT = 'slide_select';

	/**
	 * Label for slide Post Meta.
	 */
	const POST_META_SLIDE_URL = 'slide_url';

	/**
	 * Label for slide Post Meta.
	 */
	const POST_META_SLIDE_PAGE = 'slide_page';

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin.
	 */
	public $plugin;

	/**
	 * Constructor
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		add_action( 'add_meta_boxes_' . Plugin::CPT_SLUG_SLIDE, array( $this, 'custom_meta_boxes' ) );
		add_action( 'save_post_' . Plugin::CPT_SLUG_SLIDE, array( $this, 'save_slide' ) );

		// Slide Admin scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_slide_admin_scripts' ) );

		// Image aspect ratio 16:9.
		add_image_size( self::SLIDE_THUMBNAIL, Slide_Admin::SLIDE_WIDTH, Slide_Admin::SLIDE_HEIGHT, true );
	}

	/**
	 * Add the custom metaboxes for the Slides creation/edit page
	 *
	 * @return void
	 */
	public function custom_meta_boxes() {
		add_meta_box( 'slide_select', __( 'Select Slide', 'strathcom-carousel' ), array( $this, 'render_select_slide' ), PLUGIN::CPT_SLUG_SLIDE, 'normal', 'high' );
		add_meta_box( 'slide_settings', __( 'Slide Settings', 'strathcom-carousel' ), array( $this, 'render_slide_settings' ), PLUGIN::CPT_SLUG_SLIDE, 'normal', 'high' );
	}

	/**
	 * Renders the select slide metabox for uploading or selecting a slide
	 *
	 * @return void
	 */
	public function render_select_slide() {
		global $post;

		// Get our slide ID if it exists.
		$slide_attachment_id = get_post_thumbnail_id( $post->ID );

		// Get the attachment source of the id.
		$slide_attachment_src = wp_get_attachment_image_src( $slide_attachment_id, 'full' );
		?>
		<div class="slide-size-warning <?php if ( $this->check_image_size( $slide_attachment_src[0] ) ) { echo 'hidden'; } ?>">
			<p><?php printf( esc_html__( 'Warning! This image is smaller than the minimum size of %1$dx%2$d pixels and will not be displayed.', 'strathcom-carousel' ), intval( SELF::SLIDE_MINIMUM_WIDTH ), intval( SELF::SLIDE_MINIMUM_HEIGHT ) ); ?></p>
		</div>

		<div class="slide-image">
		<?php if ( ! empty( $slide_attachment_src ) ) : ?>
			<img src="<?php echo esc_url( $slide_attachment_src[0] ); ?>" />
		<?php endif; ?>
		</div>

		<p class="hide-if-no-js">
			<a class="upload-slide-img <?php if ( ! empty( $slide_attachment_src ) ) { echo 'hidden'; } ?>"
			   href="#">
				<?php esc_html_e( 'Choose or upload a slide', 'strathcom-carousel' ); ?>
			</a>
			<a class="delete-slide-img <?php if ( empty( $slide_attachment_src ) ) { echo 'hidden'; } ?>"
			   href="#">
				<?php esc_html_e( 'Remove slide', 'strathcom-carousel' ); ?>
			</a>
		</p>

		<input class="slide_attachment_id" name="slide_attachment_id" type="hidden" value="<?php echo intval( $slide_attachment_id ); ?>" />
		<?php
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
	}

	/**
	 * Create the custom metabox for slide settings
	 *
	 * @return void
	 */
	public function render_slide_settings() {
		global $post;

		$slide_url_target = get_post_meta( $post->ID, self::POST_META_SLIDE_URL_TARGET, true );
		$slide_select     = get_post_meta( $post->ID, self::POST_META_SLIDE_SELECT, true );
		$slide_url        = get_post_meta( $post->ID, self::POST_META_SLIDE_URL, true );
		$slide_page       = get_post_meta( $post->ID, self::POST_META_SLIDE_PAGE, true );

		if ( '' === $slide_select ) {
			$slide_select = 'manual';
		}
		?>
		<div class="inside">
			<p>
				<label><?php esc_html_e( 'Slide Linking Options', 'strathcom-carousel' ); ?></label><br />
				<input type="radio" name="slide_select" value="manual" <?php checked( $slide_select, 'manual', true ) ?> /><label for="slide_select"><?php esc_html_e( 'Enter A URL', 'strathcom-carousel' ); ?></label>
				<input type="radio" name="slide_select" value="select" <?php checked( $slide_select, 'select', true ) ?> /><label for="slide_select"><?php esc_html_e( 'Choose A Page', 'strathcom-carousel' ); ?></label>
			</p>
			<div class="slide_url_manual <?php echo 'manual' === $slide_select ?: 'hidden'; ?>">
				<p>
					<label for="slide_url"><?php esc_html_e( 'Slide Link URL', 'strathcom-carousel' ); ?></label>
					<input type="text" title="slide_url" name="slide_url" style="width: 99%;" value="<?php echo esc_url( $slide_url ); ?>" />
				</p>
			</div>
			<div class="slide_url_select <?php echo 'select' === $slide_select ?: 'hidden'; ?>">
				<p>
					<label for="slide_page"><?php esc_html_e( 'Slide Link Page', 'strathcom-carousel' ); ?></label><br />
					<?php wp_dropdown_pages( array( 'name' => 'slide_page', 'selected' => intval( $slide_page ) ) ); ?>
				</p>
			</div>
			<p>
				<label for="slide_url_target"><?php esc_html_e( 'Open In', 'strathcom-carousel' ); ?></label><br />
				<select name="slide_url_target">
					<option value="0" <?php selected( $slide_url_target, 0, true ) ?>><?php esc_attr_e( 'Existing Window/Tab', 'strathcom-carousel' ); ?></option>
					<option value="1" <?php selected( $slide_url_target, 1, true ) ?>><?php esc_attr_e( 'New Window/Tab', 'strathcom-carousel' ); ?></option>
				</select>
			</p>
		</div>
		<?php
	}

	/**
	 * Saves the post_meta for a slide.
	 *
	 * @return mixed $return return value of update_post meta, or boolean
	 */
	public function save_slide() {
		global $post;

		if ( empty( $_POST[ self::NONCE_NAME ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ) { // Input var okay.
			return;
		}

		if ( ! empty( $_POST['slide_attachment_id'] ) ) { // Input var okay.
			$new_img_id = intval( wp_unslash( $_POST['slide_attachment_id'] ) ); // Input var okay.
			set_post_thumbnail( $post, $new_img_id );
			$this->plugin->image_utils->save_img_aspect_ratios( $post->ID );
		} else {
			delete_post_thumbnail( $post );
		}

		if ( isset( $_POST['slide_url_target'] ) ) { // Input var okay.
			$slide_url_target = intval( wp_unslash( $_POST['slide_url_target'] ) ); // Input var okay.
			update_post_meta( $post->ID, self::POST_META_SLIDE_URL_TARGET, wp_slash( $slide_url_target ) );
		}

		if ( isset( $_POST['slide_select'] ) ) { // Input var okay.
			$slide_select = sanitize_text_field( wp_unslash( $_POST['slide_select'] ) ); // Input var okay.

			if ( 'manual' === $slide_select ) {
				if ( isset( $_POST['slide_url'] ) ) { // Input var okay.
					$slide_url = esc_url_raw( wp_unslash( $_POST['slide_url'] ) ); // Input var okay.
					update_post_meta( $post->ID, self::POST_META_SLIDE_URL, wp_slash( $slide_url ) );
					update_post_meta( $post->ID, self::POST_META_SLIDE_PAGE, 0 );
					$this->save_slide_select( $post->ID, $slide_select );
				}
			} elseif ( 'select' === $slide_select ) {
				if ( isset( $_POST['slide_page'] ) ) { // Input var okay.
					$slide_page = intval( wp_unslash( $_POST['slide_page'] ) ); // Input var okay.
					update_post_meta( $post->ID, self::POST_META_SLIDE_PAGE, wp_slash( $slide_page ) );
					update_post_meta( $post->ID, self::POST_META_SLIDE_URL, '' );
					$this->save_slide_select( $post->ID, $slide_select );
				}
			}
		}
		do_action( 'strathcom_carousel_delete_transients' );
	}

	/**
	 * Save Slide Select
	 *
	 * Save the method in which we should link to a slide, only if they've selected a slide_select action
	 *
	 * @param int    $slide_id The ID of the slide.
	 * @param string $slide_select The slide_select action.
	 */
	public function save_slide_select( $slide_id, $slide_select ) {
		update_post_meta( $slide_id, self::POST_META_SLIDE_SELECT, wp_slash( $slide_select ) );
	}

	/**
	 * Check Image Size
	 *
	 * Make sure the image is larger than the minimum
	 *
	 * @param string $image The image to check.
	 *
	 * @return array
	 */
	public function check_image_size( $image ) {
		if ( empty( $image ) ) {
			return true;
		}

		$image = $this->get_image_size( $image );

		if ( $image[0] < self::SLIDE_MINIMUM_WIDTH || $image[1] < self::SLIDE_MINIMUM_HEIGHT ) {
			return false;
		}

		return true;
	}

	/**
	 * Get Image Size
	 *
	 * Wrapper for the getimagesize PHP function (wrapped so that we can mock during testing)
	 *
	 * @param array $file File details of the file being uploaded.
	 *
	 * @return array
	 */
	public function get_image_size( $file ) {
		return getimagesize( $file );
	}

	/**
	 * Enqueue Slide Admin Scripts
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_slide_admin_scripts() {
		wp_enqueue_media();

		wp_register_style( self::SCRIPTS_HANDLE, $this->plugin->dir_url . 'css/slide-admin.css' );
		wp_enqueue_style( self::SCRIPTS_HANDLE );

		$exports = array(
			'modalTitle'        => __( 'Select or upload a slide image', 'strathcom-carousel' ),
			'buttonText'        => __( 'Insert slide image', 'strathcom-carousel' ),
			'slideMinWidth'     => self::SLIDE_MINIMUM_WIDTH,
			'slideMinHeight'    => self::SLIDE_MINIMUM_HEIGHT,
		);

		wp_register_script(
			self::SCRIPTS_HANDLE,
			$this->plugin->dir_url . 'js/slide-admin.js',
			array( 'jquery' ),
			'0.1',
			true
		);

		wp_scripts()->add_data(
			self::SCRIPTS_HANDLE,
			'data',
			sprintf( 'var _strathcomSlideExports = %s;', wp_json_encode( $exports ) )
		);

		wp_add_inline_script( self::SCRIPTS_HANDLE, 'strathcomSlideAdmin.init();', 'after' );
		wp_enqueue_script( self::SCRIPTS_HANDLE );
	}
}
