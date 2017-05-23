<?php
/**
 * Unit Tests for Functions.php.
 *
 * @author XWP
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * Tests for Functions.php.
 */
class Test_Functions extends WP_UnitTestCase {

	/**
	 * Test Phone Formatting.
	 *
	 * Tests phone number formats to ensure the
	 * function responds properly, as either
	 * a string starting with with "tel:+",
	 * else an empty string.
	 */
	function test_format_phone_as_url() {
		$good_numbers = array(
			'1234567890',
			'8254849987',
			937627546,
			'123-456-7890',
		);

		foreach ( $good_numbers as $good_number ) {
			$result = format_phone_as_url( $good_number );
			$this->assertStringStartsWith( 'tel:+', $result );
		}

		$bad_numbers = array(
			'abcdefghi#$%',
			'987-09a-9256',
			'832a937392',
		);

		foreach ( $bad_numbers as $bad_number ) {
			$result = format_phone_as_url( $bad_number );
			$this->assertEquals( '', $result );
		}
	}
}
