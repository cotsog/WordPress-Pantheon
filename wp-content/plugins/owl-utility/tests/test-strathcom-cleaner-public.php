<?php
/**
 * Class Strathcom_Cleaner_Public_Test
 *
 * @package Strathcom_Cleaner
 */

/**
 *
 */
class Strathcom_Cleaner_Public_Test extends WP_UnitTestCase {

	/**
	 *
	 */

	 public function __construct( $plugin_name, $version ) {

			 $this->plugin_name = $plugin_name;
			 $this->version = $version;

			 $this->strat_options = get_option($this->plugin_name);
	 }


	public function test_sample() {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$class = new Strathcom_Cleaner_Public($this->plugin_name, $this->version);

		 $this->assertTrue( $class );
	}


	public function test_enqueue_styles() {

	}

    public function test_strat_cleanup() {

    }

    public function test_strat_remove_x_pingback() {

    }

    public function test_strat_remove_comments_inline_styles() {

    }

    public function test_strat_remove_gallery_styles() {

    }

    public function test_strat_ob_class_slug() {
    	$class = new Strathcom_Cleaner_Public();
		$class->strat_ob_class_slug();

		$this->assertTrue( true );

    }

	public function test_dequeue_styles() {

	}

	public function test_dequeue_scripts() {

	}


}
