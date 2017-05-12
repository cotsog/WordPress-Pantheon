<?php
/**
 * .
 *
 * @link  https://github.com/oldmanobi
 * @since 1.0.0
 *
 * @package Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/admin/partials
 */

?>

<div id="back-end" class="wrap metabox-holder columns-2 ob_sc-metaboxes hidden">

	<h2>Back End</h2>

		<fieldset>
			<legend class="screen-reader-text"><span>Remove post revisions</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-post_revisions">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-post_revisions" name="<?php echo $this->plugin_name; ?>[post_revisions]" value="1" <?php checked( $post_revisions, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove post revisions', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span>Remove spam comments</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-spam_comments">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-spam_comments" name="<?php echo $this->plugin_name; ?>[spam_comments]" value="1"<?php checked( $spam_comments, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove spam comments', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span>Remove comments awaiting moderation</span></legend>
			<label for="<?php echo $this->plugin_name; ?>-awaiting_moderation">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>-awaiting_moderation" name="<?php echo $this->plugin_name; ?>[awaiting_moderation]" value="1"<?php checked( $awaiting_moderation, 1 ); ?> />
				<span><?php esc_attr_e( 'Remove comments awaiting moderation', $this->plugin_name ); ?></span>
			</label>
		</fieldset>

</div>
