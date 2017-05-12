<?php
/**
 * Network Admin "Post List" screen.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class GI_List
 *
 * @package StrathcomCarousel
 */
class GI_List {

	/**
	 * The plugin instance
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Class Constructor.
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Initiate this class' resources.
	 */
	public function init() {
		$this->render_page();
	}

	/**
	 * Render the Incentive List Page.
	 */
	public function render_page() {
		$incentives = $this->plugin->gi_utils->get_incentives();
		$admin_url = network_admin_url( 'admin.php?page=' . GI_Utils::ADD_EDIT_SCREEN );
		$this->plugin->gi_utils->reset_expiration();
		?>
		<div id="graphical-incentives-list" class="wrap">
			<h1 style="margin-bottom: 8px;">
				<?php esc_html_e( 'Graphical Incentives', 'strathcom-carousel' ); ?>
				<a href="<?php echo esc_url( $admin_url ); ?>" class="page-title-action">Add New</a>
			</h1>
			<?php $this->maybe_render_deleted_message(); ?>
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<?php $this->render_table_headers(); ?>
					</tr>
				</thead>

				<tbody id="the-list">
				<?php foreach ( $incentives as $incentive ) :
					$data = $this->plugin->gi_utils->validate_post_data( $incentive );
					$link = $admin_url . '&gi_id=' . $data['post_id'];

					$start_date  = $data['start_date'] . ' ' . $data['start_hours'] . ':' . $data['start_mins'];
					$start_date  = empty( $data['start_date'] ) ? '—' : $start_date;
					$end_date    = $data['end_date'] . ' ' . $data['end_hours'] . ':' . $data['end_mins'];
					$end_date    = empty( $data['end_date'] ) ? '—' : $end_date;
					$post_date   = get_the_date( 'm/d/Y H:i', $data['post_id'] );
					?>
					<tr id="post-<?php echo esc_attr( $data['post_id'] ); ?>" class="iedit author-other level-0 post-<?php echo esc_attr( $data['post_id'] ); ?> hentry">
						<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
							<strong>
								<a class="row-title" href="<?php echo esc_url( $link ); ?>" aria-label="<?php echo esc_attr( '“' . $data['title'] . '” (Edit)' ); ?>"><?php echo esc_html( $data['title'] ); ?></a>
							</strong>
							<div class="row-actions">
								<span class="edit"><a href="<?php echo esc_url( $link ); ?>" aria-label="Edit"><?php esc_html_e( 'Edit' ); ?></a> | </span>
								<span class="trash"><a href="#" class="submitdelete" data-id="<?php echo esc_attr( $data['post_id'] ); ?>"><?php esc_html_e( 'Trash' ); ?></a></span>
							</div>
						</td>
						<td class="current-status column-current-status" data-colname="Current Status">
							<?php echo esc_html( $this->render_post_status( $data['post_id'] ) ); ?>
						</td>
						<td class="date column-start-end-date" data-colname="Start/End Date">
							<?php esc_html_e( 'Start:', 'strathcom-carousel' ); ?>&nbsp;<abbr title="<?php echo esc_attr( $start_date ) ?>"><?php echo esc_html( $start_date ) ?></abbr>
							<br /><br />
							<?php esc_html_e( 'End:', 'strathcom-carousel' ); ?>&nbsp;&nbsp;<abbr title="<?php echo esc_attr( $end_date ) ?>"><?php echo esc_html( $end_date ) ?></abbr>
						</td>
						<td class="categories column-carousels" data-colname="Carousels">
							<?php echo esc_html( $this->get_carousel_count( $data['carousels'] ) ); ?>
						</td>
						<td class="image column-image" data-colname="Image">
							<img src="<?php echo esc_url( $this->plugin->gi_utils->get_incentive_img_url( $data['img_id'], 'thumbnail' ) ); ?>" />
						</td>

					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>
					<?php $this->render_table_headers(); ?>
				</tr>
				</tfoot>

			</table>
		</div>
	<?php
	}

	/**
	 * Render the List table headers.
	 */
	public function render_table_headers() {
		?>
		<th scope="col" id="title" class="manage-column column-title column-primary desc"><?php esc_html_e( 'Title' ); ?></th>
		<th scope="col" id="current-status" class="manage-column column-current-status"><?php esc_html_e( 'Current Status' ); ?></th>
		<th scope="col" id="start-date" class="manage-column column-start-end-date"><?php esc_html_e( 'Start/End Date' ); ?></th>
		<th scope="col" id="carousels" class="manage-column column-carousels"><?php esc_html_e( 'Carousels' ); ?></th>
		<th scope="col" id="image" class="manage-column column-image"><?php esc_html_e( 'Image' ); ?></th>

		<?php
	}

	/**
	 * Get the translated Carousel count string.
	 *
	 * @param array $carousels The Incentive's carousels.
	 *
	 * @return string
	 */
	public function get_carousel_count( $carousels = array() ) {
		$carousel_string = __( 'None', 'strathcom-carousel' );
		$count = count( $carousels );
		if ( 0 <= $count ) {
			$carousel_string = sprintf( translate_nooped_plural( _n_noop( '%s Carousel', '%s Carousels' ), $count, 'strathcom-carousel' ), $count );
		}
		return $carousel_string;
	}

	/**
	 * Set Text representing the post status.
	 *
	 * @param string $post_id The Post ID.
	 *
	 * @return string
	 */
	public function render_post_status( $post_id ) {
		if ( $this->is_expired( $post_id ) ) {
			return __( 'Expired', 'strathcom-carousel' );
		} elseif ( $this->is_scheduled( $post_id ) ) {
			return __( 'Scheduled', 'strathcom-carousel' );
		} elseif ( $this->is_published( $post_id ) ) {
			return __( 'Published', 'strathcom-carousel' );
		} else {
			return __( 'Unpublished', 'strathcom-carousel' );
		}
	}

	/**
	 * Check to see if the Incentive is expired.
	 *
	 * @param string $post_id Required.  The post ID.
	 *
	 * @return bool
	 */
	public function is_expired( $post_id ) {
		if ( 'expired' === get_post_status( $post_id ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check to see if the Incentive is expired.
	 *
	 * @param string $post_id Required.  The post ID.
	 *
	 * @return bool
	 */
	public function is_scheduled( $post_id ) {
		if ( 'future' === get_post_status( $post_id ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check to see if the Incentive is published.
	 *
	 * @param string $post_id Required.  The post ID.
	 *
	 * @return bool
	 */
	public function is_published( $post_id ) {
		if ( 'publish' === get_post_status( $post_id ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Render the Deleted message.
	 */
	public function maybe_render_deleted_message() {
		if ( ! empty( $_GET['deleted_id'] ) && intval( wp_unslash( $_GET['deleted_id'] ) ) ) { // WPCS: Input var okay.
			?>
			<div id="message" class="updated notice">
				<p><?php esc_html_e( 'Incentive deleted.', 'strathcom-geographical-incentives' ); ?></p>
			</div>
			<?php
		}
	}
}
