<?php
/**
 * Social twig related PHP.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * StrathcomSocialWidget defines the widget
 * form and connects the data with the twig
 * template.
 */
class StrathcomSocialWidget extends WP_Widget {

	/**
	 * Function __construct
	 *
	 * Initialises the widget.
	 */
	function __construct() {
		parent::__construct(
			'strathcom_social_widget',
			__( 'Strathcom Social Widget', 'strathcom' ),
			array(
				'description' => __( 'Social Icons', 'strathcom' ),
			)
		);
	}

	/**
	 * Function widget
	 *
	 * Renders the html.
	 *
	 * @param array $args The post arguments.
	 * @param array $instance The variable values.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; // WPCS: xss okay.
		Timber::render( 'templates/widgets/social.twig', $instance );
		echo $args['after_widget']; // WPCS: xss okay.
	}

	/**
	 * Function form
	 *
	 * Renders the html form in the admin.
	 *
	 * @param array $instance The variable values.
	 */
	public function form( $instance ) {
		$default_settings = array(
			'contact'           => '',
			'social_googleplus' => '',
			'social_instagram'  => '',
			'social_facebook'   => '',
			'social_twitter'    => '',
			'social_youtube'    => '',
		);
		$instance = wp_parse_args(
			(array) $instance,
			$default_settings
		);
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'contact' ) ); ?>"><?php echo esc_html_e( 'Contact URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'contact' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'contact' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['contact'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_googleplus' ) ); ?>"><?php echo esc_html_e( 'Google+ URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_googleplus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_googleplus' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['social_googleplus'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_instagram' ) ); ?>"><?php echo esc_html_e( 'Instagram URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['social_instagram'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_facebook' ) ); ?>"><?php echo esc_html_e( 'Facebook URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['social_facebook'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_twitter' ) ); ?>"><?php echo esc_html_e( 'Twitter URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['social_twitter'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_youtube' ) ); ?>"><?php echo esc_html_e( 'Youtube URL:', 'strathcom' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['social_youtube'] ); ?>" />
		</p>
	<?php
	}


	/**
	 * Function update
	 *
	 * Updating widget replacing old instances with new
	 *
	 * @param array $new_instance The new variable values.
	 * @param array $old_instance The old variable values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['contact'] = ( ! empty( $new_instance['contact'] ) ) ? wp_kses_post( $new_instance['contact'] ) : '';
		$instance['social_googleplus'] = ( ! empty( $new_instance['social_googleplus'] ) ) ? wp_kses_post( $new_instance['social_googleplus'] ) : '';
		$instance['social_instagram'] = ( ! empty( $new_instance['social_instagram'] ) ) ? wp_kses_post( $new_instance['social_instagram'] ) : '';
		$instance['social_facebook'] = ( ! empty( $new_instance['social_facebook'] ) ) ? wp_kses_post( $new_instance['social_facebook'] ) : '';
		$instance['social_twitter'] = ( ! empty( $new_instance['social_twitter'] ) ) ? wp_kses_post( $new_instance['social_twitter'] ) : '';
		$instance['social_youtube'] = ( ! empty( $new_instance['social_youtube'] ) ) ? wp_kses_post( $new_instance['social_youtube'] ) : '';
		return $instance;
	}
}

register_widget( 'StrathcomSocialWidget' );
