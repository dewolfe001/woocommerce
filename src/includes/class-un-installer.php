<?php

/**
 * Class to un/install the module.
 *
 * @package WordPoints_WooCommrce
 * @since 1.0.2
 */

/**
 * Un/install the module.
 *
 * @since 1.0.2
 */
class WordPoints_WooCommerce_Un_Installer extends WordPoints_Un_Installer_Base {

	/**
	 * @since 1.0.2
	 */
	protected $type = 'module';

	/**
	 * @since 1.0.2
	 */
	protected $uninstall = array(
		'universal' => array(
			'points_hooks' => array(
				'wordpoints_wc_order_complete_points_hook',
			),
		),
	);
}

return 'WordPoints_WooCommerce_Un_Installer';

// EOF