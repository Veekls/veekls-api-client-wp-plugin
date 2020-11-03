<?php
/**
 * Veekls API Client
 *
 * The public-facing functionality of the plugin.
 *
 * @package Veekls/API_Client
 */

/**
 * Import functions for formatting.
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions-formatting.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions-listing.php';

/**
 * Import Search Form shortcode.
 */
require_once 'shortcodes/class-veekls-api-client-search-form-shortcode.php';

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    veekls-api-client
 * @subpackage veekls-api-client/public
 * @author     Santiago G. Marin <santiago.marin@veekls.com>
 */
class Veekls_API_Client_Public {
	/**
	 * The Vehicles base URL.
	 *
	 * @access private
	 * @var    string   $vehicles_base The ID of this plugin.
	 */
	private $vehicles_base = 'https://vehicles.public.api.veekls.com/';

	/**
	 * The Vehicle By ID base URL.
	 *
	 * @access private
	 * @var    string   $vehicle_base The ID of this plugin.
	 */
	private $vehicle_base = 'https://vehicles.public.api.veekls.com/by/id/';

	/**
	 * The pictures base URL.
	 *
	 * @access private
	 * @var    string   $pictures_base The ID of this plugin.
	 */
	private $pictures_base = 'https://pictures.veekls.com/';

	/**
	 * The ID of this plugin.
	 *
	 * @access private
	 * @var    string   $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access private
	 * @var    string   $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		// Register Search Form Shortcode.
		new Veekls_API_Client_Search_Form_Shortcode();
	}

	/**
	 * Fetches data from the remote API server.
	 *
	 * @param string $url   The full URL to fetch from.
	 * @param array  $query The HTTP request query parameters.
	 * @param array  $args  The HTTP request arguments.
	 *
	 * @return array The response data.
	 */
	private function fetch( $url, $query = array(), $args = array() ) {
		$api_key = get_option( 'veekls_api_client_key' );

		if ( ! $api_key ) {
			wp_die(
				esc_html__( 'Please configure you Veekls API Key first.' )
			);
		}

		if ( ! empty( $query ) ) {
			$url .= '?' . http_build_query( $query );
		}

		$args = array_merge(
			$args,
			array(
				'headers' => array(
					'Authorization' => 'Basic ' . $api_key,
				),
			)
		);

		$response = wp_remote_get( $url, $args );
		$body     = wp_remote_retrieve_body( $response );

		return json_decode( $body );
	}

	/**
	 * Build a Veekls picture URL.
	 *
	 * @param string $id    The picture id.
	 * @param string $query The URL query parameters.
	 *
	 * @return string The full picture url.
	 */
	public function picture( $id, $query = array() ) {
		$url = $this->pictures_base . $id;

		if ( ! empty( $query ) ) {
			$url .= '?' . http_build_query( $query );
		}

		return $url;
	}

	/**
	 * Fetches a single Vehicle by id with the provided query.
	 *
	 * @param string $id    The Vehicle ID to fetch.
	 * @param array  $query The HTTP request query params.
	 *
	 * @return array The results data.
	 */
	public function vehicle( $id, $query = array() ) {
		$url = $this->vehicle_base . $id;

		return $this->fetch( $url );
	}

	/**
	 * Fetches a Vehicles list with the provided query.
	 *
	 * @param array $query The HTTP request query params.
	 *
	 * @return array  The results data.
	 */
	public function vehicles( $query = array() ) {
		$url = $this->vehicles_base;

		return $this->fetch( $url, $query );
	}

	/**
	 * Fetches a Vehicles data with the provided query.
	 *
	 * @param array $query The HTTP request query params.
	 *
	 * @return array  The results data.
	 */
	public function vehicles_data( $query = array() ) {
		$url = $this->vehicles_base;

		return $this->fetch( $url, $query );
	}

	/**
	 * Returns vehicle types list.
	 *
	 * @return string The translated string.
	 */
	public static function vehicle_types() {
		return array(
			'automobile' => 'TYPES.VEHICLE.AUTOMOBILE',
			'motorcycle' => 'TYPES.VEHICLE.MOTORCYCLE',
			'machinery'  => 'TYPES.VEHICLE.MACHINERY',
			'nautical'   => 'TYPES.VEHICLE.NAUTICAL',
			'pickup'     => 'TYPES.VEHICLE.PICKUP',
			'truck'      => 'TYPES.VEHICLE.TRUCK',
			'other'      => 'TYPES.VEHICLE.OTHER',
			'suv'        => 'TYPES.VEHICLE.SUV',
		);
	}

	/**
	 * Translates Vehicle Type.
	 *
	 * @param object $type The Vehicle Type.
	 *
	 * @return string The translated string.
	 */
	public static function translate_vehicle_type( $type ) {
		$types = self::vehicle_types();

		switch ( $type ) {
			case $types['automobile']:
				return esc_html__( 'Automobile', 'veekls-api-client' );

			case $types['motorcycle']:
				return esc_html__( 'Motorcycle', 'veekls-api-client' );

			case $types['machinery']:
				return esc_html__( 'Machinery', 'veekls-api-client' );

			case $types['pickup']:
				return esc_html__( 'Pickup', 'veekls-api-client' );

			case $types['nautical']:
				return esc_html__( 'Nautical', 'veekls-api-client' );

			case $types['truck']:
				return esc_html__( 'Truck', 'veekls-api-client' );

			case $types['suv']:
				return esc_html__( 'SUV', 'veekls-api-client' );

			default:
				return esc_html__( 'Other', 'veekls-api-client' );
		}
	}

	/**
	 * Translates Vehicle Type.
	 *
	 * @param object $vehicle The Vehicle data.
	 *
	 * @return string The translated string.
	 */
	public static function vehicle_type( $vehicle ) {
		return self::translate_vehicle_type( $vehicle->type );
	}

	/**
	 * Translates vehicle type.
	 *
	 * @param string $vehicle The Vehicle data.
	 *
	 * @return string The translated string.
	 */
	public static function gearbox( $vehicle ) {
		switch ( $vehicle->gearbox ) {
			case 'GEARBOX.MANUAL':
				return esc_html__( 'Manual', 'veekls-api-client' );

			case 'GEARBOX.AUTO':
				return esc_html__( 'Automatic', 'veekls-api-client' );
		}
	}

	/**
	 * Translates Vehicle fuel type.
	 *
	 * @param object $vehicle The Vehicle data.
	 *
	 * @return string The translated string.
	 */
	public static function fuel_type( $vehicle ) {
		switch ( $vehicle->fuel ) {
			case 'FUEL.NATURAL_GAS':
				return esc_html__( 'Natural Gas', 'veekls-api-client' );
			case 'FUEL.BIODIESEL':
				return esc_html__( 'Biodiesel', 'veekls-api-client' );
			case 'FUEL.UNLEADED':
				return esc_html__( 'Unleaded', 'veekls-api-client' );
			case 'FUEL.ELECTRIC':
				return esc_html__( 'Electric', 'veekls-api-client' );
			case 'FUEL.HYDROGEN':
				return esc_html__( 'Hydrogen', 'veekls-api-client' );
			case 'FUEL.ETHANOL':
				return esc_html__( 'Ethanol', 'veekls-api-client' );
			case 'FUEL.PROPANE':
				return esc_html__( 'Propane', 'veekls-api-client' );
			case 'FUEL.LEADED':
				return esc_html__( 'Leaded', 'veekls-api-client' );
			case 'FUEL.HYBRID':
				return esc_html__( 'Hybrid', 'veekls-api-client' );
			case 'FUEL.DIESEL':
				return esc_html__( 'Diesel', 'veekls-api-client' );
		}
	}

	/**
	 * Translates Vehicle characteristic type.
	 *
	 * @param string $characteristic The characteristic const.
	 *
	 * @return string The translated string.
	 */
	public static function characteristic( $characteristic ) {
		switch ( $characteristic ) {
			// Comfort.
			case 'CHARACTERISTICS.VEHICLE.COMFORT.AC':
				return array(
					'name' => esc_html__( 'AC', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_WINDOW':
				return array(
					'name' => esc_html__( 'Power Windows', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_LOCKS':
				return array(
					'name' => esc_html__( 'Power Locks', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CRUISE_CONTROL':
				return array(
					'name' => esc_html__( 'Cruise Control', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ALL_WHEEL_DRIVE':
				return array(
					'name' => esc_html__( 'All Wheel Drive', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ADJUSTABLE_STEERING_WHEEL':
				return array(
					'name' => esc_html__( 'Adjustable Steering Wheel', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CD_CHANGER':
				return array(
					'name' => esc_html__( 'CD Changer', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CD_RECEIVER':
				return array(
					'name' => esc_html__( 'CD Receiver', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.MP3_RECEIVER':
				return array(
					'name' => esc_html__( 'MP3 Receiver', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.AM_FM_RECEIVER':
				return array(
					'name' => esc_html__( 'AM FM Receiver', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ON_BOARD_COMPUTER':
				return array(
					'name' => esc_html__( 'On Board Computer', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.HEATED_SEATS':
				return array(
					'name' => esc_html__( 'Heated Seats', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_SEATS':
				return array(
					'name' => esc_html__( 'Power Seats', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.MEMORY_SEATS':
				return array(
					'name' => esc_html__( 'Memory Seats', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.LEATHER_SEATS':
				return array(
					'name' => esc_html__( 'Leather Seats', 'veekls-api-client' ),
					'type' => 'comfort',
				);

			// Exterior.
			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.POWER_MIRRORS':
				return array(
					'name' => esc_html__( 'Power Mirrors', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.ALLOY_WHEELS':
			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.ALLOY_AHEELS':
				return array(
					'name' => esc_html__( 'Alloy Wheels', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.FRONT_FOG_LIGHTS':
				return array(
					'name' => esc_html__( 'Front Fog Lights', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.REAR_FOG_LIGHTS':
				return array(
					'name' => esc_html__( 'Rear Fog Lights', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.POWER_ROOF':
				return array(
					'name' => esc_html__( 'Power Roof', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.MANUAL_ROOF':
				return array(
					'name' => esc_html__( 'Manual Roof', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.REAR_WINDOW_WIPERS':
				return array(
					'name' => esc_html__( 'Rear Window Wipers', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.TINTED_WINDOWS':
				return array(
					'name' => esc_html__( 'Tinted Windows', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.XENON_LIGHTS':
				return array(
					'name' => esc_html__( 'Xenon Lights', 'veekls-api-client' ),
					'type' => 'exterior',
				);

			// Security.
			case 'CHARACTERISTICS.VEHICLE.SECURITY.ALARM':
				return array(
					'name' => esc_html__( 'Alarm', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.DRIVER_AIRBAG':
				return array(
					'name' => esc_html__( 'Driver Airbag', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.COPILOT_AIRBAG':
				return array(
					'name' => esc_html__( 'Copilot Airbag', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.LATERAL_AIRBAG':
				return array(
					'name' => esc_html__( 'Lateral Airbag', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.ABS':
				return array(
					'name' => esc_html__( 'ABS', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.EBD':
				return array(
					'name' => esc_html__( 'EBD', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.ESP':
				return array(
					'name' => esc_html__( 'ESP', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.TCS':
				return array(
					'name' => esc_html__( 'TCS', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.REAR_HEADREST':
				return array(
					'name' => esc_html__( 'Rear Headrest', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.REAR_DISC_BRAKES':
				return array(
					'name' => esc_html__( 'Rear Disc Brakes', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.CHIP_KEY':
				return array(
					'name' => esc_html__( 'Chip Key', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.LOCKING_WHEEL_NUT':
				return array(
					'name' => esc_html__( 'Locking Wheel Nut', 'veekls-api-client' ),
					'type' => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.RAIN_SENSOR':
				return array(
					'name' => esc_html__( 'Rain Sensor', 'veekls-api-client' ),
					'type' => 'security',
				);

			default:
				return array(
					'name' => $characteristic,
					'type' => '',
				);
		}
	}

	/**
	 * Builds the Vehicle's custom title.
	 *
	 * @param object $vehicle The vehicle data.
	 *
	 * @return string The title.
	 */
	public function short_characteristics( $vehicle ) {
		$characteristics = array_replace( array(), $vehicle->characteristics );

		shuffle( $characteristics );

		$characteristics = array_slice(
			array_filter(
				array_map(
					function( $characteristic ) {
						$value = $this->characteristic( $characteristic );

						if ( ! empty( $value ) && is_array( $value ) && ! empty( $value['name'] ) ) {
							return $value['name'];
						}

						return null;
					},
					$characteristics
				),
				function( $value ) {
					return ! empty( $value );
				}
			),
			0,
			3
		);

		return implode( ', ', $characteristics );
	}

	/**
	 * Builds the Vehicle's custom title.
	 *
	 * @param object $vehicle The vehicle data.
	 *
	 * @return string The title.
	 */
	public function title( $vehicle ) {
		return trim( $vehicle->brand ) .
			' ' . trim( $vehicle->model ) .
			' ' . trim( $vehicle->version );
	}

	/**
	 * Formats the price value.
	 *
	 * @param object $vehicle the vehicle data.
	 */
	public function format_price( $vehicle ) {
		return veekls_api_client_format_price( $vehicle->price );
	}

	/**
	 * Formats the odometer value.
	 *
	 * @param object $vehicle the vehicle data.
	 */
	public function format_odometer( $vehicle ) {
		return veekls_odometer( $vehicle->odometer );
	}
}
