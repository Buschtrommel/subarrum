<?php
/**
 * Register custom theme settings
 * 
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
function subarrum_customize_register( $wp_customize ) {
	// add section for setting header appearance
	$wp_customize->add_section('subarrum_navbar_style', array(
		'title'		=> __( 'Navigation Bar', 'subarrum'),
		'priority'	=> 99,
	));
	
	// add option to choose header base color style
	$wp_customize->add_setting('navbar_position', array(
		'default'	=> 'navbar-fixed-top',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control('subarrum_navbar_position', array(
		'priority'	=> '2',
		'label'		=> __('Position', 'subarrum'),
		'section'	=> 'subarrum_navbar_style',
		'settings'	=> 'navbar_position',
		'type'		=> 'radio',
		'choices'	=> array(
			'navbar-disabled'	=> __('Disabled', 'subarrum'),
			'navbar-fixed-top'	=> __('Fixed to top', 'subarrum'),
			'navbar-static-top'	=> __('Static top', 'subarrum'),
			),
	));
	
	// add option to choose header base color style
	$wp_customize->add_setting('navbar_base_color', array(
		'default'	=> 'navbar',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control('subarrum_navbar_base_color', array(
		'priority'	=> '3',
		'label'		=> __('Base Color', 'subarrum'),
		'section'	=> 'subarrum_navbar_style',
		'settings'	=> 'navbar_base_color',
		'type'		=> 'radio',
		'choices'	=> array(
			'navbar navbar-inverse' => __('Black', 'subarrum'),
			'navbar' => __('White', 'subarrum'),
			),
		));
	
	// add option to choose optional header background image
	$wp_customize->add_setting('navbar_background', array(
		'default'	=> '0',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'subarrum_navbar_background', array(
		'priority'	=> '4',
		'label'		=> __('Background Image', 'subarrum'),
		'section'	=> 'subarrum_navbar_style',
		'settings'	=> 'navbar_background',
		)));
	
	
	// add section to choose how thumbnail links are generated
	$wp_customize->add_section('subarrum_post_thumbnails', array(
		'title'		=> __( 'Featured Images', 'subarrum' ),
		'priority'	=> 81,
		));
	
	// add option to choose wether post thumbnails on single sites should link to image page or lightbox popup
	$wp_customize->add_setting('post_thumbnail_link', array(
		'capability'	=> 'edit_theme_options',
		'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_post_thumbnail_link', array(
		 'priority'	=> 1,
		 'settings'	=> 'post_thumbnail_link',
		 'label'	=> __('Link Target on Post Page', 'subarrum'),
		 'section'	=> 'subarrum_post_thumbnails',
		 'type'		=> 'radio',
		 'choices'	=> array(
			0 => __('Image page', 'subarrum'),
			1 => __('Lightbox (not included)', 'subarrum'),
			),
	));
	
	// add option to choose placeholder image for slider items without post thumbnail
	$wp_customize->add_setting('image_slider_placeholder', array(
		'default'	=> get_template_directory_uri() . '/images/slider-placeholder.jpg',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'subarrum_image_slider_placeholder', array(
		'priority'	=> '2',
		'label'		=> __('Slider/Carousel Placeholder Image (960x320px)', 'subarrum'),
		'section'	=> 'subarrum_post_thumbnails',
		'settings'	=> 'image_slider_placeholder',
	)));
	
	// add option to choose placeholder image for similar posts items without post thumbnail
	$wp_customize->add_setting('small_placeholder_image', array(
		'default'	=> get_template_directory_uri() . '/images/similarposts-placeholder.jpg',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'subarrum_small_posts_placeholder', array(
		'priority'	=> '3',
		'label'		=> __('Small Placeholder Image (~200px)', 'subarrum'),
		'section'	=> 'subarrum_post_thumbnails',
		'settings'	=> 'small_placeholder_image',
		)));
	
	// add section to choose where comments should be shown
	$wp_customize->add_section('subarrum_comment_control', array(
		  'title'	=> __('Comments', 'subarrum'),
		  'priority'	=> 56,
		  ));
	
	// add option to choose if comments are possible on image pages
	$wp_customize->add_setting('image_comments', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_image_comments', array(
		  'settings'	=> 'image_comments',
		  'label'	=> __('Comments on image pages', 'subarrum'),
		  'section'	=> 'subarrum_comment_control',
		  'type'	=> 'checkbox',
		  ));
	
	// add option to choose if comments are possible on pages
	$wp_customize->add_setting('page_comments', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_page_comments', array(
		  'settings'	=> 'page_comments',
		  'label'	=> __('Comments on pages', 'subarrum'),
		  'section'	=> 'subarrum_comment_control',
		  'type'	=> 'checkbox',
	));
	
	// add section to choose if author info is shown on non multi author blogs
	$wp_customize->add_section('subarrum_meta_data', array(
		  'title'	=> __('Meta Data', 'subarrum'),
		  'priority'	=> 55,
		  ));
	
	// add option to choose if author info is shown on non multi author blogs
	$wp_customize->add_setting('author_info', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_author_info', array(
		  'priority'	=> 1,
		  'settings'	=> 'author_info',
		  'label'	=> __('Show author info on non multi author sites', 'subarrum'),
		  'section'	=> 'subarrum_meta_data',
		  'type'	=> 'checkbox',
	));
	
	// add option to choose slider source
	$wp_customize->add_setting('meta_data_position', array(
		'default'	=> 'footer',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control('subarrum_meta_data_position', array(
		'priority'	=> '2',
		'label'		=> __('Position of Article Meta Data', 'subarrum'),
		'section'	=> 'subarrum_meta_data',
		'settings'	=> 'meta_data_position',
		'type'		=> 'radio',
		'choices'	=> array(
			'header' => __('Article Header', 'subarrum'),
			'footer' => __('Article Footer', 'subarrum'),
			),
	));
	
	// add option to choose style of entry meta data
	$wp_customize->add_setting('meta_data_style', array(
		'default'	=> 'icons',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control('subarrum_meta_data_style', array(
		'priority'	=> '3',
		'label'		=> __('Style of Article Meta Data', 'subarrum'),
		'section'	=> 'subarrum_meta_data',
		'settings'	=> 'meta_data_style',
		'type'		=> 'select',
		'choices'	=> array(
			'text'		=> __('Text', 'subarrum'),
			'icons'		=> __('Icons', 'subarrum'),
			'popover'	=> __('Single Icon', 'subarrum'),
			),
	));
	
	// add option to choose presentation of similar posts on single pages
	$wp_customize->add_setting('similar_posts_presentation', array(
		'default'	=> 'pictures',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control('subarrum_similar_posts_presentation', array(
		'priority'	=> '4',
		'label'		=> __('Similar Posts Presentation', 'subarrum'),
		'section'	=> 'subarrum_meta_data',
		'settings'	=> 'similar_posts_presentation',
		'type'		=> 'radio',
		'choices'	=> array(
			'pictures'	=> __('Pictures', 'subarrum'),
			'table'		=> __('Table', 'subarrum'),
			),
	));
	
	// add option to choose limit for similar posts to show
	$wp_customize->add_setting('similar_posts_limit', array(
		'default'	=> '4',
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control('subarrum_similar_posts_limit', array(
		'priority'	=> '5',
		'label'		=> __('Number of Similar Posts', 'subarrum'),
		'section'	=> 'subarrum_meta_data',
		'settings'	=> 'similar_posts_limit',
		'type'		=> 'select',
		'choices'	=> array(
			    '1' => '1',
			    '2' => '2',
			    '3' => '3',
			    '4' => '4',
			    '5' => '5',
			    '6' => '6',
			    '7' => '7',
			    '8' => '8',
			    '9' => '9',
			    '10' => '10',
			),
	));
	
	// add section to configure the image slider
	$wp_customize->add_section('subarrum_image_slider', array(
		  'title'	=> __('bxSlider / Bootstrap Carousel', 'subarrum'),
		  'priority'	=> 59,
		  ));
	
	// add option to choose slider source
	$wp_customize->add_setting('image_slider_source', array(
		'default'	=> 'attachment',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control('subarrum_image_slider_source', array(
		'priority'	=> '4',
		'label'		=> __('What to Slide', 'subarrum'),
		'section'	=> 'subarrum_image_slider',
		'settings'	=> 'image_slider_source',
		'type'		=> 'radio',
		'choices'	=> array(
			'attachment'	=> __('Recommended images', 'subarrum'),
			'post'		=> __('Recommended posts', 'subarrum'),
			),
		));
	
	// add option to select the maximum amount of items to show
	$wp_customize->add_setting('image_slider_limit', array(
		  'capability'	=> 'edit_theme_options',
		  'sanitize_callback' => 'absint',
		  'default'	=> 100
	));
	
	$wp_customize->add_control('subarrum_image_slider_limit', array(
		  'priority'	=> '5',
		  'settings'	=> 'image_slider_limit',
		  'label'	=> __('Limit Shown Items', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'text',
	));
	
	// add option to select image slider item order
	$wp_customize->add_setting('image_slider_order', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 'random'
	));
	
	$wp_customize->add_control('subarrum_image_slider_order', array(
		  'priority'	=> '6',
		  'settings'	=> 'image_slider_order',
		  'label'	=> __('Item Order', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'select',
		  'choices'	=> array(
			'random'	=> __('Random', 'subarrum'),
			'ascending'	=> __('ID ascending', 'subarrum'),
			'descending'	=> __('ID descending', 'subarrum'),
		  ),
	));	
	
	// add option to select pause time between image change
	$wp_customize->add_setting('image_slider_pause', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> '5000',
	));
	
	$wp_customize->add_control('subarrum_image_slider_pause', array(
		  'priority'	=> '7',
		  'settings'	=> 'image_slider_pause',
		  'label'	=> __('Delay Between Change', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'select',
		  'choices'	=> array(
			'1000' => __('1 second', 'subarrum'),
			'2000' => __('2 seconds', 'subarrum'),
			'3000' => __('3 seconds', 'subarrum'),
			'4000' => __('4 seconds', 'subarrum'),
			'5000' => __('5 seconds', 'subarrum'),
			'6000' => __('6 seconds', 'subarrum'),
			'7000' => __('7 seconds', 'subarrum'),
			'8000' => __('8 seconds', 'subarrum'),
			'9000' => __('9 seconds', 'subarrum'),
			'10000' => __('10 seconds', 'subarrum'),
		  ),
	));
	
	
	// add option to select image slider change speed
	$wp_customize->add_setting('image_slider_speed', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> '500',
	));
	
	$wp_customize->add_control('subarrum_image_slider_speed', array(
		  'priority'	=> '8',
		  'settings'	=> 'image_slider_speed',
		  'label'	=> __('Animation Speed (bxSlider only)', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'select',
		  'choices'	=> array(
			'100' => __('100 ms', 'subarrum'),
			'200' => __('200 ms', 'subarrum'),
			'300' => __('300 ms', 'subarrum'),
			'400' => __('400 ms', 'subarrum'),
			'500' => __('500 ms', 'subarrum'),
			'600' => __('600 ms', 'subarrum'),
			'700' => __('700 ms', 'subarrum'),
			'800' => __('800 ms', 'subarrum'),
			'900' => __('900 ms', 'subarrum'),
		  ),
	));
	
	// add option to select image slider change mode
	$wp_customize->add_setting('image_slider_mode', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 'fade'
	));
	
	$wp_customize->add_control('subarrum_image_slider_mode', array(
		  'priority'	=> '9',
		  'settings'	=> 'image_slider_mode',
		  'label'	=> __('Image change mode (bxSlider only)', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'select',
		  'choices'	=> array(
			'fade'		=> __('Fade', 'subarrum'),
			'horizontal'	=> __('Horizontal', 'subarrum'),
			'vertical'	=> __('Vertical', 'subarrum'),
		  ),
	));
	
	// add option to select image slider change mode
// 	$wp_customize->add_setting('image_slider_style', array(
// 		  'capability'	=> 'edit_theme_options',
// 		  'default'	=> 'bxslider-css-subarrum'
// 	));
// 	
// 	$wp_customize->add_control('subarrum_image_slider_style', array(
// 		  'priority'	=> '10',
// 		  'settings'	=> 'image_slider_style',
// 		  'label'	=> __('Style', 'subarrum'),
// 		  'section'	=> 'subarrum_image_slider',
// 		  'type'	=> 'select',
// 		  'choices'	=> array(
// 			'bxslider-css'		=> __('Default', 'subarrum'),
// 			'bxslider-css-subarrum'	=> __('Subar Rum', 'subarrum'),
// 		  ),
// 	));
	
	// add option to select if the caption should be show
	$wp_customize->add_setting('image_slider_caption', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_image_slider_caption', array(
		  'priority'	=> '11',
		  'settings'	=> 'image_slider_caption',
		  'label'	=> __('Show caption', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if the caption should be show
	$wp_customize->add_setting('image_slider_excerpt', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_image_slider_excerpt', array(
		  'priority'	=> '12',
		  'settings'	=> 'image_slider_excerpt',
		  'label'	=> __('Show excerpt in caption, too (Bootstrap Carousel only)', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if the controls should be show
	$wp_customize->add_setting('image_slider_controls', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_image_slider_controls', array(
		  'priority'	=> '13',
		  'settings'	=> 'image_slider_controls',
		  'label'	=> __('Show controls', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if the pager should be show
	$wp_customize->add_setting('image_slider_pager', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_image_slider_pager', array(
		  'priority'	=> '14',
		  'settings'	=> 'image_slider_pager',
		  'label'	=> __('Show pager', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if the item should be linked to it parent page
	$wp_customize->add_setting('image_slider_linkit', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_image_slider_linkit', array(
		  'priority'	=> '15',
		  'settings'	=> 'image_slider_linkit',
		  'label'	=> __('Link items to posts/images', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if the slider should automatically start sliding
	$wp_customize->add_setting('image_slider_auto', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_image_slider_auto', array(
		  'priority'	=> '16',
		  'settings'	=> 'image_slider_auto',
		  'label'	=> __('Transit slides automatically', 'subarrum'),
		  'section'	=> 'subarrum_image_slider',
		  'type'	=> 'checkbox',
	));
	
	// add section for configuring two columns layout
	$wp_customize->add_section('subarrum_two_columns', array(
		'title'		=> __( 'Two Content Columns', 'subarrum'),
		'priority'	=> 51,
		));
		
	// add option to select if two columns layout should be used
	$wp_customize->add_setting('two_columns_enable', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_two_columns_enable', array(
		  'priority'	=> '1',
		  'settings'	=> 'two_columns_enable',
		  'label'	=> __('Enable two content columns', 'subarrum'),
		  'section'	=> 'subarrum_two_columns',
		  'type'	=> 'checkbox',
	));
	
	// add selector for first box color
	$wp_customize->add_setting('two_columns_color1', array(
		  'default'		=> 'F5F5F5',
		  'sanitize_callback'	=> 'sanitize_hex_color',
		  'capability'		=> 'edit_theme_options',
	));
 
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'subarrum_two_columns_color1', array(
		   'priority'	=> '2',
		   'label'	=> __('Box Color 1', 'subarrum'),
		   'section'	=> 'subarrum_two_columns',
		   'settings'	=> 'two_columns_color1',
	)));
	
	// add selector for second box color
	$wp_customize->add_setting('two_columns_color2', array(
		  'default'		=> 'ECECEC',
		  'sanitize_callback'	=> 'sanitize_hex_color',
		  'capability'		=> 'edit_theme_options',
	));
 
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'subarrum_two_columns_color2', array(
		   'priority'	=> '3',
		   'label'	=> __('Box Color 2', 'subarrum'),
		   'section'	=> 'subarrum_two_columns',
		   'settings'	=> 'two_columns_color2',
	)));
	
	// add option to select if boxes should be transparent
	$wp_customize->add_setting('two_columns_transparent', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_two_columns_transparent', array(
		  'priority'	=> '4',
		  'settings'	=> 'two_columns_transparent',
		  'label'	=> __('Transparent boxes', 'subarrum'),
		  'section'	=> 'subarrum_two_columns',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if box should be rounded
	$wp_customize->add_setting('two_columns_rounded', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0
	));
	
	$wp_customize->add_control('subarrum_two_columns_rounded', array(
		  'priority'	=> '5',
		  'settings'	=> 'two_columns_rounded',
		  'label'	=> __('Rounded box corners', 'subarrum'),
		  'section'	=> 'subarrum_two_columns',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if box should have a shadow
	$wp_customize->add_setting('two_columns_shadow', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_two_columns_shadow', array(
		  'priority'	=> '6',
		  'settings'	=> 'two_columns_shadow',
		  'label'	=> __('Box shadow', 'subarrum'),
		  'section'	=> 'subarrum_two_columns',
		  'type'	=> 'checkbox',
	));
	
	
	// add section for configuring the container style
	$wp_customize->add_section('container', array(
		'title'		=> __( 'Container Styling', 'subarrum'),
		'priority'	=> 50,
	));
	
	// add option to select if container corners should be rounded
	$wp_customize->add_setting('container_rounded', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_container_rounded', array(
		  'priority'	=> '1',
		  'settings'	=> 'container_rounded',
		  'label'	=> __('Rounded corners', 'subarrum'),
		  'section'	=> 'container',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if container should have a shadow
	$wp_customize->add_setting('container_shadow', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_container_shadow', array(
		  'priority'	=> '2',
		  'settings'	=> 'container_shadow',
		  'label'	=> __('Shadow', 'subarrum'),
		  'section'	=> 'container',
		  'type'	=> 'checkbox',
	));
	
	// add option to select if container should have a border
	$wp_customize->add_setting('container_border', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1
	));
	
	$wp_customize->add_control('subarrum_container_border', array(
		  'priority'	=> '3',
		  'settings'	=> 'container_border',
		  'label'	=> __('Border', 'subarrum'),
		  'section'	=> 'container',
		  'type'	=> 'checkbox',
	));
	
	// add selector for container background color
	$wp_customize->add_setting('container_bgcolor', array(
		  'default'		=> 'FFFFFF',
		  'sanitize_callback'	=> 'sanitize_hex_color',
		  'capability'		=> 'edit_theme_options',
	));
 
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'subarrum_container_bgcolor', array(
		   'priority'	=> '4',
		   'label'	=> __('Background Color', 'subarrum'),
		   'section'	=> 'container',
		   'settings'	=> 'container_bgcolor',
	)));
	
	// add option to choose background image for container
	$wp_customize->add_setting('container_bgimg', array(
		'default'	=> 0,
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'subarrum_container_bgimg', array(
		'priority'	=> '5',
		'label'		=> __('Background Image', 'subarrum'),
		'section'	=> 'container',
		'settings'	=> 'container_bgimg',
	)));
	
	// add option to choose container background image repeat
	$wp_customize->add_setting('container_bgrepeat', array(
		'default'	=> 'repeat',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control('subarrum_container_bgrepeat', array(
		'priority'	=> '6',
		'label'		=> __('Background Repeat', 'subarrum'),
		'section'	=> 'container',
		'settings'	=> 'container_bgrepeat',
		'type'		=> 'radio',
		'choices'	=> array(
			'no-repeat'	=> __('No Repeat', 'subarrum'),
			'repeat'	=> __('Tile', 'subarrum'),
			'repeat-x'	=> __('Tile Horizontally', 'subarrum'),
			'repeat-y'	=> __('Tile Vertically', 'subarrum'),
			),
	));
	
	// add option to choose container background image position
	$wp_customize->add_setting('container_bgposition', array(
		'default'	=> 'left',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control('subarrum_container_bgposition', array(
		'priority'	=> '7',
		'label'		=> __('Background Position', 'subarrum'),
		'section'	=> 'container',
		'settings'	=> 'container_bgposition',
		'type'		=> 'radio',
		'choices'	=> array(
			'left'		=> __('Left', 'subarrum'),
			'center'	=> __('Center', 'subarrum'),
			'right'		=> __('Right', 'subarrum'),
			),
	));
	
	
	
	// add section for configuring the container style
	$wp_customize->add_section('subarrum_header', array(
		'title'		=> __( 'Header', 'subarrum'),
		'priority'	=> 58,
	));
	
	// add option to choose container background image position
	$wp_customize->add_setting('header_type', array(
		'default'	=> 'image',
		'capability'	=> 'edit_theme_options',
		));
	
	$wp_customize->add_control('subarrum_header_type', array(
		'priority'	=> '1',
		'label'		=> __('Header Type', 'subarrum'),
		'section'	=> 'subarrum_header',
		'settings'	=> 'header_type',
		'type'		=> 'radio',
		'choices'	=> array(
			'image'		=> __('Header Image', 'subarrum'),
			'bxslider'	=> __('bxSlider', 'subarrum'),
			'bscarousel'	=> __('Bootstrap Carousel', 'subarrum'),
			),
	));
	
	
	// add option to show header on blog frontpage
	$wp_customize->add_setting('header_show_front', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1,
	));
	
	$wp_customize->add_control('subarrum_header_show_front', array(
		  'priority'	=> '2',
		  'settings'	=> 'header_show_front',
		  'label'	=> __('Show on blog frontpage', 'subarrum'),
		  'section'	=> 'subarrum_header',
		  'type'	=> 'checkbox',
	));
	
	// add option to show header on static front page
	$wp_customize->add_setting('header_show_static', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_header_show_static', array(
		  'priority'	=> '3',
		  'settings'	=> 'header_show_static',
		  'label'	=> __('Show on static frontpage ', 'subarrum'),
		  'section'	=> 'subarrum_header',
		  'type'	=> 'checkbox',
	));
	
	// add option to show header on every other page
	$wp_customize->add_setting('header_show_other', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 0,
	));
	
	$wp_customize->add_control('subarrum_header_show_other', array(
		  'priority'	=> '4',
		  'settings'	=> 'header_show_other',
		  'label'	=> __('Show on other posts/pages', 'subarrum'),
		  'section'	=> 'subarrum_header',
		  'type'	=> 'checkbox',
	));

	// add section for configuring miscellaneous stuff
	$wp_customize->add_section('subarrum_misc', array(
		'title'		=> __( 'Miscellaneous', 'subarrum'),
		'priority'	=> 130,
	));
	
	// add option to show credits
	$wp_customize->add_setting('footer_show_credits', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1,
	));
	
	$wp_customize->add_control('subarrum_footer_show_credits', array(
		  'priority'	=> '1',
		  'settings'	=> 'footer_show_credits',
		  'label'	=> __('Show unobtrusive credits in the footer. Would be nice to keep them there.', 'subarrum'),
		  'section'	=> 'subarrum_misc',
		  'type'	=> 'checkbox',
	));
	
	// add option to show copyright
	$wp_customize->add_setting('footer_show_copy', array(
		  'capability'	=> 'edit_theme_options',
		  'default'	=> 1,
	));
	
	$wp_customize->add_control('subarrum_footer_show_copy', array(
		  'priority'	=> '2',
		  'settings'	=> 'footer_show_copy',
		  'label'	=> __('Show copyright info (your blog name)', 'subarrum'),
		  'section'	=> 'subarrum_misc',
		  'type'	=> 'checkbox',
	));
	
	// add option to link copyright to a page
	$wp_customize->add_setting('footer_copy_link', array(
		  'capability'	=> 'edit_theme_options',
		  'sanitize_callback' => 'absint',
	));
	
	$wp_customize->add_control('subarrum_footer_copy_link', array(
		  'priority'	=> '3',
		  'label'	=> __('Link copyright to', 'subarrum'),
		  'section'	=> 'subarrum_misc',
		  'settings'	=> 'footer_copy_link',
		  'type'	=> 'dropdown-pages',
	));
	
	// add option to choose favicon
	$wp_customize->add_setting('set_favicon', array(
		'default'	=> 0,
		'capability'	=> 'edit_theme_options',
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'subarrum_set_favicon', array(
		'priority'	=> '4',
		'label'		=> __('Favicon (ICO, GIF or PNG)', 'subarrum'),
		'section'	=> 'subarrum_misc',
		'settings'	=> 'set_favicon',
	)));
	
}
?>