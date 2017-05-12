<?php
/**
 * Network Admin Add/Edit screen.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class GI_Add_Edit
 *
 * @package StrathcomCarousel
 */
class GI_Add_Edit {

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
	 * Set up Incentive data.
	 *
	 * @see GI_Utils->admin_menu_page()
	 */
	public function init() {
		$post_id = '';
		if ( ! empty( $_GET['gi_id'] ) ) { // WPCS: Input var okay.
			$post_id_string = intval( wp_unslash( $_GET['gi_id'] ) ); // WPCS: Input var okay.
			if ( is_string( get_post_status( $post_id_string ) ) ) {
				$post_id = $post_id_string;
			}
		}

		// Put this here to ensure our array keys are set, even if the incentive is empty.
		$post_data = $this->plugin->gi_utils->validate_post_data( $post_id );
		$this->render_add_edit_page( $post_id, $post_data );
	}

	/**
	 * Render the Add New / Edit Incentive page.
	 *
	 * @param string $post_id The slide ID.  May be empty.
	 * @param array  $post_data Validated post data.
	 */
	public function render_add_edit_page( $post_id = '', $post_data = array() ) {
		$this->plugin->gi_utils->reset_expiration();
		?>
		
		<div id="graphical-incentives-edit-page" class="wrap">
			<?php if ( ! empty( $post_id ) && is_numeric( $post_id ) ) : ?>
				<h1><?php esc_html_e( 'Edit Graphical Incentive', 'strathcom-carousel' ); ?></h1>
				<?php if ( ! empty( $_GET['updated'] ) ) : // WPCS: Input var okay. ?>
					<div class="notification notice-success">
						<?php esc_html_e( 'Graphical Incentive updated.', 'strathcom-carousel' ); ?>
					</div>
				<?php endif; ?>
				<?php $this->check_img_size( $post_data['img_id'] ); ?>
			<?php else : ?>
				<h1><?php esc_html_e( 'Add New Graphical Incentive', 'strathcom-carousel' ); ?></h1>
			<?php endif; ?>

			<div id="notice-error" class="notification notice-error">
				<?php esc_html_e( 'Errors found. Please check your entries and save again.', 'strathcom-carousel' ); ?>
			</div>

			<form id="poststuff" method="post" action="" enctype="multipart/form-data">
				<div id="graphical-incentives-form">
					<?php $this->render_title_input( $post_id, $post_data['title'] ); ?>
					<div class="postbox-container">
						<div id="slide_settings" class="postbox">
							<h2 class="hndle ui-sortable-handle"><span>Slide Settings</span></h2>
							<div class="inside">
								<?php $this->render_slide_settings( $post_data ); ?>
							</div>
						</div>
					</div>
					<div class="postbox-container">
						<div id="start-end-date" class="postbox">
							<h2 class="hndle ui-sortable-handle"><span><?php esc_html_e( 'Start/End Date', 'strathcom-carousel' ); ?></span></h2>
							<div class="inside">
								<div class="inside">
									<strong><?php echo esc_html__( 'Current Status:', 'strathcom-carousel' ) . '&nbsp;' . esc_html( $this->plugin->gi_list->render_post_status( $post_id ) ); ?></strong>
									<p class="description">
										<?php esc_html_e( 'Current Time: ', 'strathcom-carousel' ); ?><?php echo esc_html( current_time( 'm/d/Y H:i' ) ); ?>
									</p>
									<p><?php $this->render_date_dropdowns( $post_data['start_date'], $post_data['start_hours'], $post_data['start_mins'] ); ?></p>
									<p><?php $this->render_date_dropdowns( $post_data['end_date'], $post_data['end_hours'], $post_data['end_mins'], 'end' ); ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="postbox-container">
						<div id="image-settings" class="postbox">
							<h2 class="hndle ui-sortable-handle"><span><?php esc_html_e( 'Image', 'strathcom-carousel' ); ?></span></h2>
							<div class="inside">
								<?php $this->render_img_input( $post_data['img_id'] ); ?>
							</div>
						</div>
					</div>
					<div class="postbox-container">
						<div id="add-to-carousels" class="postbox">
							<h2 class="hndle ui-sortable-handle"><span><?php esc_html_e( 'Add to Carousels', 'strathcom-carousel' ); ?></span></h2>
							<div class="inside">
								<p class="description">
									<?php esc_html_e( 'Filter sites: ', 'strathcom-carousel' ); ?>
								</p>
							<?php

							/*
							* If there are more than 10,000 sites in the network, this will not work
							* due to the use of wp_is_large_network() inside of wp_get_sites().
							*/
							$all_sites = wp_get_sites();
							if ( ! empty( $all_sites ) && is_array( $all_sites ) ) :
								$this->render_filters();
								?>
								<hr />
								<p class="sites-warning description" style="display:none">
									<?php esc_html_e( 'No sites match the filters selected', 'strathcom-carousel' ); ?>
								</p>
								<?php
								$this->render_carousels( $all_sites, $post_data['carousels'] );
							endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php submit_button( __( 'Save', 'strathcom-carousel' ), 'primary', 'incentives-button' ); ?>
		<div class="clear"></div>
			</form>
		<div class="clear"></div>
		</div>

		<?php
	}

	/**
	 * Render the Title input.
	 *
	 * @param string $post_id The Post ID.
	 * @param string $title The Post title.
	 */
	public function render_title_input( $post_id = '', $title = '' ) {
		$post_id = empty( $post_id ) ? '' : $post_id;
		?>
		<div id="titlediv">
			<div id="titlewrap">
				<label class="screen-reader-text" id="title-prompt-text" for="title"><?php esc_html_e( 'Enter title here', 'strathcom-carousel' ); ?></label>
				<input type="text" name="slide-title" size="30" value="<?php echo esc_attr( $title ); ?>" id="title" spellcheck="true" autocomplete="off" placeholder="<?php esc_html_e( 'Enter title here', 'strathcom-carousel' ); ?>">
			</div>
		<input type="hidden" id="post-id" name="post-id" value="<?php echo esc_attr( $post_id ); ?>" />
		</div>
		<?php
	}

	/**
	 * Render the Slide Settings "Metabox".
	 *
	 * @param array $post_data Post input data.
	 */
	public function render_slide_settings( $post_data = array() ) {
		if ( empty( $post_data ) ) {
			return;
		}
		?>
		<div class="slide_url_manual">
			<p>
				<label for="slide_url"><?php esc_html_e( 'Slide Link URL', 'strathcom-carousel' ); ?></label>
				<input type="text" id="slide-url" title="slide_url" name="slide_url" style="width: 99%;" value="<?php echo esc_url( $post_data['slide_url'] ); ?>" />
			</p>
		</div>
		<p>
			<label for="slide_url_target"><?php esc_html_e( 'Open In', 'strathcom-carousel' ); ?></label><br />
			<select name="slide_url_target" id="slide-target">
				<option value="0" <?php selected( $post_data['slide_url_target'], 0, true ) ?>><?php esc_attr_e( 'Existing Window/Tab', 'strathcom-carousel' ); ?></option>
				<option value="1" <?php selected( $post_data['slide_url_target'], 1, true ) ?>><?php esc_attr_e( 'New Window/Tab', 'strathcom-carousel' ); ?></option>
			</select>
		</p>
		<?php
	}

	/**
	 * Render the Date inputs.
	 *
	 * @param string $date The date string.
	 * @param string $hours The hours.
	 * @param string $mins The minutes.
	 * @param string $string start/end.
	 */
	public function render_date_dropdowns( $date = '', $hours = '00', $mins = '00', $string = 'start' ) {
		?>
		<input type="text" id="<?php echo esc_html( $string ) ?>-date" name="<?php echo esc_html( $string ) ?>-date" value="<?php echo esc_html( $date ); ?>" />
		<select id="<?php echo esc_html( $string ) ?>-time-hours">
			<?php for ( $i = 0; $i <= 23; $i++ ) :
				$value = zeroise( $i, 2 ); ?>
				<option <?php selected( $hours, $value ); ?> value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></option>
			<?php endfor; ?>
		</select>:
		<select id="<?php echo esc_html( $string ) ?>-time-minutes">
			<?php for ( $i = 0; $i <= 55; $i += 5 ) : // Show 5 minute intervals.
				$value = zeroise( $i, 2 ); ?>
				<option <?php selected( $mins, $value ); ?> value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></option>
			<?php endfor; ?>
		</select>
		<?php
	}

	/**
	 * Fetch the Image's URL.
	 *
	 * @param string $img_id The Image ID.
	 *
	 * @return bool|string
	 */
	public function get_img_url( $img_id ) {
		$img_array = wp_get_attachment_image_src( $img_id, 'full' );

		// Rename for clarity.
		return empty( $img_array[0] ) ? false : $img_array[0];
	}

	/**
	 * Check the Image's dimensions.
	 *
	 * If the image is too small, show an error message.
	 *
	 * @param string $img_id The Image ID.
	 *
	 * @return bool
	 */
	public function check_img_size( $img_id ) {
		if ( empty( $img_id ) ) {
			return false;
		}

		$img_url = $this->get_img_url( $img_id );
		?>
		<div class="slide-size-warning <?php if ( $this->plugin->slide_admin->check_image_size( $img_url ) ) { echo 'hidden'; } ?>">
			<p><?php printf( esc_html__( 'Warning! The image is smaller than the minimum size of %dx%d pixels and will not be displayed.', 'strathcom-carousel' ), intval( Slide_Admin::SLIDE_MINIMUM_WIDTH ), intval( Slide_Admin::SLIDE_MINIMUM_HEIGHT ) ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render the Image input.
	 *
	 * @param string $img_id The image id.
	 */
	public function render_img_input( $img_id = '' ) {
		$img_url = $this->get_img_url( $img_id );
		$this->check_img_size( $img_id );
		?>
		<div id="incentives-preview-image">
			<?php if ( ! empty( $img_url ) ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" />
			<?php endif; ?>
		</div>

		<p class="hide-if-no-js">
			<button id="incentives-add-image-button" class="upload-incentive-img button button-secondary <?php if ( ! empty( $img_url ) ) { echo 'hidden'; } ?>">
				<?php esc_html_e( 'Choose or Upload an Image', 'strathcom-carousel' ); ?>
			</button>
			<button id="incentives-delete-image-button" class="delete-incentive-img button button-secondary <?php if ( empty( $img_url ) ) { echo 'hidden'; } ?>">
				<span class="dashicons dashicons-no-alt"></span><?php esc_html_e( 'Remove Image', 'strathcom-carousel' ); ?>
			</button>
		</p>

		<input type="hidden" id="slide-attachment-id" name="slide-attachment-id" value="<?php echo intval( $img_id ); ?>" />

		<?php
	}

	/**
	 * Render the Carousel filters selects.
	 */
	public function render_filters() {
		?>
		<div id="filters" class="filters">
			<div class="filter">
				<select id="filter-oem" name="oem">
					<option value="any"><?php esc_html_e( 'All OEMs', 'strathcom-carousel' ); ?></option>
					<?php echo wp_kses( \StrathcomOems\Oems::option_list(), array( 'option' => array( 'value' => true ) ) ); ?>
				</select>
				<select id="filter-country" name="country">
					<option value="any"><?php esc_html_e( 'All Countries', 'strathcom-carousel' ); ?></option>
					<option value="canada"><?php esc_html_e( 'Canada', 'strathcom-carousel' ); ?></option>
					<option value="usa"><?php esc_html_e( 'United States', 'strathcom-carousel' ); ?></option>
				</select>
				<select id="filter-province" name="province" style="display: none">
					<option value="any"><?php esc_html_e( 'All Provinces', 'strathcom-carousel' ); ?></option>
					<?php echo wp_kses( \StrathcomProvinces\Provinces::option_list(), array( 'option' => array( 'value' => true ) ) ); ?>
				</select>
			</div>
			&nbsp;<button id="filter-sites" class="button button-secondary"><?php esc_html_e( 'Filter', 'strathcom-carousel' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Render the Carousels checkboxes.
	 *
	 * @param array $all_sites All sites in the network.
	 * @param array $carousel_data Array of carousel values.
	 */
	public function render_carousels( $all_sites = array(), $carousel_data = array() ) {
		foreach ( $all_sites as $site ) :
			switch_to_blog( $site['blog_id'] );

			$api = new \StrathcomAPI\Plugin();

			if ( $api->init( $site['blog_id'] ) ) :
				$blog_details   = get_blog_details( $site['blog_id'] );
				$carousels      = $this->plugin->gi_utils->get_carousels_from_network();
				$dealer_details = $api->dealerships->get_dealerships_for_current_site();

				if ( ! empty( $carousels ) && ! empty( $dealer_details ) && is_array( $carousels ) ) :
					// Setup data elements.
					$oems      = array();
					$provinces = array();
					$countries = array();

					foreach ( $dealer_details as $dealer ) {
						$lines       = $dealer->getOem();
						$lines       = isset( $lines['lines'] ) ? $lines['lines'] : array();
						$oems        = array_merge( $oems, $lines );
						$province    = $dealer->getProvince();
						$provinces[] = $province['name'];
						$countries[] = $dealer->getCountry();
					}

					$oems      = ( count( $oems ) > 0 ) ? implode( ',', array_unique( $oems ) ) : '';
					$provinces = ( count( $provinces ) > 0 ) ? implode( ',', array_unique( $provinces ) ) : '';
					$countries = ( count( $countries ) > 0 ) ? implode( ',', array_unique( $countries ) ) : '';
				?>
				<div class="site-select" data-oems="<?php echo esc_attr( $oems ); ?>" data-province="<?php echo esc_attr( $provinces ); ?>" data-country="<?php echo esc_attr( $countries ); ?>">
					<strong><?php echo esc_html( $blog_details->blogname ); ?></strong>
					<ul>
						<?php foreach ( $carousels as $carousel ) :
							if ( empty( $carousel->ID ) ) {
								continue;
							}
							$value = $site['blog_id'] . '|' . $carousel->ID;
							$checked = checked( in_array( $value, $carousel_data, true ), true, false );
							$aspect = get_post_meta( $carousel->ID, Carousel::POST_META_ASPECT_RATIO, true );
							?>
							<li>
								<input type="checkbox" class="selected-carousel" name="selected-carousels[]" <?php echo esc_html( $checked ); ?> value="<?php echo esc_attr( $value ); ?>" />
								<?php echo esc_html( $carousel->post_title ); ?>
								<?php
								if ( $aspect ) {
									echo esc_html( ' (' . str_replace( 'x', ':', $aspect ) . ')' );
								}
								?>
							</li>
						<?php endforeach; // Foreach carousels. ?>
					</ul>
				</div>
			<?php
				endif; // If carousels.
			endif; // If api.

			restore_current_blog();
		endforeach; // Foreach site.
	}
}
