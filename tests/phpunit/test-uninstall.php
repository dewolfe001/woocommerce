<?php

/**
 * A test case for uninstalling the module.
 *
 * @package WordPoints_WooCommerce\Tests
 * @since 1.0.0
 */

/**
 * Test that the module uninstalls itself properly.
 *
 * @since 1.0.0
 */
class WordPoints_WooCommerce_Uninstall_Test
	extends WordPoints_Dev_Lib_PHPUnit_TestCase_Module_Uninstall {

	/**
	 * Test installation and uninstallation.
	 *
	 * @since 1.0.0
	 */
	public function test_uninstall() {

		global $wpdb;

		/*
		 * Install.
		 */

		// Check the the basic module data option was added.
		if ( $this->network_wide ) {
			$wordpoints_data = get_site_option( 'wordpoints_data' );
		} else {
			$wordpoints_data = get_option( 'wordpoints_data' );
		}

		$this->assertArrayHasKey( 'woocommerce', $wordpoints_data['modules'] );
		$this->assertInternalType( 'array', $wordpoints_data['modules']['woocommerce'] );
		$this->assertArrayHasKey( 'version', $wordpoints_data['modules']['woocommerce'] );

		/*
		 * Uninstall.
		 */

		$this->uninstall();

		$this->assertNoUserMetaWithPrefix( 'wordpoints_woocommerce' );

		if ( is_multisite() ) {

			$blog_ids = get_sites( array( 'fields' => 'ids', 'number' => 0 ) );

			$original_blog_id = get_current_blog_id();

			foreach ( $blog_ids as $blog_id ) {

				switch_to_blog( $blog_id );

				$this->assertNoUserOptionsWithPrefix( 'wordpoints_woocommerce' );
				$this->assertNoOptionsWithPrefix( 'wordpoints_woocommerce' );
				$this->assertNoOptionsWithPrefix( 'wordpoints_hook-wordpoints_wc' );
				$this->assertNoOptionsWithPrefix( 'widget_wordpoints_woocommerce' );
				$this->assertNoCommentMetaWithPrefix( 'wordpoints_woocommerce' );
			}

			switch_to_blog( $original_blog_id );

			// See https://wordpress.stackexchange.com/a/89114/27757
			unset( $GLOBALS['_wp_switched_stack'] );
			$GLOBALS['switched'] = false;

		} else {

			$this->assertNoOptionsWithPrefix( 'wordpoints_woocommerce' );
			$this->assertNoOptionsWithPrefix( 'wordpoints_hook-wordpoints_wc' );
			$this->assertNoOptionsWithPrefix( 'widget_wordpoints_woocommerce' );
			$this->assertNoCommentMetaWithPrefix( 'wordpoints_woocommerce' );
		}

	} // function test_uninstall()
}

// EOF