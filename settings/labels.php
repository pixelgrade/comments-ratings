<?php

$labels_settings = array(
	'type'    => 'postbox',
	'label'   => __( 'Labels', 'pixcustomify_txtd' ),
	'options' => array(
		'review_label'   => array(
			'label'          => __( 'Review Label', 'pixcustomify_txtd' ),
			'default'        => __( 'Your overall rating of this listing:', 'pixcustomify_txtd' ),
			'type'           => 'text'
		),
	)
); # config

return $labels_settings;