<?php defined('ABSPATH') or die;
	/* @var PixReviewsFormField $field */
	/* @var PixReviewsForm $form */
	/* @var mixed $default */
	/* @var string $name */
	/* @var string $idname */
	/* @var string $label */
	/* @var string $desc */
	/* @var string $rendering */

	isset($type) or $type = 'text';

	$attrs = array (
		'name' => $name,
		'id' => $idname,
		'type' => 'text',
		'value' => $form->autovalue($name),
	);

if ( $field->hasmeta('size') ) {
	$attrs['size'] = $field->getmeta('size');
}
?>

<?php if ($rendering == 'inline'): ?>
	<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?>/>
<?php elseif ($rendering == 'blocks'):  ?>
<div class="text">
	<label id="<?php echo esc_attr( $name ) ?>"><?php echo esc_html( $label ) ?></label>
	<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?> />
	<span><?php echo esc_html( $desc ) ?></span>
</div>
<?php else: # ?>
	<div>
		<p><?php echo esc_html( $desc ) ?></p>
		<label id="<?php echo esc_attr( $name ) ?>">
			<?php echo esc_html( $label ) ?>
			<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?>/>
		</label>
	</div>
<?php endif; ?>
