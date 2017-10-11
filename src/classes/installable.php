<?php

/**
 * Installable class.
 *
 * @package WordPoints_WooCommerce
 * @since   1.2.1
 */

/**
 * Installable object for the extension.
 *
 * @since 1.2.1
 */
class WordPoints_WooCommerce_Installable extends WordPoints_Installable_Extension {

	/**
	 * @since 1.2.1
	 */
	public function get_update_routine_factories() {

		$factories = parent::get_update_routine_factories();

		// v1.2.0.
		$factories[] = new WordPoints_Updater_Factory(
			'1.2.0'
			, array(
				'local' => array( 'WordPoints_WooCommerce_Updater_1_2_0_Gateway' ),
			)
		);

		return $factories;
	}

	/**
	 * @since 1.2.1
	 */
	protected function get_uninstall_routine_factories() {

		$factories = parent::get_uninstall_routine_factories();

		$gateway = new WordPoints_WooCommerce_Gateway_Points();

		$factories[] = new WordPoints_Uninstaller_Factory_Options(
			array( $gateway->get_option_key() )
		);

		return $factories;
	}
}

// EOF
