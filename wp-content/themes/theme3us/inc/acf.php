<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Layout Settings',
		'menu_title'	=> 'Layout',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Sliders',
		'menu_title'	=> 'Main Sliders',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Socials',
		'menu_title'	=> 'Socials',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

if ( function_exists( 'register_field_group' ) ) {
	register_field_group(
		array(
			'id'     => 'layout-options',
			'title'  => __( 'Layout Options', 'threeus' ),
			'fields' => array(
				array(
					'key'          => 'field_549fgd94f',
					'label'        =>  __( 'Site Layout', 'threeus' ),
					'name'         => 'acf_site_layout',
					'type'         => 'select',
					'choices' => array(
						'fullwidth'       => __( 'Full Width', 'threeus' ),
						'boxed'       => __( 'Boxed', 'threeus' ),
					),
					'default_value' => 'fullwidth',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_549b65f3ad94f',
					'label'        =>  __( 'Container width', 'threeus' ),
					'name'         => 'acf_container_width',
					'type'         => 'text',
					'instructions' => __( 'Default width: <strong>1170px</strong>', 'threeus' ),
					'default_value' => '1170px',
				),
				array(
					'key'          => 'field_549b74c3ad94f',
					'label'        =>  __( 'Select Page Layout', 'threeus' ),
					'name'         => 'acf_page_layout',
					'type'         => 'select',
					'instructions' => __( 'Default layout: <strong>Right Sidebar</strong>', 'threeus' ),
					'choices' => array(
						'main'            => __( 'Full Width', 'threeus' ),
						'left-main'       => __( 'Left Sidebar', 'threeus' ),
						'main-right'      => __( 'Right Sidebar', 'threeus' ),
						'left-main-right' => __( 'Left - Main Content - Right', 'threeus' ),
					),
					'default_value' => 'main-right',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_gr4sd94f',
					'label'        =>  __( 'Sidebar column width', 'threeus' ),
					'name'         => 'acf_sidebar_width',
					'type'         => 'select',
					'choices' => array(
						'1'        => __( 'One column', 'threeus' ),
						'2'        => __( 'Two column', 'threeus' ),
						'3'        => __( 'Three column', 'threeus' ),
						'4'        => __( 'Four column', 'threeus' ),
						'5'        => __( 'Five column', 'threeus' ),
					),
					'default_value' => '4',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_544fgk4f',
					'label'        =>  __( 'Select Blog Layout', 'threeus' ),
					'name'         => 'acf_blog_layout',
					'type'         => 'select',
					'choices' => array(
						'thumb-fullwidth'  => __( 'Thumbnail Full Width', 'threeus' ),
						'thumb-left'       => __( 'Left Thumbnail', 'threeus' ),
						'boxed'      	   => __( 'Boxed', 'threeus' ),
					),
					'default_value' => 'thumb-left',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_23fs54f',
					'label'        =>  __( 'Single post thumbnail', 'threeus' ),
					'name'         => 'acf_post_thumb',
					'type'         => 'true_false',
					'instructions'  => __( 'Select this if you want to hide Single post thumbnail', 'threeus' ),
					'default_value' => '0',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-layout',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);

	register_field_group(
		array(
			'id'     => 'general-options',
			'title'  => __( 'General Options', 'threeus' ),
			'fields' => array(
				array(
					'key'          => 'field_fdjk33jfd54f',
					'label'        =>  __( 'Site logo', 'threeus' ),
					'name'         => 'acf_logo',
					'type'         => 'image',
				),
				array(
					'key'          => 'field_fdjk33jffred',
					'label'        =>  __( 'Form logo', 'threeus' ),
					'name'         => 'acf_form_logo',
					'type'         => 'image',
				),
				array(
					'key'          => 'field_adj4d34res',
					'label'        =>  __( 'Link Account', 'threeus' ),
					'name'         => 'acf_account',
					'type'         => 'text',
				),
				array(
					'key'          => 'field_addkjskres',
					'label'        =>  __( 'Link Đăng bài mới', 'threeus' ),
					'name'         => 'acf_new_post',
					'type'         => 'text',
				),
				array(
					'key'          => 'field_rsdidngdcfdv',
					'label'        =>  __( 'Ghi chú đánh giá ở trang chi tiết tin tức', 'threeus' ),
					'name'         => 'acf_rating_note',
					'type'         => 'textarea',
				),
				array(
					'key'          => 'field_fdj543cfdv',
					'label'        =>  __( 'Google adword code', 'threeus' ),
					'name'         => 'acf_gg_adword',
					'type'         => 'textarea',
				),
				array(
					'key'          => 'field_adjv34res',
					'label'        =>  __( 'Terms of use', 'threeus' ),
					'name'         => 'acf_tou',
					'type'         => 'url',
				),
				array(
					'key'          => 'field_a45gerfges',
					'label'        =>  __( 'Copyright', 'threeus' ),
					'name'         => 'acf_copyright',
					'type'         => 'text',
				),
				array(
					'key'          => 'field_a455tgrees',
					'label'        =>  __( 'Upload Video URL', 'threeus' ),
					'name'         => 'acf_upvideo',
					'type'         => 'url',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'theme-general-settings',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);

	register_field_group(
		array(
			'id'     => 'sliders-settings',
			'title'  => __( 'Slider Setting', 'threeus' ),
			'fields' => array(
				array(
					'key'          => 'field_fdgl89f',
					'label'        =>  __( 'Style', 'threeus' ),
					'name'         => 'acf_style',
					'type'         => 'select',
					'choices' => array(
						'container'  => __( 'Boxed', 'threeus' ),
						'fullwidth'  => __( 'Full Width', 'threeus' ),
					),
					'default_value' => 'container',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_fdf4354f',
					'label'        =>  __( 'Navigation', 'threeus' ),
					'name'         => 'acf_navigation',
					'type'         => 'true_false',
					'instructions'  => __( 'Select this if you want to hide Navigation', 'threeus' ),
					'default_value' => '0',
				),
				array(
					'key'          => 'field_f43254f',
					'label'        =>  __( 'Pagination', 'threeus' ),
					'name'         => 'acf_pagination',
					'type'         => 'true_false',
					'instructions'  => __( 'Select this if you want to hide Pagination', 'threeus' ),
					'default_value' => '0',
				),
				array(
					'key'          => 'field_f434rd54f',
					'label'        =>  __( 'Auto Play', 'threeus' ),
					'name'         => 'acf_play',
					'type'         => 'true_false',
					'instructions'  => __( 'Select this if you want to disable auto play', 'threeus' ),
					'default_value' => '0',
				),
				array(
					'key'          => 'field_f4fkgd4f',
					'label'        =>  __( 'Speed', 'threeus' ),
					'name'         => 'acf_speed',
					'type'         => 'text',
					'instructions'  => __( 'Enter number', 'threeus' ),
					'default_value' => '1000',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-main-sliders',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'side',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);

	register_field_group(
		array(
			'id'     => 'sliders-options',
			'title'  => __( 'Slider Options', 'threeus' ),
			'fields' => array(
				array(
					'key'          => 'field_fd433jfd54f',
					'label'        =>  __( 'Slider', 'threeus' ),
					'name'         => 'acf_slider',
					'layout'	   => 'block',
					'type'         => 'repeater',
					'sub_fields' => array(
						array(
							'key'	=> 'field_sdfd34re545',
							'label' => 'Image',
							'type' => 'image',
							'name' => 'image',
						),
						array(
							'key'	=> 'field_sdfy44re545',
							'label' => 'Link',
							'type' => 'url',
							'name' => 'link',
						),
						array(
							'key'	=> 'field_s43fde545',
							'label' => 'Content',
							'type' => 'wysiwyg',
							'name' => 'content',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-main-sliders',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);

	register_field_group(
		array(
			'id'     => 'socials-options',
			'title'  => __( 'Socials Option', 'threeus' ),
			'fields' => array(
				array(
					'key'          => 'field_edd43df',
					'label'        =>  __( 'Add Social', 'threeus' ),
					'name'         => 'acf_social',
					'type'         => 'repeater',
					'sub_fields' => array(
						array(
							'key'	=> 'field_rtds002ds',
							'label' => 'Icon',
							'name'  => 'icon',
							'type'  => 'radio',
							'choices' => array(
								'facebook'     => '<i class="fa fa-facebook"></i>',
								'skype'      => '<i class="fa fa-skype"></i>',
								'instagram'      => '<i class="fa fa-instagram"></i>',
								'google-plus'  => '<i class="fa fa-google-plus"></i>',
								'youtube'     => '<i class="fa fa-youtube"></i>',
							),
							'default_value' => 'facebook',
							'allow_null'    => 0,
							'multiple'      => 0,
						),
						array(
							'key'	=> 'field_sed33s',
							'label' => 'Name',
							'type' => 'text',
							'name' => 'name',
						),
						array(
							'key'	=> 'field_sd445ds',
							'label' => 'Link',
							'type' => 'url',
							'name' => 'link',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-socials',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);
}


?>