<?php
/**
 * Creates the Carousel widget.
 *
 * @author  XWP
 *
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Carousel_Widget
 *
 * @package StrathcomCarousel
 */
class Carousel_Widget extends \WP_Widget {
	/**
	 * The Plugin instance.
	 *
	 * @var Plugin.
	 */
	public $plugin;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$this->plugin = \StrathcomCarousel\get_plugin_instance();

		$widget_ops = array(
			'classname'     => 'carousel_widget',
			'description'   => __( 'Add a carousel', 'strathcom-carousel' ),
		);

		parent::__construct( 'carousel_widget', 'Carousel', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		if ( empty( $instance['carousel_id'] ) ) {
			return;
		}

		echo do_shortcode( '[' . \StrathcomCarousel\Shortcode::CAROUSEL_SHORTCODE . ' id=' . $instance['carousel_id'] . ']' );
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$chosen_id = ! empty( $instance['carousel_id'] ) ? $instance['carousel_id'] : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'carousel_id' ) ); ?>"><?php esc_html_e( 'Select Carousel:', 'strathcom-carousel' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'carousel_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'carousel_id' ) ); ?>">
				<?php
				$options    = array();
				$carousels  = $this->plugin->carousel->get_carousels();

				if ( count( $carousels ) > 0 ) {
					$options[0] = esc_html__( 'Select a Carousel', 'strathcom-carousel' );

					foreach ( $carousels as $carousel ) {
						$options[ $carousel['ID'] ] = $carousel['title'];
					}
				} else {
					$options[0] = esc_html__( 'Please create a Carousel first', 'strathcom-carousel' );
				}

				foreach ( $options as $carousel_id => $carousel_name ) :
				?>
					<option value="<?php echo esc_attr( $carousel_id ); ?>" <?php selected( $chosen_id, $carousel_id, true ); ?>><?php echo esc_attr( $carousel_name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['carousel_id'] = ( ! empty( $new_instance['carousel_id'] ) ) ? intval( $new_instance['carousel_id'] ) : 0;
		return $instance;
	}
}
