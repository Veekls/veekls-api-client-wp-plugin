<?php
/**
 * Veekls search form shortcode.
 *
 * @package Veekls_API_Client.
 */

/**
 * Class Veekls_API_Client_Search_Form_Shortcode
 */
class Veekls_API_Client_Search_Form_Shortcode {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter(
			'query_vars',
			array( $this, 'register_query_vars' )
		);

		add_shortcode(
			'veekls_api_client_search_form',
			array( $this, 'search_form' )
		);
	}

	/**
	 * Register query vars.
	 *
	 * @param array $vars query vars.
	 */
	public function register_query_vars( $vars ) {
		$vars[] = 'year';
		$vars[] = 'brand';
		$vars[] = 'model';
		$vars[] = 'condition';
		$vars[] = 'min_price';
		$vars[] = 'max_price';
		$vars[] = 'body_type';
		$vars[] = 'odometer';
		$vars[] = 'within';

		return apply_filters( 'veekls_api_client_query_vars', $vars );
	}

	/**
	 * Search Form shortcode.
	 *
	 * @param array $atts shortcode attributes.
	 */
	public function search_form( $atts ) {
		$s = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

		$atts = shortcode_atts(
			array(
				'area_placeholder' => __( 'State, Zip, Town', 'veekls-api-client' ),
				'refine_text'      => __( 'More Refinements', 'veekls-api-client' ),
				'submit_btn'       => __( 'Find My Car', 'veekls-api-client' ),
				'exclude'          => array(),
				'style'            => '1',
				'layout'           => '',
			),
			$atts
		);

		$exclude = ! empty( $atts['exclude'] )
			? array_map( 'trim', explode( ',', $atts['exclude'] ) )
			: array();

		ob_start();

		$class_list = $atts['style'] . ' ' . $atts['layout'];
		?>

		<form
			id="veekls-api-client-search" class="veekls-api-client-search s-<?php echo esc_attr( $class_list ); ?>"
			action="<?php the_permalink( get_option( 'veekls_api_client_archives_page' ) ); ?>"
			autocomplete="off"
			method="GET"
			role="search"
			>

			<?php if ( 'standard' !== $atts['layout'] ) : ?>
				<?php if ( ! in_array( 'condition', $exclude, true ) ) : ?>
					<div class="row condition-wrap">
						<?php echo $this->condition_field(); // phpcs:ignore ?>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'prices', $exclude, true ) ) : ?>
					<div class="row price-wrap">
						<?php
						if ( ! in_array( 'min_price', $exclude, true ) ) {
							echo $this->min_price_field(); // phpcs:ignore
						}

						if ( ! in_array( 'max_price', $exclude, true ) ) {
							echo $this->max_price_field(); // phpcs:ignore
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'refine', $exclude, true ) ) : ?>
					<a class="refine">
						<?php echo esc_html( $atts['refine_text'] ); ?>
						<i class="fa fa-angle-down"></i>
					</a>

					<div class="row extras-wrap">
						<?php
						if ( ! in_array( 'year', $exclude, true ) ) {
							echo $this->year_field(); // phpcs:ignore
						}

						if ( ! in_array( 'brand', $exclude, true ) ) {
							echo $this->brand_field(); // phpcs:ignore
						}

						if ( ! in_array( 'model', $exclude, true ) ) {
							echo $this->model_field(); // phpcs:ignore
						}

						if ( ! in_array( 'body_type', $exclude, true ) ) {
							echo $this->body_type_field(); // phpcs:ignore
						}

						if ( ! in_array( 'odometer', $exclude, true ) ) {
							echo $this->odometer_field(); // phpcs:ignore
						}

						// do_action( 'veekls_api_client_extra_search_fields', $exclude );
						?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php
				if ( ! in_array( 'condition', $exclude, true ) ) {
					echo $this->condition_field(); // phpcs:ignore
				}

				if ( ! in_array( 'prices', $exclude, true ) ) {
					if ( ! in_array( 'min_price', $exclude, true ) ) {
						echo $this->min_price_field(); // phpcs:ignore
					}

					if ( ! in_array( 'max_price', $exclude, true ) ) {
						echo $this->max_price_field(); // phpcs:ignore
					}
				}

				if ( ! in_array( 'year', $exclude, true ) ) {
					echo $this->year_field(); // phpcs:ignore
				}

				if ( ! in_array( 'brand', $exclude, true ) ) {
					echo $this->brand_field(); // phpcs:ignore
				}

				if ( ! in_array( 'model', $exclude, true ) ) {
					echo $this->model_field(); // phpcs:ignore
				}

				if ( ! in_array( 'body_type', $exclude, true ) ) {
					echo $this->body_type_field(); // phpcs:ignore
				}

				if ( ! in_array( 'odometer', $exclude, true ) ) {
					echo $this->odometer_field(); // phpcs:ignore
				}
				?>

				<input type="hidden" name="s" value="<?php echo esc_attr( $s ); ?>"/>

				<button class="al-button" type="submit">
					<?php echo esc_html( $atts['submit_btn'] ); ?>
				</button>
			<?php endif; ?>
		</form>

		<?php
		$output = ob_get_clean();

		return $output;

		// return apply_filters( 'veekls_api_client_search_form_form_output', $output, $atts );
	}

	/**
	 * Year field
	 */
	public function year_field() {
		$data    = array( 'year' => array( 2011, 2012 ) );
		$year    = $data['year'];
		$options = array();

		if ( ! $year ) {
			return '';
		}

		foreach ( $year as $n ) {
			$options[ $n ] = $n;
		}

		$args = array(
			'name'  => 'year',
			'label' => __( 'Year', 'veekls-api-client' ),
		);

		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Make field
	 */
	public function brand_field() {
		$data = array(
			'model' => array(
				'1',
				'2',
				'3',
			),
		);

		$brand   = $data['brand'];
		$options = array();

		if ( ! $brand ) {
			return '';
		}

		foreach ( $brand as $n ) {
			$options[ $n ] = $n;
		}

		$args = array(
			'name'  => 'brand',
			'label' => __( 'Make', 'veekls-api-client' ),
		);

		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Model field
	 */
	public function model_field() {
		$data = array(
			'model' => array(
				'1',
				'2',
				'3',
			),
		);

		$model   = $data['model'];
		$options = array();

		if ( ! $model ) {
			return '';
		}

		foreach ( $model as $n ) {
			$options[ $n ] = $n;
		}

		$args = array(
			'name'  => 'model',
			'label' => __( 'Model', 'veekls-api-client' ),
		);

		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Condition field
	 */
	public function condition_field() {
		$conditions = get_option( 'veekls_api_client_display_condition' );
		$options    = array();

		if ( ! $conditions ) {
			return '';
		}

		foreach ( $conditions as $n ) {
			$options[ $n ] = $n;
		}

		$args = array(
			'name'   => 'condition',
			'label'  => __( 'condition', 'veekls-api-client' ),
			'prefix' => __( 'I\'m looking for ', 'veekls-api-client' ),
		);

		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Min price field
	 */
	public function min_price_field() {
		$min_max_price = array(
			array(
				'val'  => 20000,
				'text' => 20000,
			),
		);

		$args = array(
			'name'   => 'min_price',
			'label'  => __( 'min', 'veekls-api-client' ),
			'prefix' => __( 'priced from', 'veekls-api-client' ),
		);

		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Max price field
	 */
	public function max_price_field() {
		$min_max_price = array(
			array(
				'val'  => 20000,
				'text' => 20000,
			),
		);

		$args = array(
			'name'   => 'max_price',
			'label'  => __( 'max', 'veekls-api-client' ),
			'prefix' => __( 'to', 'veekls-api-client' ),
		);

		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Body type field
	 */
	public function body_type_field() {
		$body_types = array(
			array(
				'slug' => 'vehicle',
				'name' => 'Vehicle',
			),
			array(
				'slug' => 'truck',
				'name' => 'Truck',
			),
			array(
				'slug' => 'nautical',
				'name' => 'Nautical',
			),
			array(
				'slug' => 'motorcycle',
				'name' => 'Motorcycle',
			),
		);

			$options = array();

		if ( $body_types ) {
			foreach ( $body_types as $type ) {
				$options[ $type->slug ] = $type->name;
			}
		}

		$args = array(
			'name'  => 'body_type',
			'label' => __( 'Body Type', 'veekls-api-client' ),
		);

		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Odometer field
	 */
	public function odometer_field() {
		$odometer = array(
			array(
				10000,
				20000,
				30000,
				40000,
			),
		);

		$args = array(
			'name'  => 'odometer',
			'label' => __( 'Max Mileage', 'veekls-api-client' ),
		);

		return $this->select_field( $odometer, $args );
	}

	/**
	 * Select field
	 *
	 * @param array $options Field options.
	 * @param array $args Field arguments.
	 */
	public function select_field( $options, $args = array() ) {
		if ( empty( $options ) ) {
			return '';
		}

		$selected = isset( $_GET[ $args['name'] ] ) ? $_GET[ $args['name'] ] : '';

		ob_start();
		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">
			<?php if ( isset( $args['prefix'] ) ) : ?>
				<span class="prefix">
					<?php echo esc_html( $args['prefix'] ); ?>
				</span>
			<?php endif; ?>

			<select
				placeholder="<?php echo esc_attr( $args['label'] ); ?>"
				name="<?php echo esc_attr( $args['name'] ); ?>"
				>

				<option value="">
					<?php echo esc_attr( $args['label'] ); ?>
				</option>

				<?php foreach ( $options as $val => $text ) : ?>
					<option
						value="<?php echo esc_attr( $val ); ?>"
						<?php selected( $val, $selected ); ?>
						>

						<?php echo esc_attr( $text ); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<?php
			if ( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			}
			?>
		</div>

		<?php
		$output = ob_get_clean();

		// return apply_filters( 'veekls_api_client_search_form_field' . $args['name'], $output );

		return $output;
	}

	/**
	 * Multiple select field
	 *
	 * @param array $options Field options.
	 * @param array $args Field arguments.
	 */
	public function multiple_select_field( $options, $args = array() ) {
		if ( empty( $options ) ) {
			return '';
		}

		ob_start();

		$selected = isset( $_GET[ $args['name'] ] ) ? $_GET[ $args['name'] ] : array();
		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">
			<?php if ( isset( $args['prefix'] ) ) : ?>
				<span class="prefix">
					<?php echo esc_html( $args['prefix'] ); ?>
				</span>
			<?php endif; ?>

			<?php // Condition field. If we only have 1 condition, remove the select option. ?>
			<?php if ( 'condition' === $args['name'] && count( $options ) <= 1 ) : ?>
				<input
					value="<?php echo esc_html( key( $options ) ); ?>"
					name="condition[]"
					type="hidden"
					/>
			<?php else : ?>
				<select
					placeholder="<?php echo esc_attr( $args['label'] ); ?>"
					name="<?php echo esc_attr( $args['name'] ); ?>[]"
					multiple="multiple"
					>
					<?php foreach ( $options as $val => $text ) : ?>
						<option
							<?php selected( true, in_array( strval( $val ), $selected, true ) ); ?>
							value="<?php echo esc_attr( $val ); ?>"
							>

							<?php echo esc_attr( $text ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>

			<?php
			if ( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			}
			?>
		</div>

		<?php
		$output = ob_get_clean();

		return $output;
		// return apply_filters( 'veekls_api_client_multiple_search_field' . $args['name'], $output );
	}
}
