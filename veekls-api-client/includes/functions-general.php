<?php
/**
 * General functions.
 *
 * @package veekls-api-client
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the id af any item (used only to localize address for shortcodes)
 */
function veekls_api_client_get_id() {
	$post_id = null;

	if ( ! $post_id ) {
		$post_id = veekls_api_client_shortcode_att( 'id', 'veekls_api_client_listing' );
	}

	if ( ! $post_id ) {
		$post_id = veekls_api_client_shortcode_att( 'id', 'veekls_api_client_seller' );
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return $post_id;
}

/**
 * Return an attribute value from any shortcode.
 *
 * @param string $attribute The attribute name.
 * @param array  $shortcode The shortcode.
 */
function veekls_api_client_shortcode_att( $attribute, $shortcode ) {
	global $post;

	if ( ! $post ) {
		return;
	}

	if ( ! $attribute && ! $shortcode ) {
		return;
	}

	if ( has_shortcode( $post->post_content, $shortcode ) ) {
		$pattern = get_shortcode_regex();
		$exists  = preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( $shortcode, $matches[2], true );

		if ( $exists ) {
			$key = array_search( $shortcode, $matches[2], true );

			if ( $matches[3][ $key ] ) {
				$att = str_replace( $attribute . '="', '', trim( $matches[3][ $key ] ) );
				$att = str_replace( '"', '', $att );

				if ( isset( $att ) ) {
					return $att;
				}
			}
		}
	}
}

/**
 * Get the meta af any item
 *
 * @param string $meta The meta value.
 * @param int    $post_id The post ID.
 */
function veekls_api_client_meta( $meta, $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$meta_key = '_al_listing_' . $meta;
	$data     = get_post_meta( $post_id, $meta_key, true );

	return $data;
}

/**
 * Get any option.
 *
 * @param string $option The option to get.
 */
function veekls_api_client_option( $option ) {
	$options = get_option( 'veekls_api_client_options' );

	return isset( $options[ $option ] ) ? $options[ $option ] : false;
}

/**
 * Get the columns
 */
function veekls_api_client_columns() {
	$columns = veekls_api_client_option( 'grid_columns' );

	return $columns ? $columns : '3';
}

/**
 * Are we hiding an item.
 *
 * @param string $item The item to check for.
 */
function veekls_api_client_hide_item( $item ) {
	$hide = veekls_api_client_meta( 'hide' );

	if ( ! $hide ) {
		return false;
	}

	return in_array( $item, $hide, true );
}

add_action( 'init', 'veekls_api_client_add_new_image_sizes', 11 );

/**
 * Add thumbnail sizes.
 */
function veekls_api_client_add_new_image_sizes() {
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'al-lge', 1200, 750, array( 'center', 'center' ) );
	add_image_size( 'al-sml', 400, 250, array( 'center', 'center' ) );
}

/**
 * Build Google maps URL.
 *
 * @param string $query_var The query variables.
 */
function veekls_api_client_google_maps_url( $query_var = null ) {
	$api_url = 'https://maps.googleapis.com/maps/api/js?v=3.exp';
	$key     = veekls_api_client_option( 'maps_api_key' );

	if ( empty( $key ) ) {
		return;
	}

	$api_url = $api_url . '&key=' . $key;

	if ( ! empty( $query_var ) ) {
		$api_url = $api_url . $query_var;
	}

	return $api_url;
}

/**
 * Build Google maps Geocode URL.
 *
 * @param string $address The address to find.
 */
function veekls_api_client_google_geocode_maps_url( $address ) {
	$api_url = 'https://maps.google.com/maps/api/geocode/json?address=' . rawurlencode( $address );
	$key     = veekls_api_client_option( 'maps_api_key' );
	$country = veekls_api_client_search_form_country();

	if ( ! empty( $key ) ) {
		$api_url = $api_url . '&key=' . rawurlencode( $key );
	}

	if ( ! empty( $country ) ) {
		$api_url = $api_url . '&components=country:' . rawurlencode( $country );
	}

	return apply_filters( 'veekls_api_client_google_geocode_maps_url', $api_url );
}

/**
 * Map height.
 */
function veekls_api_client_map_height() {
	$height = veekls_api_client_option( 'map_height' ) ? veekls_api_client_option( 'map_height' ) : '300';

	return apply_filters( 'veekls_api_client_map_height', $height );
}

/**
 * Get search country.
 */
function veekls_api_client_search_form_country() {
	$country = veekls_api_client_option( 'search_country' ) ? veekls_api_client_option( 'search_country' ) : '';

	return apply_filters( 'veekls_api_client_search_form_country', $country );
}

/**
 * Get price min max search values
 */
function veekls_api_client_search_form_price_min_max() {
	$options = apply_filters(
		'veekls_api_client_search_form_price_min_max',
		array(
			'3000'   => veekls_api_client_raw_price( '3000' ),
			'5000'   => veekls_api_client_raw_price( '5000' ),
			'10000'  => veekls_api_client_raw_price( '10000' ),
			'15000'  => veekls_api_client_raw_price( '15000' ),
			'20000'  => veekls_api_client_raw_price( '20000' ),
			'25000'  => veekls_api_client_raw_price( '25000' ),
			'30000'  => veekls_api_client_raw_price( '30000' ),
			'35000'  => veekls_api_client_raw_price( '35000' ),
			'40000'  => veekls_api_client_raw_price( '40000' ),
			'45000'  => veekls_api_client_raw_price( '45000' ),
			'50000'  => veekls_api_client_raw_price( '50000' ),
			'60000'  => veekls_api_client_raw_price( '60000' ),
			'80000'  => veekls_api_client_raw_price( '80000' ),
			'100000' => veekls_api_client_raw_price( '100000' ),
			'125000' => veekls_api_client_raw_price( '125000' ),
			'150000' => veekls_api_client_raw_price( '150000' ),
		)
	);

	return $options;
}

/**
 * Get max search mileage.
 */
function veekls_api_client_search_form_mileage_max() {
	$miles_kms = veekls_api_client_miles_kms_label_short();
	$numbers   = array(
		'10000',
		'20000',
		'30000',
		'40000',
		'50000',
		'75000',
		'100000',
		'150000',
		'200000',
	);

	foreach ( $numbers as $val ) {
		// translators: Odometer (mileage) filters.
		$options[ $val ] = sprintf( __( '%1$1s %2$2s or less', 'auto-listings' ), number_format_i18n( $val ), strtolower( $miles_kms ) );
	}

	return apply_filters( 'veekls_api_client_search_form_mileage_max', $options );
}

/**
 * Get vehicles in the database to populate search fields.
 */
function veekls_api_client_search_form_get_vehicle_data() {
	$items = apply_filters( 'veekls_api_client_search_form_get_vehicle_data_args', array() );

	$data = array();

	if ( $items ) {
		foreach ( $items as $item ) {
			$data['year'][]  = $item->year;
			$data['brand'][] = $item->brand;
			$data['model'][] = $item->model;
		}
	}

	foreach ( $data as $key => $value ) {
		$data[ $key ] = array_filter( $data[ $key ] );
		$data[ $key ] = array_unique( $data[ $key ] );
	}

	return $data;
}
