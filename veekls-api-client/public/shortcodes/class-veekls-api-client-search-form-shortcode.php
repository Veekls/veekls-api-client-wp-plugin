<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

include_once plugin_dir_path(dirname(dirname(__FILE__))) . 'includes/functions-formatting.php';
include_once plugin_dir_path(dirname(dirname(__FILE__))) . 'includes/functions-general.php';

class Veekls_Api_Client_Search_Form_Shortcode
{
    /**
     * Get things going
     *
     */
    public function __construct()
    {
        add_filter('wp', array($this, 'has_shortcode'));
        add_filter('query_vars', array($this, 'register_query_vars'));

        add_shortcode('veekls_api_client_search_form', array($this, 'search_form'));
    }

    /**
     * Check if we have the shortcode displayed
     */
    public function has_shortcode()
    {
        global $post;

        if (is_a($post, 'WP_Post') &&
            has_shortcode($post->post_content, 'veekls_api_client_search_form')) {
            add_filter('is_veekls_api_client', array($this, 'return_true'));
        }
    }

    public function return_true()
    {
        return true;
    }

    /**
     * Register custom query vars, based on our registered fields
     *
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
     */
    public function register_query_vars($vars)
    {
        $vars[] = 'year';
        $vars[] = 'brand';
        $vars[] = 'model';
        $vars[] = 'min_price';
        $vars[] = 'max_price';
        $vars[] = 'body_type';
        $vars[] = 'odometer';

        return $vars;
    }

    /*
     * year field setup
     */
    public function year_field()
    {
        $data = veekls_api_client_search_form_get_vehicle_data();
        $year = $data['year'];
        $options = array();

        if (!$year) {
            return;
        }

        foreach ($year as $n) {
            $options[$n] = $n;
        }

        $args = array(
            'name' => 'year',
            'label' => __('Year', 'veekls-api-client'),
        );

        return $this->multiple_select_field($options, $args);
    }

    /*
     * brand field setup
     */
    public function brand_field()
    {
        $data = veekls_api_client_search_form_get_vehicle_data();
        $brand = $data['brand'];
        $options = array();

        if (!$brand) {
            return;
        }

        foreach ($brand as $n) {
            $options[$n] = $n;
        }

        $args = array(
            'name' => 'brand',
            'label' => __('Brand', 'veekls-api-client'),
        );

        return $this->multiple_select_field($options, $args);
    }

    /*
     * model field setup
     */
    public function model_field()
    {
        $data = veekls_api_client_search_form_get_vehicle_data();
        $model = $data['model'];
        $options = array();

        if (!$model) {
            return;
        }

        foreach ($model as $n) {
            $options[$n] = $n;
        }

        $args = array(
            'name' => 'model',
            'label' => __('Model', 'veekls-api-client'),
        );

        return $this->multiple_select_field($options, $args);
    }

    /*
     * Min price field setup
     */
    public function min_price_field()
    {
        $min_max_price = veekls_api_client_search_form_price_min_max();
        $args = array(
            'name' => 'min_price',
            'label' => __('price from', 'veekls-api-client'),
            'prefix' => __('priced from', 'veekls-api-client'),
        );

        return $this->select_field($min_max_price, $args);
    }

    /*
     * Max price field setup
     */
    public function max_price_field()
    {
        $min_max_price = veekls_api_client_search_form_price_min_max();
        $args = array(
            'name' => 'max_price',
            'label' => __('price to', 'veekls-api-client'),
            'prefix' => __('to', 'veekls-api-client'),
        );

        return $this->select_field($min_max_price, $args);
    }

    /*
     * Within field setup
     */
    public function within_field()
    {
        $key = veekls_api_client_option('maps_api_key');

        if (empty($key)) {
            return;
        }

        $radius = veekls_api_client_search_form_within_radius();
        $args = array(
            'name' => 'within',
            'label' => __('within', 'veekls-api-client'),
        );

        return $this->select_field($radius, $args);
    }

    /*
     * Body type field setup
     */
    public function body_type_field()
    {
        $body_types = apply_filters('veekls_vehicle_types', array());
        $options = array();

        if ($body_types) {
            foreach ($body_types as $key => $type) {
                $options[$type] = apply_filters('veekls_translate_vehicle_type', $type);
            }
        }

        $args = array(
            'name' => 'body_type',
            'label' => __('Body Type', 'veekls-api-client'),
        );

        return $this->multiple_select_field($options, $args);
    }

    /*
     * Odometer field setup
     */
    public function odometer_field()
    {
        $odometer = veekls_api_client_search_form_mileage_max();
        $args = array(
            'name' => 'odometer',
            'label' => __('Max Mileage', 'veekls-api-client'),
        );

        return $this->select_field($odometer, $args);
    }

    /**
     * Build the form
     *
     */
    public function search_form($atts)
    {
        $s = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

        $atts = shortcode_atts(array(
            'submit_btn' => __('Find My Car', 'veekls-api-client'),
            'refine_text' => __('More Refinements', 'veekls-api-client'),
            'style' => '1',
            'layout' => '',
            'exclude' => array(),
        ), $atts);

        $exclude = !empty($atts['exclude']) ? array_map('trim', explode(',', $atts['exclude'])) : array();

        $output = '';

        ob_start();

        ?>
		<form
			id="veekls-api-client-search"
			class="veekls-api-client-search s-<?php echo esc_attr($atts['style']); ?> <?php echo esc_attr($atts['layout']); ?>" autocomplete="off"
			action="<?php echo esc_url(get_permalink(veekls_api_client_option('archives_page'))) ?>"
			method="GET"
			role="search"
			>

			<?php if ($atts['layout'] != 'standard'): ?>
				<?php if (!in_array('prices', $exclude)): ?>
					<div class="row price-wrap">
						<?php if (!in_array('min_price', $exclude)): ?>
            				<?php echo $this->min_price_field(); ?>
						<?php endif;?>

						<?php if (!in_array('max_price', $exclude)): ?>
							<?php echo $this->max_price_field(); ?>
						<?php endif;?>
					</div>
				<?php endif;?>

				<div class="row area-wrap">
					<button class="al-button" type="submit"><?php echo esc_html($atts['submit_btn']); ?></button>
				</div>

				<?php if (!in_array('refine', $exclude)): ?>
					<a class="refine"><?php echo esc_html($atts['refine_text']) ?> <i class="fa fa-angle-down"></i></a>

					<div class="row extras-wrap">
						<?php if (!in_array('year', $exclude)): ?>
							<?php echo $this->year_field(); ?>
						<?php endif;?>

						<?php if (!in_array('brand', $exclude)): ?>
							<?php echo $this->brand_field(); ?>
						<?php endif;?>

						<?php if (!in_array('model', $exclude)): ?>
							<?php echo $this->model_field(); ?>
						<?php endif;?>

						<?php if (!in_array('body_type', $exclude)): ?>
							<?php echo $this->body_type_field(); ?>
						<?php endif;?>

						<?php if (!in_array('odometer', $exclude)): ?>
							<?php echo $this->odometer_field(); ?>
						<?php endif;?>
					</div>
				<?php endif;?>
			<?php else: ?>
				<?php if (!in_array('prices', $exclude)): ?>
					<?php if (!in_array('min_price', $exclude)): ?>
						<?php echo $this->min_price_field(); ?>
					<?php endif;?>

					<?php if (!in_array('max_price', $exclude)): ?>
						<?php echo $this->max_price_field(); ?>
					<?php endif;?>
				<?php endif;?>

				<?php if (!in_array('year', $exclude)): ?>
					<?php echo $this->year_field(); ?>
				<?php endif;?>

				<?php if (!in_array('brand', $exclude)): ?>
					<?php echo $this->brand_field(); ?>
				<?php endif;?>

				<?php if (!in_array('model', $exclude)): ?>
					<?php echo $this->model_field(); ?>
				<?php endif;?>

				<?php if (!in_array('body_type', $exclude)): ?>
					<?php echo $this->body_type_field(); ?>
				<?php endif;?>

				<?php if (!in_array('odometer', $exclude)): ?>
					<?php echo $this->odometer_field(); ?>
				<?php endif;?>

				<button class="al-button" type="submit"><?php echo esc_html($atts['submit_btn']); ?></button>
			<?php endif;?>
		</form>
		<?php

        $output = ob_get_contents();
        ob_end_clean();

        return apply_filters('veekls_api_client_search_form_shortcode_output', $output, $atts);
    }

    /*
     * Select field
     */
    public function select_field($options, $args = array())
    {
        $output = '';
        ob_start();

        ?>
		<div class="field <?php echo esc_attr(str_replace('_', '-', $args['name'])); ?>">
			<?php if (isset($args['prefix'])): ?>
            	<span class="prefix"><?php echo esc_html($args['prefix']); ?></span>
			<?php endif;?>

			<select name="<?php echo esc_attr($args['name']); ?>">
				<option value=""><?php echo esc_attr($args['label']) ?></option>

				<?php if (!empty($options)): ?>
            		<?php foreach ($options as $val => $text): ?>
                		<?php $selected = isset($_GET[$args['name']]) && $_GET[$args['name']] == $val ? ' selected="selected"' : '';?>
						<?php if (!empty($val)): ?>
							<option value="<?php echo esc_attr($val); ?>" <?php echo esc_attr($selected); ?> ><?php echo esc_attr($text); ?></option>
						<?php endif;?>
					<?php endforeach;?>
				<?php endif;?>

			</select>

			<?php if (isset($args['suffix'])): ?>
            	<span class="suffix"><?php echo esc_html($args['suffix']); ?></span>;
        	<?php endif;?>
		</div>
		<?php

        $output = ob_get_contents();
        ob_end_clean();

        return apply_filters('veekls_api_client_search_form_field' . $args['name'], $output);
    }

    /*
     * Multi Select field
     */
    public function multiple_select_field($options, $args = array())
    {
        $output = '';
        ob_start();

        ?>
		<div class="field <?php echo esc_attr(str_replace('_', '-', $args['name'])); ?>">
			<?php if (isset($args['prefix'])): ?>
            	<span class="prefix"><?php echo esc_html($args['prefix']); ?></span>
			<?php endif;?>

			<select multiple="multiple" name="<?php echo esc_attr($args['name']); ?>[]" placeholder="<?php echo esc_attr($args['label']) ?>">
				<?php if (!empty($options)): ?>
					<?php foreach ($options as $val => $text): ?>
						<?php $selected = isset($_GET[$args['name']]) && in_array($val, $_GET[$args['name']]) == $val ? ' selected="selected"' : '';?>
						<?php if (!empty($val)): ?>
							<option value="<?php echo esc_attr($val); ?>" <?php echo esc_attr($selected); ?> ><?php echo esc_attr($text) ?></option>
						<?php endif;?>
					<?php endforeach;?>
				<?php endif;?>
			</select>

			<?php if (isset($args['suffix'])): ?>
            	<span class="suffix"><?php echo esc_html($args['suffix']); ?></span>
			<?php endif;?>
		</div>
		<?php

        $output = ob_get_contents();
        ob_end_clean();

        return apply_filters('veekls_api_client_multiple_search_field' . $args['name'], $output);
    }
}

return new Veekls_api_client_Search_Form_Shortcode();
