<?php defined('ABSPATH') or die;
	/* @var PixReviewsFormField $field */
	/* @var PixReviewsForm $form */
	/* @var mixed $default */
	/* @var string $name */
	/* @var string $idname */
	/* @var string $label */
	/* @var string $desc */
	/* @var string $rendering */

	isset($type) or $type = 'hidden';

	$attrs = array
		(
			'name' => $name,
			'id' => $idname,
			'type' => 'hidden',
			'value' => $form->autovalue($name)
		);
?>

<input <?php echo $field->htmlattributes($attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribute values are escaped with esc_attr() in htmlattributes(). ?>/>
