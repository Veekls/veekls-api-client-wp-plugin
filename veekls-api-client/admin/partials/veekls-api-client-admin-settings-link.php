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
<a href="<?php echo esc_url( $href ); ?>">' .
	<?php esc_html_e( 'Settings', 'veekls-api-client' ); ?>
</a>
