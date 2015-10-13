<?php

$labels_settings = array(
	'type'    => 'postbox',
	'label'   => __( 'Labels', 'pixcustomify_txtd' ),
	'options' => array(
		'review_rating_label'   => array(
			'label'          => __( 'Review Rating Label: ', 'pixcustomify_txtd' ),
			'default'        => __( 'Your overall rating of this listing:', 'pixcustomify_txtd' ),
			'type'           => 'text',
			'size' => "80"
		),
		'review_title_label'   => array(
			'label'          => __( 'Review Title Label: ', 'pixcustomify_txtd' ),
			'default'        => __( 'Your overall rating of this listing:', 'pixcustomify_txtd' ),
			'type'           => 'text',
			'size' => "80"
		),
	)
); # config

return $labels_settings;