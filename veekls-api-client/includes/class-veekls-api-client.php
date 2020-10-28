<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package veekls-api-client
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Veekls_API_Client {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Veekls_API_Client_Loader  $loader  Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The basename of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string     $plugin_basename  The plugin's basename.
	 */
	protected $plugin_basename;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string     $plugin_name  The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string     $version   The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 *
	 * @param string $plugin_basename The plugin basename.
	 */
	public function __construct( $plugin_basename ) {
		if ( defined( 'VEEKLS_API_CLIENT_VERSION' ) ) {
			$this->version = VEEKLS_API_CLIENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name     = 'veekls-api-client';
		$this->plugin_basename = $plugin_basename;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Veekls_API_Client_Loader. Orchestrates the hooks of the plugin.
	 * - Veekls_API_Client_I18n. Defines internationalization functionality.
	 * - Veekls_API_Client_Admin. Defines all hooks for the admin area.
	 * - Veekls_API_Client_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) .
		'includes/class-veekls-api-client-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) .
		'includes/class-veekls-api-client-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin
		 * area.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) .
		'admin/class-veekls-api-client-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the
		 * public-facing side of the site.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) .
		'public/class-veekls-api-client-public.php';

		$this->loader = new Veekls_API_Client_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Veekls_API_Client_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_locale() {
		$plugin_i18n = new Veekls_API_Client_I18n();

		$this->loader->add_action(
			'plugins_loaded',
			$plugin_i18n,
			'load_plugin_textdomain'
		);
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Veekls_API_Client_Admin(
			$this->get_plugin_name(),
			$this->get_version()
		);

		$this->loader->add_filter(
			'plugin_action_links_' . $this->plugin_basename,
			$plugin_admin,
			'add_settings_link',
			10,
			1
		);

		$this->loader->add_action(
			'admin_menu',
			$plugin_admin,
			'setup_settings_page'
		);

		$this->loader->add_action(
			'admin_init',
			$plugin_admin,
			'setup_settings_sections'
		);

		$this->loader->add_action(
			'admin_init',
			$plugin_admin,
			'setup_settings_fields'
		);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		$plugin_public = new Veekls_API_Client_Public(
			$this->get_plugin_name(),
			$this->get_version()
		);

		$this->loader->add_filter(
			'veekls_characteristic_type',
			$plugin_public,
			'characteristic_type',
			0,
			1
		);

		$this->loader->add_filter(
			'veekls_gearbox_type',
			$plugin_public,
			'gearbox_type',
			0,
			1
		);

		$this->loader->add_filter(
			'veekls_vehicle_types',
			$plugin_public,
			'vehicle_types',
			0,
			0
		);

		$this->loader->add_filter(
			'veekls_vehicle_type',
			$plugin_public,
			'vehicle_type',
			0,
			1
		);

		$this->loader->add_filter(
			'veekls_translate_vehicle_type',
			$plugin_public,
			'translate_vehicle_type',
			0,
			1
		);

		$this->loader->add_filter(
			'veekls_fuel_type',
			$plugin_public,
			'fuel_type',
			0,
			1
		);

		$this->loader->add_filter(
			'veekls_picture',
			$plugin_public,
			'picture',
			0,
			2
		);

		$this->loader->add_filter(
			'veekls_title',
			$plugin_public,
			'title',
			0,
			2
		);

		$this->loader->add_filter(
			'veekls_price',
			$plugin_public,
			'format_price',
			0,
			2
		);

		$this->loader->add_filter(
			'veekls_api_client_search_form_get_vehicle_data_args',
			$plugin_public,
			'vehicles_data',
			0,
			0
		);

		$this->loader->add_filter(
			'veekls_fetch_vehicles',
			$plugin_public,
			'vehicles',
			0,
			1
		);

		$this->loader->add_action(
			'veekls_fetch_vehicle',
			$plugin_public,
			'vehicle',
			0,
			2
		);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 *
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return Veekls_API_Client_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
