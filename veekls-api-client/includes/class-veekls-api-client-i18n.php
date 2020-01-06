<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/veekls/veekls-api-client-wp/
 * @since      1.0.0
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/includes
 * @author     Santiago G. Marin <santiago.marin@veekls.com>
 */
class Veekls_API_Client_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'veekls-api-client',
			false,
			dirname(
				dirname( plugin_basename( __FILE__ ) )
			) . '/languages/'
		);

	}

}
