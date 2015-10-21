<?php

$labels_settings = array(
	'type'    => 'postbox',
	'label'   => __( 'Labels', 'pixcustomify_txtd' ),
	'options' => array(
		'review_rating_label'      => array(
			'label'   => __( 'Review Rating Label: ', 'pixcustomify_txtd' ),
			'default' => __( 'Your overall rating of this listing:', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
		'review_title_label'       => array(
			'label'   => __( 'Review Title Label: ', 'pixcustomify_txtd' ),
			'default' => __( 'Title of your review', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
		'review_title_placeholder' => array(
			'label'   => __( 'Review Title Placeholder: ', 'pixcustomify_txtd' ),
			'default' => __( 'Summarize your opinion or highlight an interesting detail', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
		'review_label'             => array(
			'label'   => __( 'Review Label: ', 'pixcustomify_txtd' ),
			'default' => __( 'Your Review', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
		'review_placeholder'       => array(
			'label'   => __( 'Review Placeholder: ', 'pixcustomify_txtd' ),
			'default' => __( 'Tell about your experience or leave a tip for others', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
		'review_submit_button'     => array(
			'label'   => __( 'Review Submit Button: ', 'pixcustomify_txtd' ),
			'default' => __( 'Submit your Review', 'pixcustomify_txtd' ),
			'type'    => 'text',
			'size'    => "80"
		),
	)
); # config

return $labels_settings;