<?php
/**
 * Listing functions.
 *
 * @package Veekls_Api_Client
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Spec fields function.
 */
function veekls_spec_fields() {
	$spec_fields = array(
		'model_year'              => array(
			'label' => __( 'Year', 'veekls' ),
			'type'  => 'model',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'make_display'            => array(
			'label' => __( 'Make', 'veekls' ),
			'type'  => 'general',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'model_name'              => array(
			'label' => __( 'Model', 'veekls' ),
			'type'  => 'model',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'model_vehicle'           => array(
			'label' => __( 'Vehicle', 'veekls' ),
			'type'  => 'model',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'model_seats'             => array(
			'label' => __( 'Seats', 'veekls' ),
			'type'  => 'general',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'model_doors'             => array(
			'label' => __( 'Doors', 'veekls' ),
			'type'  => 'general',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),

		// Transmission.
		'model_drive'             => array(
			'label' => __( 'Drive Type', 'veekls' ),
			'type'  => 'transmission',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),
		'model_transmission_type' => array(
			'label' => __( 'Transmission Type', 'veekls' ),
			'type'  => 'transmission',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),

		// Fuel.
		'model_engine_fuel'       => array(
			'label' => __( 'Fuel Type', 'veekls' ),
			'type'  => 'fuel',
			'desc'  => __( ' (Recommended)', 'veekls' ),
		),

	);

	$metric_fields = array(
		// Fuel.
		'model_lkm_hwy'       => array(
			'label' => __( 'Fuel Economy Highway (l/100km)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_lkm_mixed'     => array(
			'label' => __( 'Fuel Economy Mixed (l/100km)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_lkm_city'      => array(
			'label' => __( 'Fuel Economy City (l/100km)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_fuel_cap_l'    => array(
			'label' => __( 'Fuel Capacity (l):', 'veekls' ),
			'type'  => 'fuel',
		),

		// Dimensions.
		'model_weight_kg'     => array(
			'label' => __( 'Weight (kg)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_length_mm'     => array(
			'label' => __( 'Length (mm)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_width_mm'      => array(
			'label' => __( 'Width (mm)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_height_mm'     => array(
			'label' => __( 'Height (mm)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_wheelbase_mm'  => array(
			'label' => __( 'Wheelbase (mm)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),

		// Performance.
		'model_0_to_100_kph'  => array(
			'label' => __( '0-100 kph', 'veekls' ),
			'type'  => 'performance',
		),
		'model_top_speed_kph' => array(
			'label' => __( 'Top Speed (KPH)', 'veekls' ),
			'type'  => 'performance',
		),

		// Engine.
		'model_engine_cc'     => array(
			'label' => __( 'Engine Displacement (cc)', 'veekls' ),
			'type'  => 'engine',
		),

	);

	$imperial_fields = array(
		// Fuel.
		'model_mpg_hwy'       => array(
			'label' => __( 'Fuel Economy Highway (mpg)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_mpg_city'      => array(
			'label' => __( 'Fuel Economy City (mpg)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_mpg_mixed'     => array(
			'label' => __( 'Fuel Economy Mixed (mpg)', 'veekls' ),
			'type'  => 'fuel',
		),
		'model_fuel_cap_g'    => array(
			'label' => __( 'Fuel Capacity (g)', 'veekls' ),
			'type'  => 'fuel',
		),

		// Dimensions.
		'model_weight_lbs'    => array(
			'label' => __( 'Weight (lbs)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_length_in'     => array(
			'label' => __( 'Length (in)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_width_in'      => array(
			'label' => __( 'Width (in)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_height_in'     => array(
			'label' => __( 'Height (in)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),
		'model_wheelbase_in'  => array(
			'label' => __( 'Wheelbase (in)', 'veekls' ),
			'type'  => 'weight_dimensions',
		),

		// Performance.
		'model_0_to_100_kph'  => array(
			'label' => __( '0-62 mph', 'veekls' ),
			'type'  => 'performance',
		),
		'model_top_speed_mph' => array(
			'label' => __( 'Top Speed (mph)', 'veekls' ),
			'type'  => 'performance',
		),

		// Engine.
		'model_engine_ci'     => array(
			'label' => __( 'Engine Displacement (ci)', 'veekls' ),
			'type'  => 'engine',
		),
	);

	$engine_fields = array(
		// Engine.
		'model_engine_position'       => array(
			'label' => __( 'Engine Location', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_type'           => array(
			'label' => __( 'Engine Type', 'veekls' ),
			'type'  => 'engine',
			'desc'  => __( ' (Recommended)', 'veekls' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'veekls' ),
		),
		'model_engine_l'              => array(
			'label' => __( 'Engine (l)', 'veekls' ),
			'type'  => 'engine',
			'desc'  => __( ' (Recommended)', 'veekls' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'veekls' ),
		),
		'model_engine_cyl'            => array(
			'label' => __( 'Engine Cylinders', 'veekls' ),
			'type'  => 'engine',
			'desc'  => __( ' (Recommended)', 'veekls' ) . '<br>' . __( 'Data from this field is used for the "Engine" icon text', 'veekls' ),
		),
		'model_engine_valves'         => array(
			'label' => __( 'Engine Valves', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_valves_per_cyl' => array(
			'label' => __( 'Engine Valves Per Cyl', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_power_hp'       => array(
			'label' => __( 'Engine Max Power (HP)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_power_kw'       => array(
			'label' => __( 'Engine Max Power (kW)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_power_ps'       => array(
			'label' => __( 'Engine Max Power (PS)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_power_rpm'      => array(
			'label' => __( 'Engine Max Power RPM', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_torque_nm'      => array(
			'label' => __( 'Engine Max Torque (NM)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_torque_lbft'    => array(
			'label' => __( 'Engine Max Torque (Lb-Ft)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_torque_kgm'     => array(
			'label' => __( 'Engine Max Torque (kgf-m)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_torque_rpm'     => array(
			'label' => __( 'Engine Max Torque RPM', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_bore_mm'        => array(
			'label' => __( 'Engine Bore (mm)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_stroke_mm'      => array(
			'label' => __( 'Engine Stroke (mm)', 'veekls' ),
			'type'  => 'engine',
		),
		'model_engine_compression'    => array(
			'label' => __( 'Engine Compression Ratio', 'veekls' ),
			'type'  => 'engine',
		),

		'make_country'                => array(
			'label' => __( 'Country', 'veekls' ),
			'type'  => 'general',
		),
	);

	$fields = array_merge( $spec_fields, $metric_fields, $imperial_fields, $engine_fields );

	return $fields;
}

/**
 * Specs output.
 */
function veekls_get_specs_for_output() {
	$fields      = array();
	$spec_fields = veekls_spec_fields();
	$display     = veekls_option( 'field_display' );

	foreach ( $spec_fields as $id => $value ) {
		if ( is_array( $display ) && ! in_array( $id, $display, true ) ) {
			continue;
		}

		$val = veekls_meta( $id );

		if ( ! $val ) {
			continue;
		}

		$label            = str_replace( ' *', '', $value['label'] );
		$fields[ $label ] = $val;
	}

	return $fields;
}

/**
 * Show Archive Page title within page content area.
 */
function veekls_force_page_title() {
	return veekls_option( 'archives_page_title' ) ? veekls_option( 'archives_page_title' ) : 'no';
}

/**
 * Get the URL of the first image of a listing.
 */
function veekls_get_first_image() {
	$gallery = veekls_meta( 'image_gallery' );

	if ( empty( $gallery ) ) {
		$sml = apply_filters( 'veekls_default_no_image', AUTOLISTINGS_PLUGIN_URL . 'assets/images/no-image.jpg' );
		$alt = '';
	} else {
		$id  = key( $gallery );
		$sml = wp_get_attachment_image_url( $id, 'al-sml' );
		$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
	}

	return array(
		'alt' => $alt,
		'sml' => $sml,
	);
}

/**
 * Get the listing status.
 */
function veekls_get_status() {
	$listing_status = veekls_meta( 'status' );
	$option_status  = veekls_option( 'listing_status' );

	if ( ! $listing_status ) {
		return;
	}

	$status = null;

	if ( $option_status ) {
		foreach ( $option_status as $key => $value ) {
			if ( in_array( $listing_status, $value, true ) ) {
				$status     = isset( $value['status'] ) ? $value['status'] : null;
				$bg_color   = isset( $value['bg_color'] ) ? $value['bg_color'] : null;
				$text_color = isset( $value['text_color'] ) ? $value['text_color'] : null;
				$icon       = isset( $value['icon'] ) ? $value['icon'] : null;
			}
		}
	}

	if ( ! $status ) {
		$status     = $listing_status;
		$bg_color   = '#ffffff';
		$text_color = '#444444';
		$icon       = '';
	}

	return array(
		'status'     => $status,
		'bg_color'   => $bg_color,
		'text_color' => $text_color,
		'icon'       => $icon,
	);
}

/**
 * Highlight new.
 */
function veekls_highlight_new() {
	$days = veekls_option( 'highlight_new_days' );

	if ( ! $days ) {
		return;
	}

	$listed_time = get_the_time( 'U' );
	$timestamp   = strtotime( '+' . $days . ' days', $listed_time );

	if ( $timestamp < time() ) {
		return;
	}

	return veekls_option( 'highlight_new_color' );
}

/**
 * Outputs the engine.
 */
function veekls_engine() {
	$cylinders   = veekls_meta( 'model_engine_cyl' ) ? veekls_meta( 'model_engine_cyl' ) . __( ' cylinder ', 'veekls' ) : '';
	$engine_type = veekls_meta( 'model_engine_type' ) ? veekls_meta( 'model_engine_type' ) . ' ' : '';
	$engine_l    = veekls_meta( 'model_engine_l' ) ? veekls_meta( 'model_engine_l' ) : '';

	if ( $cylinders || $engine_type || $engine_l ) {
		$output = $cylinders . $engine_type . $engine_l . 'L';
	} else {
		$output = null;
	}

	return $output;
}

/**
 * Outputs the fuel economy.
 */
function veekls_fuel_economy() {
	if ( veekls_metric() === 'yes' ) {
		$output = veekls_meta( 'model_lkm_mixed' ) ? veekls_meta( 'model_lkm_mixed' ) . __( 'L/km', 'veekls' ) : null;
	} else {
		$output = veekls_meta( 'model_mpg_mixed' ) ? veekls_meta( 'model_mpg_mixed' ) . __( 'mpg', 'veekls' ) : null;
	}

	return $output;
}

/**
 * Outputs the formatted odometer value.
 *
 * @param number $odometer The vehicle data.
 */
function veekls_odometer( $odometer ) {
	if ( ! $odometer ) {
		$output = __( 'n/a', 'veekls' );
	} else {
		$output = number_format_i18n( $odometer ) . ' ' . veekls_api_client_miles_kms_label_short();
	}

	return $output;
}

/**
 * Outputs the transmission.
 */
function veekls_transmission() {
	return veekls_meta( 'model_transmission_type' );
}

/**
 * Outputs the drive type.
 */
function veekls_drive_type() {
	return veekls_meta( 'model_drive' );
}

/**
 * Outputs a body type link.
 */
function veekls_body_type() {
	if ( has_term( '', 'body-type' ) ) {
		return get_the_term_list( get_the_ID(), 'body-type', '', ', ' );
	}
}
