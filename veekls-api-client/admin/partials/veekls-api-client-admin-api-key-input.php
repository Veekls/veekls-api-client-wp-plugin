<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/veekls/veekls-api-client-wp/
 * @since      1.0.0
 *
 * @package    Veekls_API_Client
 * @subpackage Veekls_API_Client/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<input
	placeholder="Paste your Veekls API Key here..."
	value="<?php echo esc_html( $value ); ?>"
	name="veekls_api_client_key"
	id="veekls_api_client_key"
	class="regular-text"
	maxlength="100"
	minlength="20"
	type="text"
	required
/>
