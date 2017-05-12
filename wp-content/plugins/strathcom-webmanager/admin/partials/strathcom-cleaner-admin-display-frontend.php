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

	<div id="front-end" class="wrap metabox-holder columns-2 ob_sc-metaboxes">

	<h2>Front End</h2>


		<fieldset>
			<legend class="screen-reader-text"><span>Remove Injected CSS for galleries</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-gallery_css_cleanup">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-gallery_css_cleanup" name="<?php echo $this->plugin_name; ?>[gallery_css_cleanup]" value="1" <?php checked( $gallery_css_cleanup, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove Injected CSS for galleries', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span>Clean WordPress header section</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-cleanup">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-cleanup" name="<?php echo $this->plugin_name; ?>[cleanup]" value="1"<?php checked( $cleanup, 1 ); ?> />
				<span><?php esc_attr_e( 'Clean WordPress header section', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span>Remove Injected CSS for comment widget</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-comments_css_cleanup">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-comments_css_cleanup" name="<?php echo $this->plugin_name; ?>[comments_css_cleanup]" value="1" <?php checked( $comments_css_cleanup, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove Injected CSS for comment widget', $this->plugin_name ); ?></span>
			</label>
		</fieldset>


		<fieldset>
			<legend class="screen-reader-text"><span><?php _e( 'Remove unwanted js files', $this->plugin_name ); ?></span></legend>
			<label for="<?php echo $this->plugin_name; ?>-remove_unwanted_js">
				<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_unwanted_js" name="<?php echo $this->plugin_name; ?>[remove_unwanted_js]" value="1" <?php checked( $remove_unwanted_js, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove unwanted js files', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span><?php _e( 'Remove unwanted CSS files', $this->plugin_name ); ?></span></legend>
			<label for="<?php echo $this->plugin_name; ?>-remove_unwanted_css">
				<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_unwanted_css" name="<?php echo $this->plugin_name; ?>[remove_unwanted_css]" value="1" <?php checked( $remove_unwanted_css, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove unwanted CSS files', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

</div>
