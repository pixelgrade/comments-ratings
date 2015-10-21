<?php

$general_settings = array(
	'type'    => 'postbox',
	'label'   => 'General Settings',
	'options' => array(

		'enable_selective_ratings' => array(
			'label'      => __( 'Select which post types should have ratings?', 'pixcustomify_txtd' ),
			'default'    => false,
			'type'       => 'switch',
			'show_group' => 'post_types_group'
		),
		'post_types_group'         => array(
			'type'    => 'group',
			'options' => array(
				'display_on_post_types' => array(
					'label'       => __( 'Post Types', 'pixfields_txtd' ),
					'default'     => array( 'post' => 'on', 'page' => 'on' ),
					'type'        => 'post_types_checkbox',
					'description' => 'Which post types should have comments with ratings'
				),
			)
		),
		'default_rating'           => array(
			'label'   => __( 'Select which post types should have ratings?', 'pixcustomify_txtd' ),
			'type'    => 'select',
			'default' => '4',
			'options' => array(
				'1'=>'1',
				'2'=>'2',
				'3'=>'3',
				'4'=>'4',
				'5'=>'5'
			)
		),
	)
); # config

return $general_settings;