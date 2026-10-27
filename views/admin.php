<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should
 * provide the user interface to the end user.
 *
 * @package   customify
 * @author    Pixelgrade <contact@pixelgrade.com>
 * @license   GPL-2.0+
 * @link      http://pixelgrade.com
 * @copyright 2013 Pixel Grade Media
 */

$config = include pixreviews::pluginpath() . 'plugin-config' . EXT;

// invoke processor
$processor = pixreviews::processor( $config );
$status    = $processor->status();
$errors    = $processor->errors(); ?>

<div class="wrap" id="pixreviews_form">

	<div id="icon-options-general" class="icon32"><br></div>

	<h2><?php esc_html_e( 'Comments Ratings', 'comments-ratings' ); ?></h2>

	<?php if ( $processor->ok() ): ?>

		<?php if ( ! empty( $errors ) ): ?>
			<br/>
			<p class="update-nag">
				<strong><?php esc_html_e( 'Unable to save settings.', 'comments-ratings' ); ?></strong>
				<?php esc_html_e( 'Please check the fields for errors and typos.', 'comments-ratings' ); ?>
			</p>
		<?php endif;

		if ( $processor->performed_update() ): ?>
			<br/>
			<p class="update-nag">
				<?php esc_html_e( 'Settings have been updated.', 'comments-ratings' ); ?>
			</p>
		<?php endif;
		$f = pixreviews::form( $config, $processor );
		echo $f->startform(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes().
		echo $f->field( 'hiddens' )->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- field templates escape their own output.
		echo $f->field( 'labels' )->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- field templates escape their own output.
		echo $f->field( 'general' )->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- field templates escape their own output. ?>

		<?php wp_nonce_field( 'comments-ratings-save-settings' ); ?>

		<button type="submit" class="button button-primary">
			<?php esc_html_e( 'Save Changes', 'comments-ratings' ); ?>
		</button>

		<?php echo $f->endform(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static closing tag.

	elseif ( $status['state'] == 'error' ): ?>

		<h3><?php esc_html_e( 'Critical Error', 'comments-ratings' ); ?></h3>

		<p><?php echo esc_html( $status['message'] ); ?></p>

	<?php endif; ?>
</div>
