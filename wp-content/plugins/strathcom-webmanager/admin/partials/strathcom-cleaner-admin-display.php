<?php
/**
 *
 * @link       https://github.com/oldmanobi
 * @since      1.0.0
 *
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/admin/partials
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?>

	</h2>
	<h2 class="nav-tab-wrapper">
	  <a href="#front-end" class="nav-tab nav-tab-active">Frontend</a>
	  <a href="#back-end"  class="nav-tab ">Backend</a>
	</h2>
	<form method="post" name="cleanup_options" action="options.php">
	<?php

		$options = get_option( $this->plugin_name );

		// Front end
		$cleanup = ( ! isset( $options['cleanup'] )) ? 0 : $options['cleanup'];
		$comments_css_cleanup = ( ! isset( $options['comments_css_cleanup'] )) ? 0 : $options['comments_css_cleanup'];
		$gallery_css_cleanup = ( ! isset( $options['gallery_css_cleanup'] )) ? 0 : $options['gallery_css_cleanup'];
		$body_class_slug = ( ! isset( $options['body_class_slug'] )) ? 0 : $options['body_class_slug'];
		$remove_unwanted_js = ( ! isset( $options['remove_unwanted_js'] )) ? 0 : $options['remove_unwanted_js'];
		$remove_unwanted_css = ( ! isset( $options['remove_unwanted_css'] )) ? 0 : $options['remove_unwanted_css'];

		// Back end
		$spam_comments = ( ! isset( $options['spam_comments'] )) ? 0 : $options['spam_comments'];
		$awaiting_moderation = ( ! isset( $options['awaiting_moderation'] )) ? 0 : $options['awaiting_moderation'];
		$post_revisions = ( ! isset( $options['post_revisions'] )) ? 0 : $options['post_revisions'];

		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );

		 // Include tab partials
		require_once( 'strathcom-cleaner-admin-display-frontend.php' );
		require_once( 'strathcom-cleaner-admin-display-backend.php' );
	?>

		 <p class="submit">

		<?php submit_button( __( 'Save all changes', $this->plugin_name ), 'primary','submit', true ); ?><br>
		</p>

	</form>


</div>
