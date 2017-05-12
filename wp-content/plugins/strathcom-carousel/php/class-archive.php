<?php
/**
 * Slide Archive Post Status
 * and related functionality.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Archive
 *
 * @package StrathcomCarousel
 */
class Archive {
	/**
	 * Archived Post Status.
	 */
	const POST_STATUS = 'archived';

	/**
	 * Nonce Name.
	 */
	const NONCE_NAME = 'strathcom-carousel-archive-nonce-name';

	/**
	 * Nonce Name.
	 */
	const NONCE_ACTION = 'strathcom-carousel-archive-nonce-action';

	/**
	 * Script Handle.
	 */
	const SCRIPT_HANDLE = 'strathcom-carousel-archive-js';

	/**
	 * CSS Handle.
	 */
	const CSS_HANDLE = 'strathcom-carousel-archive-css';

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin class.
	 */
	public $plugin;

	/**
	 * Localized "Archived" string.
	 *
	 * @var string
	 */
	var $l10n_status;

	/**
	 * Class Constructor
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
		$this->l10n_status = __( 'Archived', 'strathcom-carousel' );

		// Register custom post status.
		add_action( 'init', array( $this, 'archived_post_status' ) );
		add_action( 'display_post_states', array( $this, 'add_archived_post_state' ) );

		add_action( 'post_submitbox_misc_actions', array( $this, 'render_ui' ) );

		add_action( 'edit_form_after_title', array( $this, 'render_warnings' ) );

		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

		// Enqueue JS.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Register Archived post status.
	 *
	 * @action init
	 */
	public function archived_post_status() {
		$args = array(
			'label'                     => __( 'Archived', 'strathcom-carousel' ),
			'public'                    => false,
			'private'                   => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => true,
			// @codingStandardsIgnoreStart
			'label_count'               => _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'strathcom-carousel' ),
			// @codingStandardsIgnoreEnd
		);

		$args = apply_filters( 'strathcom_carousel_archived_post_status_args', $args );
		register_post_status( self::POST_STATUS, $args );
	}

	/**
	 * Display Archived status in Post List view.
	 *
	 * @action display_post_states
	 *
	 * @param array $states Post states.
	 *
	 * @return array Updated Post states.
	 */
	public function add_archived_post_state( $states = array() ) {
		global $post;

		// Check if archived.
		if ( self::POST_STATUS === $post->post_status ) {
			$states[] = '<span class="archived">' . esc_html( $this->l10n_status ) . '</span>';
		}

		return $states;
	}

	/**
	 * Insert Archived Status into Post Status dropdown.
	 *
	 * JS appends this to the Post Status <select>
	 * in the Publish metabox.
	 *
	 * @action post_submitbox_misc_actions
	 *
	 * @param object $post WP Post object.
	 *
	 * @return void
	 */
	public function render_ui( $post ) {
		if ( empty( $post ) || Plugin::CPT_SLUG_SLIDE !== $post->post_type ) {
			return;
		}
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
		?>
		<select style="display: none">
			<option <?php selected( $post->post_status, self::POST_STATUS ); ?> id="archived-status" value="<?php echo esc_attr( strtolower( self::POST_STATUS ) ); ?>">
				<?php echo esc_html( $this->l10n_status ); ?>
			</option>
		</select>
		<?php
	}

	/**
	 * Render the hidden Warning elements.
	 *
	 * @action edit_form_after_title
	 *
	 * @param object $post WP Post object.
	 */
	public function render_warnings( $post ) {
		if ( empty( $post ) || Plugin::CPT_SLUG_SLIDE !== $post->post_type ) {
			return;
		}
		$query = p2p_type( Posts_To_Posts::CONNECTION_NAME )->get_connected( get_queried_object() );
		?>
		<div id="archive-warning" class="slide-warning">
			<p class="no-margin"><strong><?php esc_html_e( 'Ready to Archive?', 'strathcom-carousel' ); ?></strong></p>
			<hr />
			<?php if ( ! empty( $query->posts ) && is_array( $query->posts ) ) : ?>
				<p><?php esc_html_e( 'This slide currently appears in the following Carousels:', 'strathcom-carousel' ); ?></p>
				<ul>
					<?php foreach ( $query->posts as $carousel ) : ?>
						<li>&bull;&nbsp;<?php echo esc_html( $carousel->post_title ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p><?php esc_html_e( 'Archiving this slide will remove it from the above items.', 'strathcom-carousel' ); ?></p>
				<?php else : ?>
				<p><?php esc_html_e( 'Archiving this slide will not affect any Carousels.', 'strathcom-carousel' ); ?></p>
			<?php endif; ?>
			<p><?php esc_html_e( 'This slide will not be deleted.', 'strathcom-carousel' ); ?></p>
			<hr />
			<button id="archive-cancel" class="button button-secondary">
				<span class="dashicons dashicons-no-alt"></span>
				<?php esc_html_e( 'Cancel', 'strathcom-carousel' ); ?>
			</button>
			<button id="archive-proceed" class="button button-primary">
				<span class="dashicons dashicons-yes"></span>
				<?php esc_html_e( 'Proceed with Archiving', 'strathcom-carousel' ); ?>
			</button>
		</div>

		<div id="delete-warning" class="slide-warning">
			<p class="no-margin"><strong><?php esc_html_e( 'Ready to Delete?', 'strathcom-carousel' ); ?></strong></p>
			<hr />
			<?php if ( ! empty( $query->posts ) && is_array( $query->posts ) ) : ?>
				<p><?php esc_html_e( 'This slide currently appears in the following Carousels:', 'strathcom-carousel' ); ?></p>
				<ul>
					<?php foreach ( $query->posts as $carousel ) : ?>
						<li>&bull;&nbsp;<?php echo esc_html( $carousel->post_title ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p><?php esc_html_e( 'Deleting this slide will remove it from the above items.', 'strathcom-carousel' ); ?></p>
			<?php else : ?>
				<p><?php esc_html_e( 'Deleting this slide will not affect any Carousels.', 'strathcom-carousel' ); ?></p>
			<?php endif; ?>
			<p><strong><?php esc_html_e( 'This slide will not be recoverable.', 'strathcom-carousel' ); ?></strong></p>
			<hr />
			<button id="delete-cancel" class="button button-primary">
				<span class="dashicons dashicons-no-alt"></span>
				<?php esc_html_e( 'Cancel', 'strathcom-carousel' ); ?>
			</button>
			<button id="delete-proceed" class="button button-secondary">
				<span class="dashicons dashicons-trash"></span>
				<?php esc_html_e( 'Proceed with Deletion', 'strathcom-carousel' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Remove connections when saved as "Archived".
	 *
	 * @action save_post
	 *
	 * @param int    $post_id The current post ID.
	 * @param object $post WP Post Object.
	 *
	 * @return mixed The Post ID, else bool.
	 */
	public function save_post( $post_id, $post ) {
		if ( ! isset( $_POST[ self::NONCE_NAME ] ) || ! wp_verify_nonce( sanitize_key( $_POST[ self::NONCE_NAME ] ), self::NONCE_ACTION ) ) { // WPCS: Input var okay.
			return $post_id;
		}

		// Skip unintended save points.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			return $post_id;
		}

		// Capability check.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( empty( sanitize_text_field( wp_unslash( $_POST['hidden_post_status'] ) ) ) ) { // WPCS: Input var okay.
			return $post_id;
		}

		if ( self::POST_STATUS === $post->post_status ) {
			// Remove connections to Slides.
			$query = $this->get_connected_slides( $post_id );

			if ( ! empty( $query->posts ) && is_array( $query->posts ) ) {
				foreach ( $query->posts as $slide ) {
					$this->delete_p2p_connection( $slide->p2p_id );
				}
			}

			return true;
		}

		return false;

	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @action admin_enqueue_scripts
	 */
	public function admin_scripts() {
		wp_register_style( self::CSS_HANDLE, $this->plugin->dir_url . 'css/archive.css' );
		wp_enqueue_style( self::CSS_HANDLE );

		wp_register_script(
			self::SCRIPT_HANDLE,
			$this->plugin->dir_url . 'js/archive.js',
			array( 'jquery' )
		);

		$exports = array(
			'postStatus'     => get_post_status(),
			'archivedStatus' => $this->l10n_status,
			'saveTextHidden' => strtolower( self::POST_STATUS ),
			'saveText'       => __( 'Archive', 'strathcom-carousel' ),
		);

		wp_scripts()->add_data(
			self::SCRIPT_HANDLE,
			'data',
			sprintf( 'var _strathcomCarouselArchiveExports = %s;', wp_json_encode( $exports ) )
		);
		wp_add_inline_script( self::SCRIPT_HANDLE, 'strathcomCarouselArchive.init();', 'after' );

		wp_enqueue_script( self::SCRIPT_HANDLE );
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
	 * Delete P2P Connection
	 *
	 * Remove the P2P plugin connection between a slide and carousel.
	 *
	 * @param int $p2p_id The ID of the connection.
	 */
	public function delete_p2p_connection( $p2p_id ) {
		p2p_delete_connection( $p2p_id );
	}
}
