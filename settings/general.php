<?php

$general_settings = array(
	'type'    => 'postbox',
	'label'   => 'General Settings',
	'options' => array(

		'enable_selective_ratings'   => array(
				'label'          => __( 'Select which post types should have ratings?', 'pixcustomify_txtd' ),
				'default'        => false,
				'type'           => 'switch',
				'show_group'     => 'post_types_group'
		),
		'post_types_group' => array(
			'type'    => 'group',
			'options' => array(
				'display_on_post_types' => array(
						'label'          => __( 'Post Types', 'pixfields_txtd' ),
						'default'        => array('post' => 'on', 'page' => 'on'),
						'type'           => 'post_types_checkbox',
						'description' => 'Which post types should have comments with ratings'
				),
			)
		),

	)
); # config

return $general_settings;