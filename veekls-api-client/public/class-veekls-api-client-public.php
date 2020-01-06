<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/veekls/veekls-api-client-wp/
 * @since      1.0.0
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/public
 * @author     Santiago G. Marin <santiago.marin@veekls.com>
 */
class Veekls_API_Client_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string   $version   The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name   The name of the plugin.
	 * @param      string $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Veekls_API_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Veekls_API_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/veekls-api-client-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Veekls_API_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Veekls_API_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/veekls-api-client-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Build a Veekls picture URL.
	 *
	 * @since   1.0.0
	 * @param   string $id   The picture id.
	 *
	 * @return  string The full picture url.
	 */
	public function picture( $id ) {
		return $this->pictures_base . $id;
	}

	/**
	 * Fetches a single Vehicle by id or the vehicles list.
	 *
	 * @since   1.0.0
	 * @param   string $id  The resource id.
	 *
	 * @return  array  The request data.
	 */
	public function vehicles( $id = null ) {
		$url = null;

		if ( $id ) {
			$url = $this->vehicle_base . $id;
		} else {
			$url = $this->vehicles_base;
		}

		$args = array(
			'headers' => array(
				'Authorization' => 'Basic ' . get_option( 'veekls_api_client_key' ),
			),
		);

		$response = wp_remote_get( $url, $args );
		$body     = wp_remote_retrieve_body( $response );

		return json_decode( $body );
	}

	/**
	 * Translates vehicle type.
	 *
	 * @since   1.0.0
	 * @param   string $type The Vehicle type.
	 *
	 * @return  string The translated string.
	 */
	public static function vehicle_type( $type ) {
		switch ( $type ) {
			case 'TYPES.VEHICLE.AUTOMOBILE':
				return __( 'Automobile', 'mk_veekls' );

			case 'TYPES.VEHICLE.MOTORCYCLE':
				return __( 'Motorcycle', 'mk_veekls' );

			case 'TYPES.VEHICLE.MACHINERY':
				return __( 'Machinery', 'mk_veekls' );

			case 'TYPES.VEHICLE.PICKUP':
				return __( 'Pickup', 'mk_veekls' );

			case 'TYPES.VEHICLE.NAUTIC':
				return __( 'Nautic', 'mk_veekls' );

			case 'TYPES.VEHICLE.TRUCK':
				return __( 'Truck', 'mk_veekls' );

			case 'TYPES.VEHICLE.OTHER':
				return __( 'Other', 'mk_veekls' );

			case 'TYPES.VEHICLE.SUV':
				return __( 'SUV', 'mk_veekls' );
		}
	}

	/**
	 * Translates vehicle type.
	 *
	 * @since   1.0.0
	 * @param   string $type The Vehicle gearbox type.
	 *
	 * @return  string The translated string.
	 */
	public static function gearbox_type( $type ) {
		switch ( $type ) {
			case 'GEARBOX.MANUAL':
				return __( 'Manual', 'mk_veekls' );
			case 'GEARBOX.AUTO':
				return __( 'Auto', 'mk_veekls' );
		}
	}

	/**
	 * Translates Vehicle fuel type.
	 *
	 * @since   1.0.0
	 * @param   string $type The Vehicle fuel type.
	 *
	 * @return  string The translated string.
	 */
	public static function fuel_type( $type ) {
		switch ( $type ) {
			case 'FUEL.NATURAL_GAS':
				return __( 'Gas', 'mk_veekls' );
			case 'FUEL.BIODIESEL':
				return __( 'Biodiesel', 'mk_veekls' );
			case 'FUEL.UNLEADED':
				return __( 'Unleaded', 'mk_veekls' );
			case 'FUEL.ELECTRIC':
				return __( 'Electric', 'mk_veekls' );
			case 'FUEL.HYDROGEN':
				return __( 'Hydrogen', 'mk_veekls' );
			case 'FUEL.ETHANOL':
				return __( 'Ethanol', 'mk_veekls' );
			case 'FUEL.PROPANE':
				return __( 'Propane', 'mk_veekls' );
			case 'FUEL.LEADED':
				return __( 'Leaded', 'mk_veekls' );
			case 'FUEL.HYBRID':
				return __( 'Hybrid', 'mk_veekls' );
			case 'FUEL.DIESEL':
				return __( 'Diesel', 'mk_veekls' );
		}
	}

	/**
	 * Translates Vehicle characteristic type.
	 *
	 * @since   1.0.0
	 * @param   string $type The Vehicle fuel type.
	 *
	 * @return  string The translated string.
	 */
	public static function characteristic_type( $type ) {
		switch ( $type ) {
			// Comfort.
			case 'CHARACTERISTICS.VEHICLE.COMFORT.AC':
				return array(
					'characteristic' => __( 'AC', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_WINDOW':
				return array(
					'characteristic' => __( 'Power Window', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_LOCKS':
				return array(
					'characteristic' => __( 'Power Locks', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CRUISE_CONTROL':
				return array(
					'characteristic' => __( 'Cruise Control', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ALL_WHEEL_DRIVE':
				return array(
					'characteristic' => __( 'All Wheel Drive', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ADJUSTABLE_STEERING_WHEEL':
				return array(
					'characteristic' => __( 'Adjustable Steering Wheel', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CD_CHANGER':
				return array(
					'characteristic' => __( 'CD Changer', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.CD_RECEIVER':
				return array(
					'characteristic' => __( 'CD Receiver', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.MP3_RECEIVER':
				return array(
					'characteristic' => __( 'MP3 Receiver', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.AM_FM_RECEIVER':
				return array(
					'characteristic' => __( 'AM FM Receiver', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.ON_BOARD_COMPUTER':
				return array(
					'characteristic' => __( 'On Board Computer', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.HEATED_SEATS':
				return array(
					'characteristic' => __( 'Heated Seats', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.POWER_SEATS':
				return array(
					'characteristic' => __( 'Power Seats', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.MEMORY_SEATS':
				return array(
					'characteristic' => __( 'Memory Seats', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			case 'CHARACTERISTICS.VEHICLE.COMFORT.LEATHER_SEATS':
				return array(
					'characteristic' => __( 'Leather Seats', 'mk_veekls' ),
					'type'           => 'comfort',
				);

			// Exterior.
			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.POWER_MIRRORS':
				return array(
					'characteristic' => __( 'Power Mirrors', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.ALLOY_WHEELS':
				return array(
					'characteristic' => __( 'Alloy Wheels', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.FRONT_FOG_LIGHTS':
				return array(
					'characteristic' => __( 'Front Fog Lights', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.REAR_FOG_LIGHTS':
				return array(
					'characteristic' => __( 'Rear Fog Lights', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.POWER_ROOF':
				return array(
					'characteristic' => __( 'Power Roof', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.MANUAL_ROOF':
				return array(
					'characteristic' => __( 'Manual Roof', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.REAR_WINDOW_WIPERS':
				return array(
					'characteristic' => __( 'Rear Window Wipers', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.TINTED_WINDOWS':
				return array(
					'characteristic' => __( 'Tinted Windows', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			case 'CHARACTERISTICS.VEHICLE.EXTERIOR.XENON_LIGHTS':
				return array(
					'characteristic' => __( 'Xenon Lights', 'mk_veekls' ),
					'type'           => 'exterior',
				);

			// Security.
			case 'CHARACTERISTICS.VEHICLE.SECURITY.ALARM':
				return array(
					'characteristic' => __( 'Alarm', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.DRIVER_AIRBAG':
				return array(
					'characteristic' => __( 'Driver Airbag', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.COPILOT_AIRBAG':
				return array(
					'characteristic' => __( 'Copilot Airbag', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.LATERAL_AIRBAG':
				return array(
					'characteristic' => __( 'Lateral Airbag', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.ABS':
				return array(
					'characteristic' => __( 'ABS', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.EBD':
				return array(
					'characteristic' => __( 'EBD', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.ESP':
				return array(
					'characteristic' => __( 'ESP', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.TCS':
				return array(
					'characteristic' => __( 'TCS', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.REAR_HEADREST':
				return array(
					'characteristic' => __( 'Rear Headrest', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.REAR_DISC_BRAKES':
				return array(
					'characteristic' => __( 'Rear Disc Brakes', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.CHIP_KEY':
				return array(
					'characteristic' => __( 'Chip Key', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.LOCKING_WHEEL_NUT':
				return array(
					'characteristic' => __( 'Locking Wheel Nut', 'mk_veekls' ),
					'type'           => 'security',
				);

			case 'CHARACTERISTICS.VEHICLE.SECURITY.RAIN_SENSOR':
				return array(
					'characteristic' => __( 'Rain Sensor', 'mk_veekls' ),
					'type'           => 'security',
				);
		}
	}


	/**
	 * Sets the custom title.
	 *
	 * @since   1.0.0
	 * @param   string $title The current title.
	 *
	 * @return  string The new title.
	 */
	public function title( $title ) {
		$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS );

		if ( get_the_ID() === 77 && $id ) {
			$vehicle = $this->vehicles( $id );

			$title['title'] = $vehicle->brand . ' ' . $vehicle->model . ' ' .
				$vehicle->version;
		}

		return $title;
	}

	/**
	 * Feed home function.
	 *
	 * @since   1.0.0
	 * @param   array $atts The attributes.
	 *
	 * @return  string The HTML.
	 */
	public function vehicles_home( $atts ) {
		$a = shortcode_atts(
			array( 'total' => 5 ),
			$atts
		);

		$html     = '<div class="carousel-slider3">';
		$vehicles = $this->vehicles();
		$count    = 0;

		foreach ( $vehicles as $vehicle ) {
			if ( $count >= $a['total'] ) {
				break;
			}

			$html .= '
				<div class="slide">
					<div class="car-block">
						<div class="img-flex">
							<a href="' . home_url() . '/single-vehicle?id=' . $vehicle->_id . '">
								<span class="align-center">
									<i class="fa fa-3x fa-plus-square-o"></i>
								</span>
							</a>
							<img src="' . $this->picture( $vehicle->pictures[0] ) . '" alt="" class="img-responsive">
						</div>
						<div class="car-block-bottom">
							<h6>
								<strong>' . $vehicle->brand . ' ' . $vehicle->model . ' ' . $vehicle->version . '</strong>
							</h6>
							<h6>' . $vehicle->year . ' - ' . number_format( $vehicle->odometer, 0, '', '.' ) . 'Km</h6>
							<h5>$' . number_format( $vehicle->price, 0, '', '.' ) . '</h5>
						</div>
					</div>
				</div>
				';

			$count++;
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Vehicle feed widget shortcoder.
	 *
	 * @since   1.0.0
	 * @param   array $atts The atts.
	 *
	 * @return  string The HTML.
	 */
	public function vehicles_footer( $atts ) {
		$a = shortcode_atts(
			array( 'total' => 5 ),
			$atts
		);

		$vehicles = $this->vehicles();
		$html     = '';
		$count    = 0;

		foreach ( $vehicles as $vehicle ) {
			if ( $count >= $a['total'] ) {
				break;
			}

			$html .= '
				<div class="car-block recent_car">
					<div class="img-flex">
						<a href="' . home_url() . '/single-vehicle?id=' . $vehicle->_id . '">
							<span class="align-center">
								<i class="fa fa-2x fa-plus-square-o"></i>
							</span>
						</a>

						<img src="' . $this->picture( $vehicle->pictures[0] ) . '" alt="" class="img-responsive">
					</div>
					<div class="car-block-bottom">
						<h6>
							<strong>' . $vehicle->brand . ' ' . $vehicle->model . ' ' . $vehicle->version . '</strong>
						</h6>
						<h6>' . $vehicle->year . ' - ' . number_format( $vehicle->odometer, 0, '', '.' ) . 'Km</h6>
						<h5>$' . number_format( $vehicle->price, 0, '', '.' ) . '</h5>
					</div>
				</div>
				';

			$count++;
		}

		return $html;
	}

	/**
	 * Vehicle feed catalog shortcode.
	 *
	 * @since   1.0.0
	 * @param   array $atts The atts.
	 *
	 * @return  string The HTML.
	 */
	public function vehicles_catalog( $atts ) {
		$vehicles = $this->vehicles();
		$count    = 1;

		$html = '<div class="car_listings sidebar margin-top-20 clearfix">';

		foreach ( $vehicles as $vehicle ) {
			$html .= '
				<div class="inventory margin-bottom-20 clearfix scroll_effect fadeIn">
					<input type="checkbox" name="a" class="checkbox compare_vehicle input-checkbox" id="vehicle_' . $count . '" />
					<a class="inventory" href="' . home_url() . '/single-vehicle?id=' . $vehicle->_id . '">
						<div class="title">' . $vehicle->brand . ' ' . $vehicle->model . ' ' . $vehicle->version . '</div>
						<img src="' . $this->picture( $vehicle->pictures[0] ) . '" class="preview" alt="preview">
						<table class="options-primary">
							<tr>
								<td class="option primary">' . __( 'Body Style', 'mk_veekls' ) . ':</td>
								<td class="spec">' . $this->vehicle_type( $vehicle->type ) . '</td>
							</tr>
							<tr>
								<td class="option primary">' . __( 'Year', 'mk_veekls' ) . ':</td>
								<td class="spec">' . $vehicle->year . '</td>
							</tr>
							<tr>
								<td class="option primary">' . __( 'Odometer', 'mk_veekls' ) . ':</td>
								<td class="spec">' . number_format( $vehicle->odometer, 0, '', '.' ) . 'Km</td>
							</tr>
						</table>
						<table class="options-secondary">
								<tr>
									<td class="option secondary">' . __( 'Color', 'mk_veekls' ) . ':</td>
									<td class="spec">' . $vehicle->color . '</td>
								</tr>
								<tr>
									<td class="option secondary">' . __( 'Gearbox', 'mk_veekls' ) . ':</td>
									<td class="spec">' . $this->gearbox_type( $vehicle->gearbox ) . '</td>
								</tr>
								<tr>
									<td class="option secondary">' . __( 'Fuel', 'mk_veekls' ) . ':</td>
									<td class="spec">' . $this->fuel_type( $vehicle->fuel ) . '</td>
								</tr>
						</table>
						<div class="price"><b>' . __( 'Price', 'mk_veekls' ) . ':</b><br>
							<div  style="font-size: 28px;" class="figure">$' . number_format( $vehicle->price, 0, '', '.' ) . '<br>
						</div>
						<!-- <div class="tax">Plus Sales Tax</div> -->
						</div>
						<div class="view-details gradient_button">
							<i class="fa fa-plus-circle"></i>
							<span>' . __( 'View Details', 'mk_veekls' ) . '</span>
						</div>

						<div class="clearfix"></div>
					</a>
				</div>
				';

			$count++;
		}

		$html .= '
			<div class="clearfix"></div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagination_container">
				<ul class="pagination margin-bottom-none margin-top-25 bottom_pagination md-margin-bottom-none xs-margin-bottom-60 sm-margin-bottom-60">
					<li class="disabled">
						<a href="#">
							<i class="fa fa-angle-left"></i>
						</a>
					</li>
					<li>
						<a href="#">1</a>
					</li>
					<li>
						<a href="#">2</a>
					</li>
					<li>
						<a href="#">3</a>
					</li>
					<li>
						<a href="#">4</a>
					</li>
					<li>
						<a href="#">5</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-angle-right"></i>
						</a>
					</li>
				</ul>
			</div>
			';

		$html .= '</div>';

		return $html;
	}

	/**
	 * Single Vehicle view shortcode.
	 *
	 * @since   1.0.0
	 * @param   array $atts The atts.
	 *
	 * @return  string The HTML.
	 */
	public function vehicle( $atts ) {
		$a = shortcode_atts(
			array(
				'total' => 5,
				'id'    => 0,
			),
			$atts
		);

		$root_vehicle = $this->vehicles( $a['id'] );

		$pictures       = $root_vehicle->pictures;
		$pictures_html  = '';
		$thumbnail_html = '';

		foreach ( $pictures as $picture ) {
			$pictures_html .= '
				<li data-thumb="' . $this->picture( $picture ) . '">
					<img style="margin:auto" src="' . $this->picture( $picture ) . '" alt="" data-full-image="' . $this->picture( $picture ) . '"  itemprop="image"/>
				</li>
				';

			$thumbnail_html .= '
				<li data-thumb="' . $this->picture( $picture ) . '">
					<a href="#">
						<img src="' . $this->picture( $picture ) . '" alt="" />
					</a>
				</li>
				';
		}

		$thumbnail_htmljson .= '"' . $this->picture( $pictures[0] ) . '"';
		$characteristics     = $root_vehicle->characteristics;
		$comfort             = '';
		$exterior            = '';
		$security            = '';

		foreach ( $characteristics as $characteristic ) {
			$item = $this->characteristic_type( $characteristic );

			switch ( $item['type'] ) {
				case 'comfort':
					$comfort .= '
						<li>
							<i class="fa-li fa fa-check"></i>
							<span>' . $item['characteristic'] . '</span>
						</li>
						';
					break;

				case 'exterior':
					$exterior .= '
						<li>
							<i class="fa-li fa fa-check"></i>
							<span>' . $item['characteristic'] . '</span>
						</li>
						';
					break;

				case 'security':
					$security .= '
						<li>
							<i class="fa-li fa fa-check"></i>
							<span>' . $item['characteristic'] . '</span>
						</li>
						';
					break;
			};
		};

		// Widget Vehicles.
		$related_html = '<div class="carousel-slider3">';
		$vehicles     = $this->vehicles();
		$count        = 0;

		shuffle( $vehicles );

		foreach ( $vehicles as $vehicle ) {
			if ( $root_vehicle->brand === $vehicle->brand ) {
				if ( $count >= $a['total'] ) {
					break;
				}

				$related_html .= '
					<div class="slide">
						<div class="car-block">
							<div class="img-flex">
								<a href="' . home_url() . '/single-vehicle?id=' . $vehicle->_id . '">
									<span class="align-center">
										<i class="fa fa-3x fa-plus-square-o"></i>
									</span>
								</a>
								<img src="' . $this->picture( $vehicle->pictures[0] ) . '" alt="" class="img-responsive">
							</div>
							<div class="car-block-bottom">
								<h6>
									<strong>' . $vehicle->brand . ' ' . $vehicle->model . ' ' . $vehicle->version . '</strong>
								</h6>
								<h6>' . $vehicle->year . ' - ' . number_format( $vehicle->odometer, 0, '', '.' ) . 'Km</h6>
								<h5>$' . number_format( $vehicle->price, 0, '', '.' ) . '</h5>
							</div>
						</div>
					</div>
					';

				$count++;
			}
		}

		$related_html .= '</div>';

		// For other images just change the class name of this section block
		// like, class="dynamic-image-2" and add css for the changed class.

		return '
			<div class="clearfix"></div>

			<section id="secondary-banner" class="dynamic-image-8">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
							<h2>' . $root_vehicle->brand . ' ' . $root_vehicle->model . ' ' . $root_vehicle->version . '</h2>
							<h4>' . substr( $root_vehicle->promo->message, 0, 60 ) . '...</h4>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 ">
							<ul class="breadcrumb">
								<li>
									<a href="' . home_url() . '">' . __( 'Home', 'mk_veekls' ) . '</a>
								</li>
								<li>
									<a href="' . home_url() . '/catalogo' . '">' . esc_html( __( 'Inventory', 'mk_veekls' ) ) . '</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</section>

			<div class="message-shadow"></div>
			<div class="clearfix"></div>

			<section class="content">
				<div class="container">
					<div class="inner-page inventory-listing">
						<div class="inner-page inventory-listing" itemscope itemtype="http://schema.org/Product">
							<div class="inventory-heading margin-bottom-10 clearfix">
								<div class="row">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<span class="margin-top-10"></span>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 text-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<h2>
											<span itemprop="priceCurrency" content="CLP">$</span>
											<span itemprop="price"  content="' . $root_vehicle->price . '">' . number_format( $root_vehicle->price, 0, '', '.' ) . '</span>
										</h2>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 left-content padding-left-none">
									<div class="listing-slider">
										<section class="slider home-banner">
											<div class="flexslider" id="home-slider-canvas">
												<ul class="slides">' . $pictures_html . '</ul>
											</div>
										</section>
										<section class="home-slider-thumbs">
											<div class="flexslider" id="home-slider-thumbs">
												<ul class="slides">' . $thumbnail_html . '</ul>
											</div>
										</section>
									</div>

									<div class="clearfix"></div>

									<div class="bs-example bs-example-tabs example-tabs margin-top-50">
										<ul id="myTab" class="nav nav-tabs">
											<li class="active">
												<a href="#vehicle" data-toggle="tab">' . __( 'Vehicle Overview', 'mk_veekls' ) . '</a>
											</li>
											<li>
												<a href="#features" data-toggle="tab">' . __( 'Features', 'mk_veekls' ) . '</a>
											</li>
										</ul>
										<div id="myTabContent" class="tab-content margin-top-15 margin-bottom-20">
											<div class="tab-pane fade in active" id="vehicle" itemprop="description">
												<p>' . $root_vehicle->promo->message . '</p>
											</div>
											<div class="tab-pane fade" id="features">
												<ul class="fa-ul">
													<p style="margin-bottom:0">
														<strong>' . __( 'Comfort', 'mk_veekls' ) . ':</strong>
													</p>

													' . $comfort . '

													<p style="margin-bottom:0">
														<strong>' . __( 'Exterior', 'mk_veekls' ) . ':</strong>
													</p>

													' . $exterior . '

													<p style="margin-bottom:0">
														<strong>' . __( 'Security', 'mk_veekls' ) . ':</strong>
													</p>

													' . $security . '
												</ul>
											</div>
										</div>
									</div>

									<div class="clearfix"></div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 right-content padding-right-none">
									<div class="side-content">
										<div class="car-info margin-bottom-50">
											<div class="table-responsive">
												<table class="table">
													<tbody>
														<tr>
															<td>' . __( 'Name', 'mk_veekls' ) . ':</td>
															<td itemprop="name">' . $root_vehicle->brand . ' ' . $root_vehicle->model . ' ' . $root_vehicle->version . '</td>
														</tr>
														<tr>
															<td>' . __( 'Body Style', 'mk_veekls' ) . ':</td>
															<td>' . $this->vehicle_type( $root_vehicle->type ) . '</td>
														</tr>
														<tr>
															<td>' . __( 'Brand', 'mk_veekls' ) . ':</td>
															<td itemprop="brand">' . $root_vehicle->brand . '</td>
														</tr>
														<tr>
															<td>' . __( 'Model', 'mk_veekls' ) . ':</td>
															<td itemprop="model">' . $root_vehicle->model . '</td>
														</tr>
														<tr>
															<td>' . __( 'Version', 'mk_veekls' ) . ':</td>
															<td>' . $root_vehicle->version . '</td>
														</tr>
														<tr>
															<td>' . __( 'Year', 'mk_veekls' ) . ':</td>
															<td itemprop="releaseDate">' . $root_vehicle->year . '</td>
														</tr>
														<tr>
															<td>' . __( 'Color', 'mk_veekls' ) . ':</td>
															<td itemprop="color">' . $root_vehicle->color . '</td>
														</tr>
														<tr>
															<td>' . __( 'Odometer', 'mk_veekls' ) . ':</td>
															<td>' . number_format( $root_vehicle->odometer, 0, '', '.' ) . 'Km</td>
														</tr>
														<tr>
															<td>' . __( 'Version', 'mk_veekls' ) . ':</td>
															<td>' . $root_vehicle->version . '</td>
														</tr>
														<tr>
															<td>' . __( 'Gearbox', 'mk_veekls' ) . ':</td>
															<td>' . $this->gearbox_type( $root_vehicle->gearbox ) . '</td>
														</tr>
														<tr>
															<td>' . __( 'Fuel', 'mk_veekls' ) . ':</td>
															<td>' . $this->fuel_type( $root_vehicle->fuel ) . '</td>
														</tr>
														<tr>
															<td>' . __( 'Link', 'mk_veekls' ) . ':</td>
															<td itemprop="url">' . home_url() . '/catalogo' . '">'
																. __( 'Inventory', 'mk_veekls' ) .
															'</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

										<div class="clearfix"></div>
									</div>
								</div>
							</div>

							<div class="clearfix"></div>

							<div class="recent-vehicles-wrap">
								<div class="row">
									<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 recent-vehicles padding-left-none xs-padding-bottom-20">
										<h5 class="margin-top-none">Similar Vehicles</h5>
										<p>Browse through the vast selection of vehicles that have recently been added to our inventory.</p>
										<div class="arrow3 clearfix" id="slideControls3">
											<span class="prev-btn"></span>
											<span class="next-btn"></span>
										</div>
									</div>
									<div class="col-md-10 col-sm-8 padding-right-none sm-padding-left-none xs-padding-left-none">
										' . $related_html . '
									</div>
								</div>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</section>

			<div class="clearfix"></div>
			';
	}
}
