<?php defined('ABSPATH') or die;
	/* @var PixReviewsFormField $field */
	/* @var PixReviewsForm $form */
	/* @var mixed $default */
	/* @var string $name */
	/* @var string $idname */
	/* @var string $label */
	/* @var string $desc */
	/* @var string $rendering */

	// [!!] a switch is a checkbox that is only ever either on or off; not to
	// be confused with a fully functional checkbox which may be many values

	$checked = $form->autovalue($name, $default);

	$attrs = array
		(
			'name' => $name,
			'type' => 'checkbox',
			'id' => $idname,
			'value' => 1,
		);

	// is the checkbox checked?
	if ($checked) {
		$attrs['checked'] = 'checked';
	}

	// Label Fillins
	// -------------

	if ($field->hasmeta('label-fillins')) {
		$fillers = array();
		foreach ($field->getmeta('label-fillins', array()) as $fieldname => $conf) {
			$fillers[":$fieldname"] = $form->field($fieldname, $conf)->render();
		}

		$processed_label = strtr( esc_html( $label ), $fillers );
	}
	else { // no fillins available
		$processed_label = esc_html( $label );
	}

	// group show

	if ($field->hasmeta('show_group')) {
		$attrs['data-show_group'] =  $field->getmeta('show_group');
	}
?>

<?php if ($rendering == 'inline'): ?>
	<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?> />

<?php elseif ($rendering == 'blocks'):  ?>
	<div class="switch">
		<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?> />
		<label for="<?php echo esc_attr( $idname ) ?>"><?php echo $processed_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above; fill-ins are rendered field templates. ?></label>
	</div>
<?php else: # rendering != 'inline' ?>
	<label for="<?php echo esc_attr( $idname ) ?>">
		<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?> />
		<?php echo $processed_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above; fill-ins are rendered field templates. ?>
	</label>
<?php endif; ?>
