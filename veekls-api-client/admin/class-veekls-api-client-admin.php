<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/veekls/veekls-api-client-wp/
 * @since      1.0.0
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/admin
 * @author     Santiago G. Marin <santiago.marin@veekls.com>
 */
class Veekls_API_Client_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings group name.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $settings_page_slug The settings group name.
	 */
	private $settings_group = 'veekls_api_client_settings_group';

	/**
	 * The settings page slug.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $settings_page_slug The settings page slug.
	 */
	private $settings_page_slug = 'veekls_api_client_settings';

	/**
	 * The settings API Key section slug.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string $settings_page_slug The settings API Key section slug.
	 */
	private $settings_api_key_section_slug = 'veekls_api_client_key_settings_section';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Adds the settings link on the plugins list.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $links The links list.
	 *
	 * @return  array The updated links list.
	 */
	public function add_settings_link( $links ) {
		$href = admin_url( '/options-general.php' );

		$links = array_merge(
			array(
				include_once 'partials/veekls-api-client-admin-settings-link.php',
			),
			$links
		);

		return $links;
	}

	/**
	 * Registers the WordPress admin menu option.
	 *
	 * @since   1.0.0
	 */
	public function setup_settings_page() {

		add_menu_page(
			esc_html__( 'Veekls API Client Settings', 'veekls-api-client' ),
			esc_html__( 'Veekls API', 'veekls-api-client' ),
			'manage_options',
			$this->settings_page_slug,
			array( $this, 'setup_settings_page_content' ),
			'data:image/svg+xml;base64,' .
				base64_encode( // phpcs:ignore
					file_get_contents(
						plugin_dir_path( __DIR__ ) .
						'admin/images/veekls-api-client-admin-icon.svg'
					)
				),
			100
		);

	}

	/**
	 * Setups the settings sections.
	 *
	 * @since   1.0.0
	 */
	public function setup_settings_sections() {

		add_settings_section(
			$this->settings_api_key_section_slug,
			esc_html__( 'Veekls API Key Configuration', 'veekls-api-client' ),
			array( $this, 'api_key_section_text' ),
			$this->settings_page_slug
		);

	}

	/**
	 * Sets up settings fields.
	 *
	 * @since   1.0.0
	 */
	public function setup_settings_fields() {

		add_settings_field(
			'veekls_api_client_key',
			esc_html__( 'API Key', 'veekls-api-client' ),
			array( $this, 'setup_settings_api_key_field' ),
			$this->settings_page_slug,
			$this->settings_api_key_section_slug
		);

		register_setting( $this->settings_group, 'veekls_api_client_key' );

	}

	/**
	 * Generates the settings page HTML.
	 *
	 * @since   1.0.0
	 */
	public function setup_settings_page_content() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die(
				esc_html__(
					'You do not have sufficient permissions to access this page.',
					'veekls-api-client'
				)
			);
		}

		$updated = filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_SPECIAL_CHARS );

		include_once 'partials/veekls-api-client-admin-display.php';

	}

	/**
	 * Prints the message on the API Key section.
	 *
	 * @access private
	 */
	public function api_key_section_text() {

		echo esc_html__(
			'Copy and paste your API Key here. If you don\'t have it, please ask your Veekls Agent for it.',
			'veekls-api-client'
		);

	}

	/**
	 * Page for the API key settings.
	 *
	 * @since   1.0.0
	 */
	public function setup_settings_api_key_field() {

		$value = get_option( 'veekls_api_client_key' );

		include_once 'partials/veekls-api-client-admin-api-key-input.php';

	}

}
