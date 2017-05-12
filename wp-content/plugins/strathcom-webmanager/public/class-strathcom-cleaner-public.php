<?php
/**
 * .
 *
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/public
 * @author     Strathcom <obinna@strathcom.com>
 */

/**
 * .
 *
 * @package    Strathcom_Cleaner
 * @subpackage Strathcom_Cleaner/public
 * @author     Strathcom <obinna@strathcom.com>
 */
class Strathcom_Cleaner_Public {

	/**
	 *
	 * The plugin Identity.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

		/**
		 * The plugin version.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
	private $version;

		/**
		 * Options.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $strat_options     The strathcom options.
		 */
	private $strat_options ;


		/**
		 * Constructor.
		 *
		 * @since    1.0.0
		 * @param string $plugin_name       The name of the plugin.
		 * @param string $version    The version of this plugin.
		 */
	public function __construct( $plugin_name, $version ) {

				$this->plugin_name = $plugin_name;
				$this->version = $version;

				$this->strat_options = get_option( $this->plugin_name );
	}

	/**
	 * Enqueue_styles.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/strathcom-cleaner-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Strat_remove_x_pingback.
	 *
	 * @since    1.0.0
	 * @param string $headers .
	 */
	public function strat_remove_x_pingback( $headers ) {
		if ( ! empty( $this->strat_options['cleanup'] ) ) {
					unset( $headers['X-Pingback'] );
					return $headers;
		}
	}

	/**
	 * Strat_remove_x_pingback.
	 *
	 * @since    1.0.0
	 */
	public function strat_remove_comments_inline_styles() {
		if ( ! empty( $this->strat_options['comments_css_cleanup'] ) ) {
					global $wp_widget_factory;
			if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
							remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
			}

			if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
					remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
			}
		}
	}

	/**
	 * Strat_remove_gallery_styles.
	 *
	 * @since    1.0.0
	 * @param string $css .
	 */
	public function strat_remove_gallery_styles( $css ) {
		if ( ! empty( $this->strat_options['gallery_css_cleanup'] ) ) {
				 return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
		}

	}

	/**
	 * Strat_clear_post_revisions.
	 *
	 * @since    1.0.0
	 */
	public function strat_clear_post_revisions() {
		if ( ! empty( $this->strat_options['post_revisions'] ) ) {
					global $wpdb;
			if ( is_multisite() ) {
				$blogs = get_sites( [ 'public' => 1 ] );
				foreach ( $blogs as $blog ) {
					$id = $blog->blog_id;
					$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_%d_posts WHERE post_type = "revision"', $id ) );
				}
			} else {
				$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_posts WHERE post_type = %s', 'revision' ) );
			}
		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 */
	public function strat_clear_spam_comments() {
		if ( ! empty( $this->strat_options['spam_comments'] ) ) {
					global $wpdb;

			if ( is_multisite() ) {
				$blogs = get_sites( [ 'public' => 1 ] );
				foreach ( $blogs as $blog ) {
					$id = $blog->blog_id;
					$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_%d_comments WHERE comment_approved= "spam"', $id ) );
				}
			} else {
				$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_comments WHERE comment_approved = %s', 'spam' ) );
			}
		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 */
	public function strat_clear_awaiting_moderation() {
		if ( ! empty( $this->strat_options['awaiting_moderation'] ) ) {
			global $wpdb;
			if ( is_multisite() ) {
					$blogs = get_sites( [ 'public' => 1 ] );
				foreach ( $blogs as $blog ) {
						$id = $blog->blog_id;
						$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_%d_comments WHERE comment_approved= 0', $id ) );
				}
			} else {
					$wpdb->query( $wpdb->prepare( 'DELETE FROM wp_comments WHERE comment_approved = %d', 0 ) );
			}
		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 * @param string $classes .
	 */
	public function strat_ob_class_slug( $classes ) {
		if ( ! empty( $this->strat_options['body_class_slug'] ) ) {
				global $post;
			if ( is_singular() ) {
				$classes[] = $post->post_type;
			}
		}
			return $classes;
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 */
	public function strat_cleanup() {
		if ( $this->strat_options['cleanup'] ) {

					remove_action( 'wp_head', 'rsd_link' );                 // RSD link.
					remove_action( 'wp_head', 'feed_links_extra', 3 );            // Category feed link.
					remove_action( 'wp_head', 'feed_links', 2 );                // Post and comment feed links.
					remove_action( 'wp_head', 'index_rel_link' );
					remove_action( 'wp_head', 'wlwmanifest_link' );
					remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );        // Parent rel link.
					remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );       // Start post rel link.
					remove_action( 'wp_head', 'rel_canonical', 10, 0 );
					remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
					remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Adjacent post rel link.
					remove_action( 'wp_head', 'wp_generator' );               // WP Version.
					remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
					remove_action( 'wp_print_styles', 'print_emoji_styles' );
					remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
					remove_action( 'admin_print_styles', 'print_emoji_styles' );
					remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
					remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
					remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 */
	public function dequeue_styles() {
		if ( ! empty( $this->strat_options['remove_unwanted_css'] ) ) {
			// functional port 1.
			// wp_dequeue_style( 'font-awesome' ); // Font Awesome font is already in base. Staff directory was loading another copy.
			// wp_dequeue_style( 'wp-job-manager-frontend' ); // Job manager styles are concatenated inside the main stylesheet already.
		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 * @param string $js_file .
	 */
	public function dequeue_scripts( $js_file ) {
		if ( ! empty( $this->strat_options['remove_unwanted_js'] ) ) {
			// functional port 2.
			// remove_action( 'wp_head', 'remote_login_js_loader' );.
			// wp_dequeue_script($jsFile);.
			// wp_deregister_script($jsFile);.
		}
	}

	/**
	 *  .
	 *
	 * @since    1.0.0
	 * @param string $redirect_url .
	 */
	public function disable_front_page_redirect( $redirect_url ) {
		if ( ! empty( $this->strat_options['remove_unwanted_js'] ) ) {
				$redirect_url = true;
			if ( is_front_page() ) {
					$redirect_url = false;
			}
		}
	}

}
