<?php
/**
 * Veekls Search Form shortcode.
 *
 * @package veekls-api-client
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( dirname( dirname( __FILE__ ) ) ) . 'includes/functions-formatting.php';
require_once plugin_dir_path( dirname( dirname( __FILE__ ) ) ) . 'includes/functions-general.php';

/**
 * Veekls Search Form shortcode.
 */
class Veekls_Api_Client_Search_Form_Shortcode {
	/**
	 * Get things going
	 */
	public function __construct() {
		add_filter( 'wp', array( $this, 'has_shortcode' ) );

		add_shortcode( 'veekls_api_client_search_form', array( $this, 'search_form' ) );
	}

	/**
	 * Check if we have the shortcode displayed
	 */
	public function has_shortcode() {
		global $post;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'veekls_api_client_search_form' ) ) {
			add_filter( 'is_veekls_api_client', array( $this, 'return_true' ) );
		}
	}

	/**
	 * Returns true.
	 */
	public function return_true() {
		return true;
	}

	/**
	 * Year field setup.
	 */
	public function year_field() {
		$data    = veekls_api_client_search_form_get_vehicle_data();
		$year    = $data['year'];
		$options = array();

		if ( ! $year ) {
			return;
		}

		foreach ( $year as $option ) {
			$options[ $option ] = $option;
		}

		$args = array(
			'name'  => 'min-year',
			'label' => __( 'Min Year', 'veekls' ),
		);

		return $this->select_field( $options, $args );
	}

	/**
	 * Brand field setup.
	 */
	public function brand_field() {
		$data    = veekls_api_client_search_form_get_vehicle_data();
		$brand   = $data['brand'];
		$options = array();

		if ( ! $brand ) {
			return;
		}

		foreach ( $brand as $option ) {
			$options[ $option ] = $option;
		}

		$args = array(
			'name'  => 'brand',
			'label' => __( 'Brand', 'veekls' ),
		);

		return $this->select_field( $options, $args );
	}

	/**
	 * Model field setup.
	 */
	public function model_field() {
		$data    = veekls_api_client_search_form_get_vehicle_data();
		$model   = $data['model'];
		$options = array();

		if ( ! $model ) {
			return;
		}

		foreach ( $model as $option ) {
			$options[ $option ] = $option;
		}

		$args = array(
			'name'  => 'model',
			'label' => __( 'Model', 'veekls' ),
		);

		return $this->select_field( $options, $args );
	}

	/**
	 * Min price field setup.
	 */
	public function min_price_field() {
		$min_max_price = veekls_api_client_search_form_price_min_max();
		$args          = array(
			'name'   => 'min-price',
			'label'  => __( 'price from', 'veekls' ),
			'prefix' => __( 'priced from', 'veekls' ),
		);

		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Max price field setup.
	 */
	public function max_price_field() {
		$min_max_price = veekls_api_client_search_form_price_min_max();
		$args          = array(
			'name'   => 'max-price',
			'label'  => __( 'price to', 'veekls' ),
			'prefix' => __( 'to', 'veekls' ),
		);

		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Body type field setup.
	 */
	public function body_type_field() {
		$body_types = apply_filters( 'veekls_vehicle_types', array() );
		$options    = array();

		if ( $body_types ) {
			foreach ( $body_types as $key => $type ) {
				$options[ $type ] = apply_filters( 'veekls_translate_vehicle_type', $type );
			}
		}

		$args = array(
			'name'  => 'type',
			'label' => __( 'Body Type', 'veekls' ),
		);

		return $this->select_field( $options, $args );
	}

	/**
	 * Odometer field setup.
	 */
	public function odometer_field() {
		$odometer = veekls_api_client_search_form_mileage_max();
		$args     = array(
			'name'  => 'odometer',
			'label' => __( 'Max Mileage', 'veekls' ),
		);

		return $this->select_field( $odometer, $args );
	}

	/**
	 * Build the form.
	 *
	 * @param array $attrs The attributes to build with.
	 */
	public function search_form( $attrs ) {
		$attrs = shortcode_atts(
			array(
				'submit_btn'  => __( 'Find My Car', 'veekls' ),
				'refine_text' => __( 'More Refinements', 'veekls' ),
				'style'       => '1',
				'layout'      => '',
				'exclude'     => array(),
			),
			$attrs
		);

		$exclude = ! empty( $attrs['exclude'] ) ? array_map( 'trim', explode( ',', $attrs['exclude'] ) ) : array();
		$output  = '';

		ob_start();
		?>

		<form
			class="veekls-search s-<?php echo esc_attr( $attrs['style'] ); ?> <?php echo esc_attr( $attrs['layout'] ); ?>"
			action="<?php echo esc_url( wp_make_link_relative( get_permalink( get_option( 'veekls_vehicles_page' ) ) ) ); ?>"
			autocomplete="off"
			id="veekls-search"
			role="search"
			method="GET"
			>

			<?php if ( 'standard' !== $attrs['layout'] ) : ?>
				<?php if ( ! in_array( 'prices', $exclude, true ) ) : ?>
					<div class="row price-wrap">
						<?php if ( ! in_array( 'min-price', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->min_price_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>

						<?php if ( ! in_array( 'max-price', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->max_price_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'refine', $exclude, true ) ) : ?>
					<a class="refine">
						<?php echo esc_html( $attrs['refine_text'] ); ?> <i class="fa fa-angle-down"></i>
					</a>

					<div class="row extras-wrap">
						<?php if ( ! in_array( 'min-year', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->year_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>

						<?php if ( ! in_array( 'brand', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->brand_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>

						<?php if ( ! in_array( 'model', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->model_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>

						<?php if ( ! in_array( 'max-odometer', $exclude, true ) ) : ?>
							<?php echo filter_var( $this->odometer_field(), FILTER_UNSAFE_RAW ); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php if ( ! in_array( 'prices', $exclude, true ) ) : ?>
					<?php if ( ! in_array( 'min-price', $exclude, true ) ) : ?>
						<?php echo filter_var( $this->min_price_field(), FILTER_UNSAFE_RAW ); ?>
					<?php endif; ?>

					<?php if ( ! in_array( 'max-price', $exclude, true ) ) : ?>
						<?php echo filter_var( $this->max_price_field(), FILTER_UNSAFE_RAW ); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ! in_array( 'min-year', $exclude, true ) ) : ?>
					<?php echo filter_var( $this->year_field(), FILTER_UNSAFE_RAW ); ?>
				<?php endif; ?>

				<?php if ( ! in_array( 'brand', $exclude, true ) ) : ?>
					<?php echo filter_var( $this->brand_field(), FILTER_UNSAFE_RAW ); ?>
				<?php endif; ?>

				<?php if ( ! in_array( 'model', $exclude, true ) ) : ?>
					<?php echo filter_var( $this->model_field(), FILTER_UNSAFE_RAW ); ?>
				<?php endif; ?>

				<?php if ( ! in_array( 'max-odometer', $exclude, true ) ) : ?>
					<?php echo filter_var( $this->odometer_field(), FILTER_UNSAFE_RAW ); ?>
				<?php endif; ?>
			<?php endif; ?>

			<div class="submit-wrap">
				<button class="veekls-button" type="submit"><?php echo esc_html( $attrs['submit_btn'] ); ?></button>
			</div>
		</form>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters( 'veekls_api_client_search_form_shortcode_output', $output, $attrs );
	}

	/**
	 * Select field.
	 *
	 * @param array $options the options to display.
	 * @param array $args The arguments to use.
	 */
	public function select_field( $options, $args = array() ) {
		$output = '';
		ob_start();
		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">
			<?php if ( isset( $args['prefix'] ) ) : ?>
				<span class="prefix"><?php echo esc_html( $args['prefix'] ); ?></span>
			<?php endif; ?>

			<select name="<?php echo esc_attr( $args['name'] ); ?>">
				<option value=""><?php echo esc_attr( $args['label'] ); ?></option>

				<?php if ( ! empty( $options ) ) : ?>
					<?php foreach ( $options as $val => $text ) : ?>
						<?php $selected = isset( $_GET[ $args['name'] ] ) && $_GET[ $args['name'] ] === $val ? 'selected' : ''; // phpcs:ignore ?>
						<?php if ( ! empty( $val ) ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php echo esc_attr( $selected ); ?>>
								<?php echo esc_html( $text ); ?>
							</option>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<?php if ( isset( $args['suffix'] ) ) : ?>
				<span class="suffix"><?php echo esc_html( $args['suffix'] ); ?></span>;
			<?php endif; ?>
		</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters( 'veekls_api_client_search_form_field' . $args['name'], $output );
	}

	/**
	 * Multi Select field.
	 *
	 * @param array $options the options to display.
	 * @param array $args The arguments to use.
	 */
	public function multiple_select_field( $options, $args = array() ) {
		$output = '';
		ob_start();
		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">
			<?php if ( isset( $args['prefix'] ) ) : ?>
				<span class="prefix"><?php echo esc_html( $args['prefix'] ); ?></span>
			<?php endif; ?>

			<select multiple="multiple" name="<?php echo esc_attr( $args['name'] ); ?>[]" placeholder="<?php echo esc_attr( $args['label'] ); ?>">
				<?php if ( ! empty( $options ) ) : ?>
					<?php foreach ( $options as $val => $text ) : ?>
						<?php $selected = isset( $_GET[ $args['name'] ] ) && in_array( $val, $_GET[ $args['name'] ], true ) ? 'selected' : ''; // phpcs:ignore ?>
						<?php if ( ! empty( $val ) ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php echo esc_attr( $selected ); ?>>
								<?php echo esc_html( $text ); ?>
							</option>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<?php if ( isset( $args['suffix'] ) ) : ?>
				<span class="suffix"><?php echo esc_html( $args['suffix'] ); ?></span>
			<?php endif; ?>
		</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters( 'veekls_api_client_multiple_search_field' . $args['name'], $output );
	}
}

return new Veekls_api_client_Search_Form_Shortcode();
