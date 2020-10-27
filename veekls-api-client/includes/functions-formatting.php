<?php
/**
 * Formatting functions.
 *
 * @package veekls-api-client
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Metric and imperial formatting.
 */
function veekls_api_client_metric() {
	return veekls_api_client_option( 'metric' ) ? veekls_api_client_option( 'metric' ) : 'yes';
}

/**
 * Miles or Kilometers label.
 */
function veekls_api_client_miles_kms_label() {
	return veekls_api_client_metric() === 'no' ? __( 'Miles', 'auto-listings' ) : __( 'Kilometers', 'auto-listings' );
}

/**
 * Miles or Kilometers short label.
 */
function veekls_api_client_miles_kms_label_short() {
	return veekls_api_client_metric() === 'no' ? __( 'mi', 'auto-listings' ) : __( 'km', 'auto-listings' );
}

/**
 * Miles ir Kilometers per hour label.
 */
function veekls_api_client_per_hour_unit() {
	return veekls_api_client_metric() === 'yes' ? __( 'mph', 'auto-listings' ) : __( 'kph', 'auto-listings' );
}

/**
 * Run date formatting through here.
 *
 * @param string $date The date string.
 */
function veekls_api_client_format_date( $date ) {
	$timestamp = strtotime( $date );
	$date      = date_i18n( get_option( 'date_format' ), $timestamp, false );

	return apply_filters( 'veekls_api_client_format_date', $date, $timestamp );
}

/**
 * Whether to include decimals
 *
 * @return string
 */
function veekls_api_client_include_decimals() {
	$option = get_option( 'veekls_api_client_options' );
	$return = isset( $option['include_decimals'] ) ? stripslashes( $option['include_decimals'] ) : 'no';

	return $return;
}

/**
 * Get the price format depending on the currency position.
 *
 * @return string
 */
function veekls_api_client_format_price_format() {
	$option       = get_option( 'veekls_api_client_options' );
	$currency_pos = isset( $option['currency_position'] ) ? $option['currency_position'] : 'left';
	$format       = '%1$s%2$s';

	switch ( $currency_pos ) {
		case 'left':
			$format = '%1$s%2$s';
			break;
		case 'right':
			$format = '%2$s%1$s';
			break;
		case 'left_space':
			$format = '%1$s&nbsp;%2$s';
			break;
		case 'right_space':
			$format = '%2$s&nbsp;%1$s';
			break;
	}

	return apply_filters( 'veekls_api_client_format_price_format', $format, $currency_pos );
}

/**
 * Return the currency_symbol for prices.
 *
 * @return string
 */
function veekls_api_client_currency_symbol() {
	$option = get_option( 'veekls_api_client_options' );
	$return = isset( $option['currency_symbol'] ) ? stripslashes( $option['currency_symbol'] ) : '$';

	return $return;
}

/**
 * Return the thousand separator for prices.
 *
 * @return string
 */
function veekls_api_client_thousand_separator() {
	$option = get_option( 'veekls_api_client_options' );
	$return = isset( $option['thousand_separator'] ) ? stripslashes( $option['thousand_separator'] ) : ',';

	return $return;
}

/**
 * Return the decimal separator for prices.
 *
 * @return string
 */
function veekls_api_client_decimal_separator() {
	$option = get_option( 'veekls_api_client_options' );
	$return = isset( $option['decimal_separator'] ) ? stripslashes( $option['decimal_separator'] ) : '.';

	return $return;
}

/**
 * Return the number of decimals after the decimal point.
 *
 * @return int
 */
function veekls_api_client_decimals() {
	$option = get_option( 'veekls_api_client_options' );
	$return = isset( $option['decimals'] ) ? $option['decimals'] : 2;

	return absint( $return );
}

/**
 * Trim trailing zeros off prices.
 *
 * @param mixed $price The price to trim.
 *
 * @return string
 */
function veekls_api_client_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( veekls_api_client_decimal_separator(), '/' ) . '0++$/', '', $price );
}

/**
 * Format the price with a currency symbol.
 *
 * @param float $price The price value.
 * @param array $args (default: array()) The arguments.
 *
 * @return string
 */
function veekls_api_client_format_price( $price, $args = array() ) {
	$price_args = apply_filters(
		'veekls_api_client_format_price_args',
		wp_parse_args(
			$args,
			array(
				'currency_symbol'    => veekls_api_client_currency_symbol(),
				'decimal_separator'  => veekls_api_client_decimal_separator(),
				'thousand_separator' => veekls_api_client_thousand_separator(),
				'decimals'           => veekls_api_client_decimals(),
				'price_format'       => veekls_api_client_format_price_format(),
				'include_decimals'   => veekls_api_client_include_decimals(),
			)
		)
	);

	$currency_symbol    = $price_args['currency_symbol'];
	$decimal_separator  = $price_args['decimal_separator'];
	$thousand_separator = $price_args['thousand_separator'];
	$decimals           = $price_args['decimals'];
	$price_format       = $price_args['price_format'];
	$include_decimals   = $price_args['include_decimals'];

	$return = null;

	$negative = $price < 0;
	$price    = apply_filters( 'veekls_api_client_raw_price', floatval( $negative ? $price * -1 : $price ) );
	$price    = apply_filters(
		'veekls_api_client_formatted_price',
		number_format(
			$price,
			$decimals,
			$decimal_separator,
			$thousand_separator
		),
		$price,
		$decimals,
		$decimal_separator,
		$thousand_separator
	);

	if ( 'no' === $include_decimals ) {
		$price = veekls_api_client_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf(
		$price_format,
		'<span class="currency-symbol">' . $currency_symbol . '</span>',
		$price
	);

	$return = '<span class="price-amount">' . $formatted_price . '</span>';

	return apply_filters( 'veekls_api_client_format_price', $return, $price, $args );
}

/**
 * Format the price with a currency symbol.
 *
 * @param float $price The price value.
 *
 * @return string
 */
function veekls_api_client_raw_price( $price ) {
	return wp_strip_all_tags( veekls_api_client_format_price( $price ) );
}
