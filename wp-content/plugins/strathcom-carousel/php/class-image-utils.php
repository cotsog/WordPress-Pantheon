<?php
/**
 * Generate Slide images with correct aspect ratios.
 *
 * @author  XWP
 * @package StrathcomCarousel
 */

namespace StrathcomCarousel;

/**
 * Class Image_Utils
 *
 * @package StrathcomCarousel
 */
class Image_Utils {
	/**
	 * Slide Max Width.
	 *
	 * Slide min width is Slide_Admin::SLIDE_MINIMUM_WIDTH.
	 */
	const SLIDE_MAX_WIDTH = 2000;

	/**
	 * Slide image aspect ratio post meta field.
	 */
	const POST_META_SLIDE_ASPECT_RATIOS = 'strathcom_slide_aspect_ratios';

	/**
	 * 4:3 Resolution string.
	 */
	const FOUR_THREE = '4x3';

	/**
	 * 16:9 Resolution string.
	 */
	const SIXTEEN_NINE = '16x9';

	/**
	 * 21:9 Resolution string.
	 */
	const TWENTY_ONE_NINE = '21x9';

	/**
	 * 68:7 Resolution string.
	 */
	const SIXTY_EIGHT_SEVEN = '68x7';

	/**
	 * Holds our aspect ratio name strings.
	 *
	 * @var array
	 */
	public $aspect_ratios = array();

	/**
	 * Holds our Post Meta data.
	 *
	 * @var array
	 */
	public $post_meta = array();

	/**
	 * The Post ID of the slide we are working with.
	 *
	 * @var string
	 */
	public $slide_id;

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin.
	 */
	public $plugin;

	/**
	 * Class constructor.
	 *
	 * @param object $plugin The plugin instance.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->aspect_ratios = array(
			self::FOUR_THREE,
			self::SIXTEEN_NINE,
			self::TWENTY_ONE_NINE,
			self::SIXTY_EIGHT_SEVEN,
		);
	}

	/**
	 * Fetch the slide image according to a requested aspect ratio.
	 *
	 * Used to quickly fetch one of our custom-generated images.
	 *
	 * The possible aspect ratios are defined in $this->aspect_ratios.
	 *
	 * @param string $id Slide ID.
	 * @param string $aspect_ratio The requested aspect ratio.
	 *
	 * @return bool|mixed Image URL, else false.
	 */
	public function get_slide_attachment_src_by_aspect_ratio( $id, $aspect_ratio ) {
		if ( empty( $id ) || empty( $aspect_ratio ) || ! in_array( $aspect_ratio, $this->aspect_ratios, true ) ) {
			return false;
		}

		$urls_array = $this->image_urls_post_meta( $id );
		if ( ! empty( $urls_array[ $aspect_ratio ] ) && is_array( $urls_array[ $aspect_ratio ] ) ) {
			return $urls_array[ $aspect_ratio ];
		}
		return false;
	}

	/**
	 * Save all aspect ratios as images based on slide ID.
	 *
	 * @param string $id Slide ID.
	 *
	 * @return bool Success, or not.
	 */
	public function save_img_aspect_ratios( $id ) {
		// Set the post meta property for future use.
		$this->slide_id = $id;
		// Not used in this method, but it sets the property for the rest of the process.
		$this->post_meta = $this->image_urls_post_meta();

		if ( ! empty( $this->slide_id ) && is_numeric( $this->slide_id ) ) {

			// Create the images.
			$new_post_meta = $this->generate_images();

			if ( ! empty( $new_post_meta ) ) {
				$updated = update_post_meta( $this->slide_id, self::POST_META_SLIDE_ASPECT_RATIOS, $new_post_meta );

				if ( false !== $updated ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Generate new images and URLs.
	 *
	 * Updates our post meta property as appropriate.
	 *
	 * @return array
	 */
	public function generate_images() {
		$output = array();
		foreach ( $this->aspect_ratios as $aspect_ratio ) {
			$output[ $aspect_ratio ] = $this->generate_image( $aspect_ratio );
		}
		return $output;
	}

	/**
	 * Create a custom image file of a specific resolution.
	 *
	 * Determines best way to resize the image, based on
	 * the Max width/height settings, as well as ensures
	 * the new image meets the Min width/height settings.
	 *
	 * Return array is set in the basic format of wp_get_attachment_img_src().
	 *
	 * @param string $aspect_ratio The requested aspect ratio.
	 * @param string $slide_id The ID of the slide we're working with.
	 *
	 * @return bool|array Array of new image data, else false.
	 */
	public function generate_image( $aspect_ratio, $slide_id = '' ) {
		if ( empty( $aspect_ratio ) || ! in_array( $aspect_ratio, $this->aspect_ratios, true ) ) {
			return false;
		}

		if ( empty( $slide_id ) || ! is_numeric( $slide_id ) ) {
			$slide_id = $this->slide_id;
		}

		$org_img_id = get_post_thumbnail_id( $slide_id );
		$new_dimensions = $this->calculate_aspect_ratio_dimensions( $aspect_ratio, $org_img_id );

		if ( empty( $new_dimensions ) ) {
			return false;
		}

		// Generate a new image.
		$new_image_data = $this->create_new_image( $org_img_id , $new_dimensions, $aspect_ratio );

		return $new_image_data;
	}

	/**
	 * Calculate the image dimensions based on an aspect ratio string.
	 *
	 * @param string $aspect_ratio The requested aspect ratio label.
	 * @param string $img_id The attachment img ID.
	 *
	 * @return array|bool  Array of width/height, else false.
	 */
	public function calculate_aspect_ratio_dimensions( $aspect_ratio, $img_id ) {
		if ( empty( $aspect_ratio ) || ! is_numeric( $img_id ) ) {
			return false;
		}

		// Fallback aspect ratios.
		$multiplier = ( 9 / 16 );
		$inverse_multiplier = ( 16 / 9 );

		$min_width = Slide_Admin::SLIDE_MINIMUM_WIDTH;
		$max_width = self::SLIDE_MAX_WIDTH;

		$min_height = Slide_Admin::SLIDE_MINIMUM_HEIGHT;

		// Get the image metadata.
		$image_data = wp_get_attachment_metadata( $img_id );

		if ( empty( $image_data['width'] ) || empty( $image_data['height'] ) ) {
			return false;
		}

		// Use the original image width as a base value for the new image.
		$new_width = $image_data['width'];

		/*
		 * Ensure we don't exceed max/min image width.
		 *
		 * First, if the image exceeds the maximum width,
		 * use the max width value.
		 *
		 * Then, if the image width is less than the min width
		 * use the min width value.
		 */
		if ( $max_width < $new_width ) {
			$new_width = $max_width;
		} elseif ( $min_width > $new_width ) {
			$new_width = $min_width;
		}

		/*
		 * Define the multipliers we'll use based on the aspect ratio.
		 *
		 * Technically, the correct term is "multiplicand," but nobody
		 * knows what that word means.
		 */
		if ( self::FOUR_THREE === $aspect_ratio ) {
			// Equals 0.75.
			$multiplier = ( 3 / 4 );
			$inverse_multiplier = ( 4 / 3 );
		}

		if ( self::SIXTEEN_NINE === $aspect_ratio ) {
			$multiplier = ( 9 / 16 );
			$inverse_multiplier = ( 16 / 9 );
		}

		if ( self::TWENTY_ONE_NINE === $aspect_ratio ) {
			$multiplier = ( 9 / 21 );
			$inverse_multiplier = ( 21 / 9 );
		}

		if ( self::SIXTY_EIGHT_SEVEN === $aspect_ratio ) {
			$multiplier = ( 7 / 68 );
			$inverse_multiplier = ( 68 / 7 );
		}

		/*
		 * Calculate the final image height we require.
		 */
		$new_height = $new_width * $multiplier;

		/*
		 * If the min height is now too short for the aspect ratio,
		 * enlarge the height so that the new image will expand to fill
		 * the minimum size.
		 *
		 * Get the height.  Calculate the new width, using a similar
		 * process as above.  Now, DON'T crop Vertically, and blow up the image.
		 *
		 * CSS Should handle the expansion.
		 */

		if ( $new_height > $image_data['height'] ) {
			$new_height = $image_data['height'];
			$new_width = $new_height * $inverse_multiplier;
		}

		return array(
			'width'  => $new_width,
			'height' => intval( $new_height ),
		);
	}

	/**
	 * Generate the new image resized/cropped to the correct aspect ratio.
	 *
	 * Uses the original featured image and \WP_Image_Editor to create a new image.
	 *
	 * Return array is set in the basic format of wp_get_attachment_img_src().
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_image_editor/
	 *
	 * @param string $org_img_id The Slide's featured image ID.
	 * @param array  $new_dimensions  Array of width/height dimensions for the new image.
	 * @param string $aspect_ratio The requested aspect ratio label.
	 *
	 * @return array|bool Array of image data, else false.
	 */
	public function create_new_image( $org_img_id, $new_dimensions, $aspect_ratio ) {
		$org_img_full_path = get_attached_file( $org_img_id );

		// Generate the new image's name.
		$org_img_basename    = basename( $org_img_full_path );
		$org_img_name_data   = explode( '.', $org_img_basename );
		$org_img_file_name   = $org_img_name_data[0];
		$org_img_file_suffix = $org_img_name_data[1];
		$new_file_name       = $org_img_file_name . '-' . $aspect_ratio . '.' . $org_img_file_suffix;
		$path                = pathinfo( $org_img_full_path );

		/*
		 * Fire up a new \WP_Image_Editor instance and
		 * generate the new image.
		 */
		$editor = wp_get_image_editor( $org_img_full_path );
		if ( is_wp_error( $editor ) ) {
			return false;
		}

		// Resize and crop.
		$editor->resize( $new_dimensions['width'], $new_dimensions['height'], true );

		// Save the new image (to the same directory as the original image).
		$new_img_info = $editor->save( trailingslashit( $path['dirname'] ) . $new_file_name );

		/*
		 * Prepare to send the return value.
		 */

		// Construct the new image's url.
		$org_img_url_src = wp_get_attachment_image_src( $org_img_id );
		$repl_basename   = basename( $org_img_url_src[0] );
		$new_img_url     = str_replace( $repl_basename, $new_file_name, $org_img_url_src[0] );

		// Construct image data array to return.
		$new_image_data = array(
			$new_img_url,
			$new_img_info['width'],
			$new_img_info['height'],
		);
		return $new_image_data;
	}

	/**
	 * Get the array of image URLs saved in the Slide Postmeta.
	 *
	 * @param string $id Slide ID.
	 *
	 * @return array
	 */
	public function image_urls_post_meta( $id = '' ) {
		if ( empty( $id ) || ! is_numeric( $id ) ) {
			$id = $this->slide_id;
		}

		$image_url_array = array();
		if ( ! empty( $id ) && is_numeric( $id ) ) {
			if ( ! empty( get_post_meta( $id, self::POST_META_SLIDE_ASPECT_RATIOS, 'true' ) ) ) {
				$image_url_array = get_post_meta( $id, self::POST_META_SLIDE_ASPECT_RATIOS, 'true' );
			}
		}

		return $image_url_array;
	}

	/**
	 * Determine if a string is a URL or not.
	 *
	 * @param string $string Input string.
	 *
	 * @return mixed URL string, else false.
	 */
	public function is_url( $string ) {
		if ( false !== filter_var( $string, FILTER_VALIDATE_URL ) ) {
				return true;
		}
		return false;
	}
}
