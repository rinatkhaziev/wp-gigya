<?php
/**
 *
 * Test Suite for Frontend Uploader
 *
 * @since 0.5
 *
 */
class WP_Gigya_UnitTestCase extends WP_UnitTestCase {
	public $wpg;

	/**
	 * Init
	 * @return [type] [description]
	 */
	function setup() {
		parent::setup();
		global $wp_gigya;
		$this->wpg = $wp_gigya;
	}

	function teardown() {
	}

	// Check if settings get set up on activation
	function test_default_settings() {
		$this->assertNotEmpty( $this->wpg->settings );
	}

}