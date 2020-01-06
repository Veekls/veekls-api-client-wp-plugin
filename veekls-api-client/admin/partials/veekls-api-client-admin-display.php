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
<div class="wrap">
	<h2>Veekls API Client Settings</h2>

	<?php if ( $updated ) : ?>
	<div class="notice notice-success is-dismissible">
		<p>Your Veekls API Client settings have been updated!</p>
	</div>
	<?php endif; ?>

	<form method="post" action="options.php">
		<?php
		settings_fields( $this->settings_group );
		do_settings_sections( $this->settings_page_slug );
		submit_button();
		?>
	</form>
</div>
