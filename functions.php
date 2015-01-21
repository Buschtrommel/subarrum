<?php 
/**
 * Functions
 *
 * Subar Rum core funtions file.
 *
 * @revised   May 26, 2014
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

 

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 * 
 * @since Subar Rum 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 630;
}

/**
 * include the wp_customize stuf for theme customizer
 */
require (get_template_directory() . '/inc/subarrum-customize-theme.php');

/**
 * include the built-in widgets
 */
require (get_template_directory() . '/inc/subarrum-widgets.php');


/**
 * Hook in the different filters, actions and shortcodes
 * 
 * @since Subar Rum 1.0
 */
function subarrum_register_hooks() {
	
	// general hooks
	add_action( 'after_setup_theme', 	'subarrum_setup' );
	add_action( 'widgets_init', 		'subarrum_widgets_init' );
	add_action( 'template_redirect',	'subarrum_content_width' );
	add_action( 'wp_enqueue_scripts',	'subarrum_fonts' );
	add_action( 'init',                     'subarrum_add_excerpt_to_ages' );
	add_action( 'customize_register',			'subarrum_customize_register', 11 );
	
	// admin only hooks
      if(is_admin()) {
	add_filter( 'image_size_names_choose',			'subarrum_insert_custom_image_sizes' );
	add_filter( 'manage_posts_columns', 			'subarrum_featured_column_title' );
	add_filter( 'manage_media_columns', 			'subarrum_featured_column_title' );
	add_filter( 'manage_posts_custom_column', 		'subarrum_posts_column_content', 10, 2 );
	add_filter( 'manage_media_custom_column', 		'subarrum_media_column_content', 10, 2 );
	add_action( 'post_submitbox_misc_actions', 		'subarrum_publish_action_featured' );
	add_action( 'attachment_submitbox_misc_actions',	'subarrum_publish_action_featured' );
	global $pagenow; if ( $pagenow == 'post.php') // only loads on single edit page
	add_action( 'save_post',				'subarrum_save_featured_post' );
	add_filter( 'attachment_fields_to_save',		'subarrum_save_featured_image' );
	
	// frontend only hooks
      } else {
	add_action( 'wp_enqueue_scripts',	'subarrum_scripts_styles' );
	add_action( 'wp_head', 			'subarrum_customize_css' );
	add_filter( 'get_calendar', 		'subarrum_filter_get_calendar' );
	add_action( 'wp_enqueue_scripts',	'subarrum_add_ie_html5_shiv' );
	add_filter( 'get_the_excerpt',		'subarrum_excerpt_read_more_link' );
	add_filter( 'the_excerpt',		'subarrum_excerpt_protected');
	add_filter( 'the_password_form',	'subarrum_password_form' );
	add_filter( 'the_category',		'subarrum_the_category_hasTip' );
	add_filter( 'wp_tag_cloud',		'subarrum_wp_tag_cloud_hasTip' );
	add_action( 'comment_form_before',	'subarrum_enqueue_comments_reply' );
	add_filter( 'the_content',		'subarrum_make_embedded_repsonsive', 30 );
	add_shortcode( 'wp_caption', 		'subarrum_img_caption_shortcode' );
	add_shortcode( 'caption', 		'subarrum_img_caption_shortcode' );
	add_shortcode( 'audio',			'subarrum_audio_shortcode');
	remove_shortcode( 'gallery',		'gallery_shortcode' );
	add_shortcode( 'gallery',		'subarrum_gallery_shortcode' );
	add_shortcode( 'sr_thumbnail',          'subarrum_thumbnail_shortcode' );
	add_shortcode( 'sr_gallery_overview',   'subarrum_gallery_overview' );
      }
}
subarrum_register_hooks();


/**
 * Adjusts content_width value for variuous combinations of sites and sidebars
 *
 * @since Subar Rum 1.0
 */
function subarrum_content_width() {
	global $content_width;
	if ( (is_home() || is_archive()) and !(is_active_sidebar( 'sidebar-1' )) ) {
		$content_width = (get_theme_mod('two_columns_enable', 0) == 1) ? 460 : 960;
	} elseif ( (is_home() || is_archive()) and (is_active_sidebar( 'sidebar-1' )) ) {
		$content_width = (get_theme_mod('two_columns_enable', 0) == 1) ? 300 : 630;
	} elseif ( is_single() and !(is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'entries-1' )) ) {
		$content_width = 960;
	} elseif ( is_page() and !(is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'entries-1' ) || is_active_sidebar( 'pages-1' )) ) {
		$content_width = 960;
	} elseif ( is_page_template('page-templates/full-width-no-title.php') ) {
		$content_width = 960;
	} elseif ( is_page_template('page-templates/full-width.php') ) {
		$content_width = 960;
	} elseif ( is_page_template('page-templates/front-page.php') ) {
		$content_width = 960;
	} elseif ( is_page_template('page-templates/front-page-no-titl.php') ) {
		$content_width = 960;
	}
}



/**
 * Setup the basic theme functions and options
 * 
 * @since Subar Rum 1.0
 */
function subarrum_setup()
{
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	load_theme_textdomain( 'subarrum', get_template_directory() . '/languages' );
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'navbar', __( 'Navigation Bar Menu', 'subarrum' ) );
	register_nav_menu( 'primary', __( 'Primary Menu', 'subarrum' ) );
	
	// support for custom background color, sets also up a default color
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );
	
	// support for custom header
	$custom_header_defaults = array(
					'width'			=> 960,
					'height'		=> 0,
					'flex-height'		=> true,
					'default-text-color'	=> '000000',
					);
	add_theme_support( 'custom-header', $custom_header_defaults );
	
	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status', 'video', 'audio' ) );
	
	// Adds image size for full view of post images in single post view
	add_image_size('post-image-full', 630, 9999);
	add_image_size('post-image-wide', 960, 420, true);
	add_image_size('post-thumbnails-wide', 960, 320, true);
	add_image_size('post-image-full-width', 960, 9999);
	
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 630, 200, true ); // Unlimited height, soft crop
}




/**
 * Add the additional image sizes to the media chooser
 * 
 * @since Subar Rum 1.0
 */
function subarrum_insert_custom_image_sizes( $sizes ) {
  global $_wp_additional_image_sizes;
  if ( empty($_wp_additional_image_sizes) )
    return $sizes;

  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    if ( !isset($sizes[$id]) )
      $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
  }

  return $sizes;
}



/**
 * Register and enqueue scripts and styles
 * 
 * @since Subar Rum 1.0
 */
function subarrum_scripts_styles()
{
	global $wp_styles;
	
	// enqueue main bootstrap java script
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '2.3.2', false );
	
	// enqueue enbale bootstrap tooltips through java script
	wp_enqueue_script( 'bootstrap-tooltip', get_template_directory_uri() . '/js/enableTooltips.js', array('bootstrap'), '1.0', false );
	
	// enqueue enable bootstrap popovers when needed for iconified meta data
// 	if (!(get_theme_mod('meta_data_style', 'icons') == 'text')) {
	wp_enqueue_script( 'bootstrap-popover', get_template_directory_uri() . '/js/enablePopovers.js', array('bootstrap-tooltip'), '1.0', false );
// 	}
	
	// enqueue main bootstrap css style
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '2.3.2', 'all' );
	
	// enqueue responsive bootstrap css stlye
	wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri() . '/bootstrap/css/bootstrap-responsive.min.css', array('body-style'), '2.3.2', 'all' );
	
	// enqueue body style between bootstrap main and responsinve because of navbar fixed to top, load
	// appropriate body css style
	wp_enqueue_style( 'body-style', get_template_directory_uri(). '/css/style-body-'. get_theme_mod('navbar_position', 'navbar-fixed-top') .'.css', array('bootstrap-style'), '1.0', 'all');
	
	// register bxslider script, but load it when needed in template fancy-header.php
	wp_register_script( 'bxslider', get_template_directory_uri() . '/bxslider/jquery.bxslider.min.js', array('jquery'), '4.1.2', false );
	
	// register bxslider styles, but load it when needed in template fancy-header.php
	wp_register_style( 'bxslider-css', get_template_directory_uri() . '/bxslider/jquery.bxslider.css', array(), '4.1.2', 'all');
	wp_register_style( 'bxslider-css-subarrum', get_template_directory_uri() . '/css/jquery.bxslider-subarrum.css', array(), '1.0', 'all');
	
	// register justified gallery script and css, but load it when needed by gallery shortcode
	wp_enqueue_script( 'justified-gallery', get_template_directory_uri() . '/justified-gallery/jquery.justifiedGallery.min.js', array('jquery'), '3.5.1', false);
	wp_enqueue_style( 'justified-gallery-css', get_template_directory_uri() . '/justified-gallery/justifiedGallery.min.css', array(), '3.5.1', 'all');
	
	// load font awesome css styles
	wp_enqueue_style( 'font-awesome', get_template_directory_uri(). '/fontawesome/font-awesome.min.css', array('bootstrap-style'), '3.2.1', 'all' );
	
	// load base style sheet
	wp_enqueue_style( 'subarrum-base-style', get_template_directory_uri(). '/css/style-base.css', array('bootstrap-responsive'), '1.0', 'all' );
	
	// load the main style sheet
	wp_enqueue_style( 'subarrum-style', get_stylesheet_uri(), array('subarrum-base-style'), '1.0', 'all' );
}



/**
 * Add Internet Explorer conditional html5 shiv and css hacks to the header
 * 
 * @since Subar Rum 1.0
 * @uses wp_check_browser_version()
 */
function subarrum_add_ie_html5_shiv() {
	global $is_IE;
	
	// return if browser is not IE
	if (!$is_IE) return;
	
	// include the needed file for wp_check_browser_version
	if (! function_exists('wp_check_browser_version') )
		include_once(ABSPATH . 'wp-admin/includes/dashboard.php');
	
	$browser = wp_check_browser_version();
	if ( 0 == version_compare( intval($browser['version']), 7))
		wp_enqueue_style( 'bs-ie7-buttonfix', get_template_directory_uri(). '/css/bootstrap-ie7buttonfix.css', array('bootstrap-style'), '1.0', 'all' );
	if ( 0 == version_compare( intval($browser['version']), 8))
		wp_enqueue_style( 'bs-ie8-buttonfix', get_template_directory_uri(). '/css/bootstrap-ie8buttonfix.css', array('bootstrap-style'), '1.0', 'all' );
	if ( 0 == version_compare( intval($browser['version']), 7))
		wp_enqueue_style( 'font-awesome-ie7', get_template_directory_uri(). '/fontawesome/font-awesome-ie7.min.css', array('font-awesome'), '3.0.2', 'all' );
	// enqueue html5 shiv if IE version is lower 9
	if ( 0 > version_compare( intval($browser['version']), 9))
		wp_enqueue_script( 'ie-html5', get_template_directory_uri() . '/js/html5shiv.min.js', array(), '3.7.2', false );
}



/**
 * add custom css code for different template options
 * 
 * @since Subar Rum 1.0
 */
function subarrum_customize_css() {
?>
<style type="text/css">

	.body .container {
	  background-color: <?php echo get_theme_mod('container_bgcolor', '#FFFFFF'); ?>;
	  <?php if (get_theme_mod('container_rounded', 1)) : ?>
	  -moz-border-radius: 4px;
	  -webkit-border-radius: 4px;
	  border-radius: 4px;
	  <?php endif; ?>
	  <?php if (get_theme_mod('container_shadow', 1)) : ?>
	  -moz-box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
	  -webkit-box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
	  box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
	  <?php endif; ?>
	  <?php if (get_theme_mod('container_border', 1)) : ?>
	  border: 1px solid rgba(0,0,0,0.15);
	  <?php endif; ?>
	  <?php if (get_theme_mod('container_bgimg', 0)) : ?>
	  background-image: url(<?php echo get_theme_mod('container_bgimg'); ?>);
	  background-repeat: <?php echo get_theme_mod('container_bgrepeat', 'repeat'); ?>;
	  background-position: <?php echo get_theme_mod('container_bgposition', 'left'); ?>;
	  <?php endif; ?>
	}
	
<?php if (is_admin_bar_showing()) : ?>
      @media (min-width: 980px) {
	#navbar {
		margin-top: 28px;
	}
      }
<?php endif; ?>

<?php if ( get_theme_mod('navbar_background') ) : ?>
	#navbar .navbar-inner {
		background-image:url(<?php echo get_theme_mod('navbar_background'); ?>);
		background-repeat: repeat;
	}
<?php endif; ?>

<?php if ( get_theme_mod('two_columns_enable', 0) ) : ;?>
	
	.blog article {
	  margin-bottom: 6px;
	}
	
	div.two-col-box {
	  padding: 4px;
	  <?php if (get_theme_mod('two_columns_rounded', 0)) : ?>
	  border-radius: 3px;
	  <?php endif; ?>
	  <?php if (get_theme_mod('two_columns_shadow', 1)) : ?>
	  -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	  -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	  <?php endif; ?>
	}
	
	
	<?php if (!(get_theme_mod('two_columns_transparent', 1))) : ?>
	div.light-back {
	  background-color: <?php echo get_theme_mod('two_columns_color1', 'F5F5F5'); ?>;
	}


	div.dark-back {
	  background-color: <?php echo get_theme_mod('two_columns_color2', 'ECECEC'); ?>;
	}
	<?php endif; ?>
	
<?php endif; ?>

</style>

<?php
}


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Droid Sans and Droid Serif by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Subar Rum 1.0
 * @from Twenty Thirteen 1.0
 * @return string Font stylesheet or empty string if disabled.
 */
function subarrum_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Droid Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$droid_sans = _x( 'on', 'Droid Sans font: on or off', 'subarrum' );

	/* Translators: If there are characters in your language that are not
	 * supported by Droid Serif, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$droid_serif = _x( 'on', 'Droid Serif: on or off', 'subarrum' );

	if ( 'off' !== $droid_sans || 'off' !== $droid_serif ) {
		$font_families = array();

		if ( 'off' !== $droid_sans )
			$font_families[] = 'Droid+Sans:400,700';

		if ( 'off' !== $droid_serif )
			$font_families[] = 'Droid+Serif:400,700,400italic,700italic';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}



/**
 * Loads the special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'subarrum-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @since Subar Rum 1.0
 * @from Twenty Thirteen 1.0
 * @return void
 */
function subarrum_fonts() {
	$fonts_url = subarrum_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'subarrum-fonts', esc_url_raw( $fonts_url ), array(), null );
}



/**
 * Registers the widget areas and the built-in widgets
 * 
 * @since Subar Rum 1.0
 */
function subarrum_widgets_init() {
	register_widget( 'Subarrum_Meta_Widget' );
	register_widget( 'Subarrum_Random_Post_Widget' );
	register_widget( 'Subarrum_Recent_Posts' );
	register_widget( 'Subarrum_Recent_Comments' );
	register_widget( 'Subarrum_Recommended_Widget' );
	
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'subarrum' ),
		'id' => 'sidebar-1',
		'description' => __( 'The standard widgets area appears by default everywhere, when no widgets are in the entry widgets or the pages area, except the static start page which has its own area.', 'subarrum' ),
		'before_widget' => '<div class="row-fluid" style="margin-bottom:15px;"><aside id="%1$s" class="span12 widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Entries Area', 'subarrum' ),
		'id' => 'entries-1',
		'description' => __( 'Appears on single entries when widgets are set, and also on pages when no widget is set in Pages Area.', 'subarrum' ),
		'before_widget' => '<div class="row-fluid" style="margin-bottom:15px;"><aside id="%1$s" class="span12 widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Pages Area', 'subarrum' ),
		'id' => 'pages-1',
		'description' => __( 'Appears on pages when widgets are set.', 'subarrum' ),
		'before_widget' => '<div class="row-fluid" style="margin-bottom:15px;"><aside id="%1$s" class="span12 widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Area 1', 'subarrum' ),
		'id' => 'footer-1',
		'description' => __( 'Appears on the footer and has space for a maximum of four widgets.', 'subarrum' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Area 2', 'subarrum' ),
		'id' => 'footer-2',
		'description' => __( 'Appears on the footer and has space for a maximum of four widgets.', 'subarrum' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Front Page Area 1', 'subarrum' ),
		'id' => 'front-1',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page.', 'subarrum' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Front Page Area 2', 'subarrum' ),
		'id' => 'front-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page.', 'subarrum' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Gallery', 'subarrum' ),
		'id' => 'gallery',
		'description' => __( 'Appears when using the optional Gallery template with a page.', 'subarrum' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h6 class="widget-head">',
		'after_title' => '</h6>',
	) );
}



/**
 * custom audio caption shortcode
 * 
 * @since Subar Rum 1.0
 */
function subarrum_audio_shortcode($url) {
	$reg_exOGG = "/\.(ogg|OGG)\z/";
	$reg_exMP3 = "/\.(mp3|MP3)\z/";
	$reg_exWAV = "/\.(wav|WAV)\z/";
	
	$html = '<audio controls="controls">';
	foreach ($url as $file) {
		if (preg_match($reg_exOGG, $file)) $type = 'audio/ogg';
		if (preg_match($reg_exMP3, $file)) $type = 'audio/mpeg';
		if (preg_match($reg_exWAV, $file)) $type = 'audio/wav';
		$html .= '<source src="'.$file.'" type="'.$type.'">';
	}
	$html .= sprintf( __('Apologies. But your browser does not support the HTML5 audio tag, you can <a href="%1$s">download the file</a> instead.', 'subarrum'), $url[0]);
	$html .= '</audio>';
	
	return $html;
}



/**
 * custom image caption shortcode
 * 
 * @since Subar Rum 1.0
 */
function subarrum_img_caption_shortcode($attr, $content = null) {

	// New-style shortcode with the caption inside the shortcode with the link and image tags.
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}

	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	$capalign = '';

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	
	switch($align) {
		case 'alignleft':
		  $align = 'pull-left'; $capalign = ' text-left'; $margin = 'style="margin-right:7px;"';
		  break;
		case 'alignright':
		  $align = 'pull-right'; $capalign = ' text-right'; $margin = 'style="margin-left:7px;"';
		  break;
		case 'aligncenter':
		  $capalign = ' text-center'; $margin = '';
		  break;
		default:
		  $margin ='';
	}

	return '<div '. $id .'class="wp-caption '. esc_attr($align) . '" '. $margin .'>'. do_shortcode($content) .'<p class="wp-caption-text'. esc_attr($capalign) .'">'. $caption .'</p></div>';

}



if ( ! function_exists( 'subarrum_paginate_links' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Subar Rum 1.0
 */
function subarrum_paginate_links( $html_id ) {
	global $wp_query;
	global $paged;

	$html_id = esc_attr( $html_id );
	$showmaxpage = 4; //set maximum pages to show +/- current page
	$avalmaxpage = $wp_query->max_num_pages; //the available pages to display
	
	if ( $avalmaxpage > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="pagination pagination-centered hidden-phone" role="navigation">
		  <ul>
		    
		    <?php // show back to start when more pages are available then maximum to show ?>
		    <?php if ( $avalmaxpage > ($showmaxpage * 2 + 1) && $paged > ($showmaxpage + 1) ) : ?>
			<li <?php if ($paged == 0) {echo 'class="disabled"';} ?>><a href="<?php echo get_pagenum_link($pagenum = 0); ?>"><i class="icon-step-backward"></i></a></li>
		    <?php endif; ?>
		    
		    <?php if ($paged > 1) : ?>
			<li <?php if ($paged == 0) {echo 'class="disabled"';} ?>><a href="<?php previous_posts(); ?>"><i class="icon-backward"></i></a></li>
		    <?php endif; ?>
		    
		    <?php if ($paged <= ($showmaxpage + 1)) : ?>
			<li <?php if ($paged == 0) {echo 'class="active"';} ?>><a href="<?php echo get_pagenum_link($pagenum = 0); ?>">1</a></li>
		    <?php endif; ?>
		    
		    <?php $page = ($paged - $showmaxpage); while ($page <= $avalmaxpage && $page < $paged) : ?>
		      <?php if ($page > 1) : ?>
			<li <?php if ($paged == $page) {echo 'class="active"';} ?>>
			  <a href="<?php echo get_pagenum_link($pagenum = $page); ?>"><?php echo $page; ?></a>
			</li>
		      <?php endif; ?>
		    <?php $page++; ?>
		    <?php endwhile; ?>
		    
		    <?php $page = $paged; while ($page <= $avalmaxpage && $page <= ($paged + $showmaxpage )) : ?>
		      <?php if ($page > 1) : ?>
			<li <?php if ($paged == $page) {echo 'class="active"';} ?>>
			  <a href="<?php echo get_pagenum_link($pagenum = $page); ?>"><?php echo $page; ?></a>
			</li>
		      <?php endif; ?>
		    <?php $page++; ?>
		    <?php endwhile; ?>
		    
		    <?php if ( $paged < $avalmaxpage ) : ?>
			<li <?php if ($paged == $avalmaxpage) {echo 'class="disabled"';} ?>><a href="<?php next_posts(); ?>"><i class="icon-forward"></i></a></li>
		    <?php endif; ?>
		    
		    <?php if ( $avalmaxpage > ($showmaxpage * 2 + 1) && $paged < ($avalmaxpage - $showmaxpage) ) : ?>
			<li <?php if ($paged == $avalmaxpage) {echo 'class="disabled"';} ?>><a href="<?php echo get_pagenum_link($pagenum = $avalmaxpage); ?>" class="hasTip" title="<?php printf(__('Last page: %1$d', 'subarrum'), $avalmaxpage); ?>"><i class="icon-step-forward"></i></a></li>
		    <?php endif; ?>
		    
		  </ul>
		</nav>
		
		<?php // show these on mobile devices ?>
		<nav id="<?php echo $html_id; ?>" class="visible-phone" role="navigation">
		  <ul class="pager">
		    <li class="previous<?php if ($paged == 0 || $paged == 1) {echo ' disabled';} ?>">
		      <a href="<?php previous_posts(); ?>"><i class="icon-arrow-left"></i> <?php _e( 'Newer', 'subarrum' ); ?></a>
		    </li>
		    <li class="next<?php if ($paged == $wp_query->max_num_pages) {echo ' disabled';} ?>">
		      <a href="<?php next_posts(); ?>"><?php _e( 'Older', 'subarrum' ); ?> <i class="icon-arrow-right"></i></a>
		    </li>
		  </ul>
		</nav>
	<?php endif;
}
endif;




if ( ! function_exists( 'subarrum_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 * Inspired by Twent Twelve Theme.
 *
 * @since Subar Rum 1.0
 */
function subarrum_entry_meta($style = null) {
	
	if (empty($style))
		$style = get_theme_mod('meta_data_style', 'icons');
	$two_columns_enable = get_theme_mod('two_columns_enable', 0);
	
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'subarrum' ) );
	
	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'subarrum' ) );
	
	if ($style == 'popover') {
		$comments  = '<a href="'. esc_url(get_permalink()) .'#comments">'. get_comments_number() .'</a>';
	}
	
	if ($style == 'icons') {
		$categories_count = substr_count($categories_list, '<a');
		if ($categories_count > 1) {
			// save the original categories list
			$categories_list_orig = $categories_list;
		
			$categories_list  = "<a href='#' data-toggle='popover' data-placement='bottom' title='";
			$categories_list .= __('Posted in', 'subarrum') ."'";
			$categories_list .= " data-content='". $categories_list_orig ."'";
			$categories_list .= " data-html='true' class='hasPopover'>";
			$categories_list .= $categories_count ." ". __('Categories', 'subarrum');
			$categories_list .= "</a>";
		}
		
		$tag_count = substr_count($tag_list, '<a');
		if ($tag_count > 1) {
			// save the original tag list
			$tag_list_orig = $tag_list;
			
			$tag_list  = "<a href='#' data-toggle='popover' data-placement='bottom' title='";
			$tag_list .= __('Tagged as', 'subarrum') ."'";
			$tag_list .= " data-content='". $tag_list_orig ."'";
			$tag_list .= " data-html='true' class='hasPopover'>";
			$tag_list .= $tag_count ." ". __('Tags', 'subarrum');
			$tag_list .= "</a>";
		}
	}

	$date = sprintf( '<a href="%1$s" class="hasTip" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n hasTip" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'subarrum' ), get_the_author() ) ),
		get_the_author()
	);

	if ($style == 'text') {
		// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
		if ( $tag_list ) {
			$utility_text = __( '<small class="grey">Posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.</small>', 'subarrum' );
		} elseif ( $categories_list ) {
			$utility_text = __( '<small class="grey">Posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.</small>', 'subarrum' );
		} else {
			$utility_text = __( '<small class="grey">Posted on %3$s<span class="by-author"> by %4$s</span>.</small>', 'subarrum' );
		}

	} elseif ($style == 'icons') {
	    if (!$two_columns_enable) {
		if ( $tag_list ) {
			$utility_text = '<div class="row-fluid hidden-phone meta-icons"><div class="span3"><i class="icon-calendar"></i> %3$s</div><div class="span3"><i class="icon-user"></i> %4$s</div><div class="span3"><i class="icon-folder-open"></i> %1$s</div><div class="span3"><i class="icon-tags"></i> %2$s</div></div><div class="visible-phone meta-icons"><small><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s <i class="icon-folder-open"></i> %1$s <i class="icon-tags"></i> %2$s</small></div>';
		} elseif ( $categories_list ) {
			$utility_text = '<div class="row-fluid hidden-phone meta-icons"><div class="span3"><i class="icon-calendar"></i> %3$s</div><div class="span3"><i class="icon-user"></i> %4$s</div><div class="span3"><i class="icon-folder-open"></i> %1$s</div><div class="span3"></div></div><div class="visible-phone meta-icons"><small><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s <i class="icon-folder-open"></i> %1$s</small></div>';
		} else {
			$utility_text = '<div class="row-fluid hidden-phone meta-icons"><div class="span3"><i class="icon-calendar"></i> %3$s</div><div class="span3"><i class="icon-user"></i> %4$s</div><div class="span3"></div><div class="span3"></div></div><div class="visible-phone meta-icons"><small><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s</small></div>';
		}
	    } else {
		if ( $tag_list ) {
			$utility_text = '<div class="meta-icons"><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s <i class="icon-folder-open"></i> %1$s <i class="icon-tags"></i> %2$s</div>';
		} elseif ( $categories_list ) {
			$utility_text = '<div class="meta-icons"><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s <i class="icon-folder-open"></i> %1$s</div>';
		} else {
			$utility_text = '<div class="meta-icons"><i class="icon-calendar"></i> %3$s <i class="icon-user"></i> %4$s</div>';
		}
	    }
	} elseif ($style == 'popover') {
		$utility_text  = "<a href='#' data-toggle='popover' data-placement='bottom' ";
		$utility_text .= "data-html='true' class='hasPopover grey'  title='";
		$utility_text .= __('Meta Data', 'subarrum') ."' ";
		if ( $tag_list ) {
			$utility_text .= "data-content='<i class=\"icon-calendar\"></i> ";
			$utility_text .= '%3$s';
			$utility_text .= "<br /><i class=\"icon-user\"></i> ";
			$utility_text .= '%4$s';
			$utility_text .= "<br /><i class=\"icon-folder-open\"></i> ";
			$utility_text .= '%1$s';
			$utility_text .= "<br /><i class=\"icon-tags\"></i> ";
			$utility_text .= '%2$s';
			$utility_text .= "<br /><i class=\"icon-comments\"></i> ";
			$utility_text .= $comments;
			$utility_text .= "'>";
		} elseif ( $categories_list ) {
			$utility_text .= "data-content='<i class=\"icon-calendar\"></i> ";
			$utility_text .= '%3$s';
			$utility_text .= "<br /><i class=\"icon-user\"></i> ";
			$utility_text .= '%4$s';
			$utility_text .= "<br /><i class=\"icon-folder-open\"></i> ";
			$utility_text .= '%1$s';
			$utility_text .= "<br /><i class=\"icon-comments\"></i> ";
			$utility_text .= $comments;
			$utility_text .= "'>";
		} else {
			$utility_text .= "data-content='<i class=\"icon-calendar\"></i> ";
			$utility_text .= '%3$s';
			$utility_text .= "<br /><i class=\"icon-user\"></i> ";
			$utility_text .= '%4$s';
			$utility_text .= "<br /><i class=\"icon-comments\"></i> ";
			$utility_text .= $comments;
			$utility_text .= "'>";
		}
		$utility_text .= "<i class=\"icon-barcode pull-right\"></i>";
		$utility_text .= "</a>";
	}
	
	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
		);
}
endif;



if ( ! function_exists( 'subarrum_post_thumbnail' ) ) :
/**
 * Prints HTML caption for post thumbnail.
 *
 * @since Subar Rum 1.0
 */
function subarrum_post_thumbnail($thumbsize = 'post-thumbnail', $caption = '1') {
	global $content_width;
	
	$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbsize);
	$thumb_image_alt = get_post_meta(get_post_thumbnail_id(),'_wp_attachment_image_alt', true);
	$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	$attachment = get_post(get_post_thumbnail_id());
	
	// load theme option if image on single page should link to lightbox (1) or image page (0)
	$linktarget = get_theme_mod('post_thumbnail_link');
	
	$out = ($caption) ? '<div class="wp-caption">' : '<p>';
	
	if (is_singular()) {
	  $out .= '<a href="';
	  $out .= $linktarget ? esc_url( $full_image_url[0] ) . '" ' : esc_url( get_permalink(get_post(get_post_thumbnail_id()))) . '" '; // link to image url or to image page
	  $out .= $linktarget ? 'rel="lightbox" ' : ''; // add lightbox or not
	  $out .= 'title="'. $thumb_image_alt .'">';
	} else {
	  $out .= '<a href="'. esc_url( get_permalink()) .'" title="'. get_the_title() .'">';
	}
	
	if ($thumb_image_url[1] < ($content_width / 2)) {
	  $out .= '<img src="'. esc_url( $thumb_image_url[0] ) .'" width="'. $thumb_image_url[1] .'" height="'. $thumb_image_url[3] .'" alt="'. esc_attr($thumb_image_alt) .'" class="pull-left featured-vertical" /></a>';
	} else {
	  $out .= '<img src="'. esc_url( $thumb_image_url[0] ) .'" width="'. $thumb_image_url[1] .'" height="'. $thumb_image_url[3] .'" alt="'. esc_attr($thumb_image_alt) .'" /></a>';
	}
	
	if ($attachment->post_excerpt && $caption) {
		$out .= '<p class="wp-caption-text" style="width:'. $thumb_image_url[1] .'">'. $attachment->post_excerpt .'</p>';
	}
			
	$out .= ($caption) ? '</div>' : '</p>';
	
	echo $out;
}
endif;




if ( ! function_exists( 'subarrum_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Subar Rum 1.0
 */
function subarrum_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $comment_depth;
	
	// set extra comment class, based on comment style and depth
	$commextraclass = 'well well-small';
	switch ($comment_depth) {
		case "1": $commextraclass .= ' span12';
			  break;
		case "2": $commextraclass .= ' span11 offset1';
			  break;
		case "3": $commextraclass .= ' span10 offset2';
			  break;
		case "4": $commextraclass .= ' span9 offset3';
			  break;
		case "5": $commextraclass .= ' span8 offset4';
			  break;
		default: $commextraclass .= ' span7 offset5';
	}
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<div class="row-fluid">
	<div <?php comment_class($commextraclass); ?> id="comment-<?php comment_ID(); ?>">
		<p>
		  <?php _e( 'Pingback:', 'subarrum' ); ?>
		  <?php comment_author_link(); ?>
		  <?php edit_comment_link( __( '(Edit)', 'subarrum' ), '<span class="edit-link">', '</span>' ); ?>
		</p>
	</div>
	</div>
	<?php
		break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<div class="row-fluid">
	<div <?php comment_class($commextraclass); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard row-fluid" style="margin-bottom:10px;">
				<?php
					printf( '<div class="span10"><cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span class="label label-info"><i class="icon-user"></i> ' . __( 'Post author', 'subarrum' ) . '</span>' : ''
					);
					printf( '<br /><small><a href="%1$s"><time datetime="%2$s">%3$s</time></a></small></div>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'subarrum' ), get_comment_date(), get_comment_time() )
					);
					echo '<div class="span2 text-right" style="display:block;">';
					echo get_avatar( $comment, 44 );
					echo '</div>';
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="alert alert-success" style="margin-top:10px;">
				  <?php _e( 'Your comment is awaiting moderation.', 'subarrum' ); ?>
				</div>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'subarrum' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'subarrum' ), 'after' => ' <i class="icon-reply"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	</div>
	</div>
	<?php
		break;
	endswitch; // end comment_type check
}
endif;


if ( ! function_exists( 'subarrum_comment_end' ) ) :

function subarrum_comment_end() {
	return true;
}

endif;




/**
 * use own markup for walker nav menu
 * 
 * @since Subar Rum 1.0
 */
class subarrum_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
 
		// build html
		$output .= "\n" . $indent . '<ul class="dropdown-menu">' . "\n";
	}
	
	function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		// check, whether there are children for the given ID and append it to the element with a (new) ID
		$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
	
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
  
		// depth dependent classes
		$depth_classes = array(
			( ( $item->hasChildren && $depth > 0 ) ? ' dropdown-submenu pull-left' : ''),
			( ( $item->hasChildren && $depth == 0 ) ? 'dropdown' : '')
			);
    
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
  
		// build html
		$output .= $indent . '<li class="' . $class_names . $depth_class_names . '">';
  
		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link' . ( ( $item->hasChildren && $depth == 0 ) ? ' dropdown-toggle ' : '') . '"';
		$attributes .= ( ( $item->hasChildren && $depth == 0 ) ? ' data-toggle="dropdown"' : '');
		
		$dropcaret = ( ( $item->hasChildren && $depth == 0 ) ? ' <b class="caret"></b>' : '');
		
  
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%7$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after,
			$dropcaret
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	function end_el ( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}




if ( ! function_exists( 'subarrum_wp_link_pages' ) ) :
/**
 * Generates a pagination for articles over multiple pages.
 *
 * @since Subar Rum 1.0
 */
function subarrum_wp_link_pages($args = '') {
	        $defaults = array(
	                'before' => '<div class="pagination"><ul><li class="disabled"><a href="#">'.__('Page', 'subarrum').'</a></li>',
	                'after' => '</ul></div>',
	                'link_before' => '',
	                'link_after' => '',
	                'next_or_number' => 'number',
	                'nextpagelink' => __('Next page', 'subarrum'),
	                'previouspagelink' => __('Previous page', 'subarrum'),
	                'pagelink' => '%',
	                'echo' => 1
	        );
	
	        $r = wp_parse_args( $args, $defaults );
	        $r = apply_filters( 'wp_link_pages_args', $r );
	        extract( $r, EXTR_SKIP );
	
	        global $page, $numpages, $multipage, $more, $pagenow;
	
	        $output = '';
	        if ( $multipage ) {
	                if ( 'number' == $next_or_number ) {
	                        $output .= $before;
	                        for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
	                                $j = str_replace('%',$i,$pagelink);
	                                $output .= ' ';
	                                if ( ($i != $page) || ((!$more) && ($page==1)) ) {
						$output .= '<li>';
	                                        $output .= _wp_link_page($i);
	                                } else {
						$output .= '<li class="disabled"><a href="#">';
	                                }
	                                $output .= $link_before . $j . $link_after;
// 	                                if ( ($i != $page) || ((!$more) && ($page==1)) )
	                                        $output .= '</a>';
	                                $output .= '</li>';
	                        }
	                        $output .= $after;
	                } else {
	                        if ( $more ) {
	                                $output .= $before;
	                                $i = $page - 1;
	                                if ( $i && $more ) {
	                                        $output .= _wp_link_page($i);
	                                        $output .= $link_before. $previouspagelink . $link_after . '</a>';
	                                }
	                                $i = $page + 1;
	                                if ( $i <= $numpages && $more ) {
	                                        $output .= _wp_link_page($i);
	                                        $output .= $link_before. $nextpagelink . $link_after . '</a>';
	                                }
	                                $output .= $after;
	                        }
	                }
	        }
	
	        if ( $echo )
	                echo $output;
	
	        return $output;
}
endif;




/**
 * Add filter to excerpt generation to add a read more link
 * 
 * @since Subar Rum 1.0
 * 
 * @param string $output Holds original output and returns modified output
 */
function subarrum_excerpt_read_more_link($output) {

	if (!is_singular())
		$output .= ' <a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Continue reading', 'subarrum' ) . ' &rarr;</a>';
	
	return $output;
}



/**
 * Add filter to excerpt generation when post is protected by password
 * 
 * @since Subar Rum 1.0
 * 
 * @param string $excerpt Holds original output and returns modified output
 */
function subarrum_excerpt_protected( $excerpt ) {
	
	if ( post_password_required() )
	$excerpt = '<div class="alert">'. __('There is no excerpt because this is a protected post.', 'subarrum') .'</div>';
	return $excerpt;
}



/**
 * Add filter to calendar plugin to get more bootstrap in it
 * 
 * @since Subar Rum 1.0
 * 
 * @param string $calendar_output Holds the original calendar html
 * @param string $output Holds the modified calendar html
 */
function subarrum_filter_get_calendar( $calendar_output ) {
    // Define your custom calendar output here
    $output = str_replace( '<table id="wp-calendar">', '<table id="wp-calendar" class="table table-condensed">', $calendar_output );
    $output = str_replace( '<a', '<a class="hasTip"', $output );
    // Now return it
    return $output;
}




/**
 * Add "Recommended" column title to the appropriate page (this function is hooked to posts/media column title)
 *
 * @since Subar Rum 1.0
 *
 * @param array $defaults default columns
 */
function subarrum_featured_column_title($defaults){
  $defaults['featured'] = __('Recommended', 'subarrum'); // featured posts
  return $defaults;
}




/**
 * Setup featured column content for Posts (edit.php) page
 *
 * @since Subar Rum 1.0
 *
 * @param string $column_name Current Column
 * @param string $id Post ID
 */
function subarrum_posts_column_content($column_name, $id){
  // not our column
  if($column_name !== 'featured') return;

  echo get_post_meta( $id, 'subarrum_featured', true ) ? '<img src="'. get_template_directory_uri() .'/images/featured.png" alt="'. __('Recommended', 'subarrum') .'" title="'. __('Recommended', 'subarrum') .'" />' : '<img src="'. get_template_directory_uri() .'/images/unfeatured.png" alt="'. __('Not recommended', 'subarrum') .'" title="'. __('Not recommended', 'subarrum') .'" />';
}




/**
 * Setup featured column content for Media Library (upload.php) page
 *
 * @since Subar Rum 1.0
 *
 * @param string $column_name Current Column
 * @param string $id Post ID
 */
function subarrum_media_column_content($column_name, $id){
  // not our column / current item not an image
  if($column_name !== 'featured' || strpos(get_post_mime_type($id), 'image/') === false) return;
  
  echo get_post_meta( $id, 'subarrum_featured', true ) ? '<img src="'. get_template_directory_uri() .'/images/featured.png" alt="'. __('Recommended', 'subarrum') .'" title="'. __('Recommended', 'subarrum') .'" />' : '<img src="'. get_template_directory_uri() .'/images/unfeatured.png" alt="'. __('Not recommended', 'subarrum') .'" title="'. __('Not recommended', 'subarrum') .'" />';
}




/**
 * Recommended post status / publish action
 *
 * @since Subar Rum 1.0
 */
function subarrum_publish_action_featured(){

  //show only on standard post pages and image attachment pages
  if(get_post_type() == 'post' || ( get_post_type() == 'attachment' && strpos(get_post_mime_type(get_the_ID()), 'image/') !== false ) ) :

  // check if the item is already marked as featured  
  $check = get_post_meta( get_the_ID(), 'subarrum_featured', true );

  ?>
  <div class="misc-pub-section featured misc-pub-section-last">
    <?php wp_nonce_field( 'subarrum_save_featured', 'subarrum_publish_featured_nonce' ); ?>
    <input type="checkbox" name="subarrum_featured" <?php checked($check, 1); ?>>
    <span><?php _e('Recommend this', 'subarrum'); ?></span>
  </div>

  <?php endif;
}




/**
 * save recommended posts to wp_postmeta to meta_key subarrum_featured
 * 
 * @since Subar Rum 1.0
 * 
 * @param string $post_id Post ID
 */
function subarrum_save_featured_post($post_id) {
	global $flag; // set a global flag to prevent double run
	
	if (!isset($_POST['post_type']) )
		return $post_id;
	
	if ($_POST['post_type'] != 'post')
		return $post_id;
	
	// check if the user has permission to edit posts
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	
	// check if security nonce is valid
	if ( !wp_verify_nonce( $_POST['subarrum_publish_featured_nonce'], 'subarrum_save_featured' ) ) {
		print 'Nonce verification failed.';
		exit;
	}
	
	// save only when it is kicked off by user
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
	
	// unhook this function so it doesn't loop infinitely
	remove_action('save_post', 'subarrum_save_featured');
	
	//check if this is the first run
	if ( $flag == 0) {
	
		//check if the given id is from another revision of the post
		if ($parent_id = wp_is_post_revision($post_id)) {
			$post_id = $parent_id;
		}
	
		$isfeatured = isset($_POST['subarrum_featured']) ? 1 : 0; // get information from request
	
		// get current featured array
		$featured = get_post_meta($post_id, 'subarrum_featured', true);
	
		// add / or remove requested item from metadata table, depending on current selection
		// "isfeatured" means that the item was selected and is now being checked, so we're adding it to
		// the table, otherwise we will remove the entry
		if($isfeatured && !($featured)) {
			update_post_meta($post_id, 'subarrum_featured', true);
		} elseif(!$isfeatured && $featured) {
			delete_post_meta($post_id, 'subarrum_featured');
		}

	}
	$flag = 1;
	// re-hook this function
	add_action('save_post', 'subarrum_save_featured');
}




/**
 * save recommended images to wp_postmeta key subarrum_featured
 *
 * @since Subar Rum 1.0
 * 
 * @param object $post Post Data Object
 */
function subarrum_save_featured_image($post) {

	if (!isset($_POST['post_type']) )
		return $post;
	
	if ($_POST['post_type'] != 'attachment')
		return $post;
	
	// check if user has the permission to modify attachments
	if ( !current_user_can( 'upload_files', (int)$post['post_ID'] ) )
		return $post;
		
	// check if security nonce is valid
	if ( !wp_verify_nonce( $_POST['subarrum_publish_featured_nonce'], 'subarrum_save_featured' ) ) {
		print 'Nonce verification failed.';
		exit;
	}
	
	// save only when it is kicked off by user
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post;
	
	// first check if the media attachment is an image
	if ( substr($post['post_mime_type'], 0 ,5) == 'image' ) {
	
		$isfeatured = isset($post['subarrum_featured']) ? 1 : 0; // get information from post data
	
		$id = (int)$post['post_ID'];
	
		// get current featured array
		$featured = get_post_meta($id, 'subarrum_featured', true);
	
		// add / or remove requested item from metadata table, depending on current selection
		// "isfeatured" means that the item was selected and is now being checked, so we're adding it to
		// the table, otherwise we will remove the entry
		if($isfeatured && !($featured)) {
			update_post_meta($id, 'subarrum_featured', true);
		} elseif(!$isfeatured && $featured) {
			delete_post_meta($id, 'subarrum_featured');
		}
	
	}
	
	return $post;
}




/**
 * function to get recommended items in an array
 *
 * @since Subar Rum 1.0
 * 
 * @param string $type Post type, attachment or post
 * @param integer $limit Set a limit to shown posts or attachments
 * @param string $order Order the results
 * @param aray $featured the ids of the recommended items
 */
function subarrum_get_featured($type = 'attachment', $limit = 100, $order = 'descending') {
	// get wordpress database class
	global $wpdb;
	
	switch($order) {
		case "ascending": $ordering = 'po.ID ASC';
				  break;
		case "random"	: $ordering = 'RAND()';
				  break;
		default		: $ordering = 'po.ID DESC';
	}
	
	// set post status for database query to show only published posts, but status of attachments
	// is inherit by default
	switch($type) {
		case "attachment": $status = 'inherit';
				   break;
		case "post"      : $status = 'publish';
				   break;
	}

	// select post IDs from database where meta key subarrum_featured is set
	// and that have the appropriate post_type (attachment or post), order by ID
	// beginning with the highest/newest
	$results = $wpdb->get_results($wpdb->prepare(
			"SELECT po.ID FROM $wpdb->posts po
			 JOIN $wpdb->postmeta pm
			 ON po.ID = pm.post_id
			 WHERE pm.meta_key = %s
			 AND po.post_type = %s
			 AND po.post_status = %s
			 ORDER BY $ordering
			 LIMIT %d", 'subarrum_featured', $type, $status, $limit), ARRAY_A);
	
	$featured = array();
	
	// convert the multi dimensional array in a flat one
	foreach ($results as $result) {
		$featured[] = $result['ID'];
	}

	return $featured;
}



/**
 * function to display similar posts to a post based on the tags,
 * has to be used in The Loop
 * 
 * @since Subar Rum 1.0
 *
 * @param integer $limit to set maximum shown posts
 * @param string $presentation set presentation mode (table or pictures)
 */
if ( ! function_exists( 'subarrum_get_similar_posts' ) ) {
function subarrum_get_similar_posts($limit = 0, $presentation = '') {	
	// get option for similar posts limit
	if (!$limit)
		$limit = (int)get_theme_mod('similar_posts_limit', 4);
	
	// get tag ids for current post
	$tags = wp_get_post_tags(get_the_ID(), array('fields' => 'ids'));
	
	// set query args
	$args = array(
		'tag__in' => $tags,
		'post__not_in' => array(get_the_ID()),
		'showposts' => $limit,
		'ignore_sticky_posts' => 1
		);
	
	// get similar posts
	$similar = new wp_query($args);

	if ($similar->have_posts()) {
	
	    // get option for similar posts presentation
	    if (!$presentation)
		$presentation = get_theme_mod('similar_posts_presentation', 'pictures');
		
	    if ($presentation == 'table') {
		echo '<table class="table table-hover table-condensed">';
		echo '<thead><tr><th>'. __('Post', 'subarrum') .'</th><th>'. __('Date', 'subarrum') .'</th><th><i class="icon-comment"></i></th></tr></thead>';
		echo '<tbody>';
		while ($similar->have_posts()) {
			$similar->the_post(); ?>
			<tr>
			<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
			<td><time class="entry-date grey" datetime="<?php the_date('c'); ?>"><?php the_time(get_option('date_format')); ?></time></td>
			<td><a href="<?php the_permalink(); ?>#comments"><?php comments_number('0', '1', '%'); ?></a></td>
			</tr>
		<?php
		}
		echo '</tbody>';
		echo '</table>';
	    
	    } elseif ($presentation == 'pictures') {
		$count = 0;
		while ($similar->have_posts()) {
			$count++;
			$similar->the_post();
			$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
			$thumb_image_alt = get_post_meta(get_post_thumbnail_id(),'_wp_attachment_image_alt', true);
			if (!$thumb_image_url[0]) {
				$thumb_image_url[0] = get_theme_mod('small_placeholder_image', get_template_directory_uri() . '/images/similarposts-placeholder.jpg');
				$thumb_image_alt = __('Placeholder', 'subarrum');
			} ?>
			<?php if ($count % 2 != 0) : ?>
			<div class="row-fluid similar-posts-row">
			<?php endif; ?>
			  <div class="span6 similar-post <?php echo ($count % 2 != 0) ? 'col1' : 'col2'; ?>">
			  <a href="<?php the_permalink(); ?>">
			    <img class="img-polaroid pull-left similar-posts" alt="<?php echo esc_attr($thumb_image_alt); ?>" src="<?php echo esc_url($thumb_image_url[0]); ?>" />
			  </a>
			  <b><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b><br />
			  <small class="clearfix"><time class="entry-date grey" datetime="<?php the_date('c'); ?>"><?php the_time(get_option('date_format')); ?></time><br /><a href="<?php the_permalink(); ?>#comments"><?php comments_number(); ?></a></small>
			  <i></i>
			  <div class="clearfix"></div>
			  </div>
			<?php if ($count % 2 == 0) : ?>
			</div>
			<?php endif; ?>			
		<?php
		}
		
		if ($count % 2 != 0) : ?>
		  <div class="span6">
		  </div>
		</div>
		<?php endif;
	    }
	}
	
	wp_reset_postdata(); // reset global post data after this query
}
}



/**
 * Add filter to get_category_list to add hasTip class for nicer hover tooltips
 *
 * @since Subar Rum 1.0
 */
function subarrum_the_category_hasTip($cat_list) {
	return str_ireplace('<a', '<a class="hasTip"', $cat_list);
}



/**
 * Add filter to wp_tag_cloud to add hasTip class for niver hover tooltips
 * 
 * @since Subar Rum 1.0
 */
function subarrum_wp_tag_cloud_hasTip($return) {
	return preg_replace("/(tag-link-\d+)/i", '${1} hasTip', $return );
}



/**
 * Add filter to style the password form for protected entries
 * 
 * @since Subar Rum 1.0
 */
function subarrum_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
	$output = '<div class="alert">' . __( "This post is password protected. To view it please enter your password below:", 'subarrum' ) . '</div><form class="form-inline" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post"><label for="' . $label . '"></label><div class="input-prepend input-append"><span class="add-on"><i class="icon-key"></i></span><input name="post_password" id="' . $label . '" type="password" class="input-medium" placeholder="' . __( "Password", 'subarrum' ) . '" /><button type="submit" name="Submit" value="' . esc_attr__( "Submit", 'subarrum' ) . '" class="btn">'.esc_attr__( "Submit", 'subarrum' ).'</button></div></form>';
    
	return $output;
}


/**
 * Add function to view a random post
 * 
 * @param string $text The button text
 * 
 * @since Subar Rum 1.0
 */
function subarrum_get_random_post($text) {
	global $wpdb;
	$text = ($text) ? esc_attr($text) : __('Try your luck and hit or miss', 'subarrum');
	
	$randompost = $wpdb->get_results($wpdb->prepare(
			"SELECT ID FROM $wpdb->posts
			 WHERE post_status = %s
			 AND post_type = %s
			 ORDER BY RAND()
			 LIMIT %d", 'publish', 'post', 1), ARRAY_A);
	
	$out  = '<a class="btn btn-info" href="';
	$out .= esc_url(get_permalink($randompost[0]["ID"]));
	$out .= '"><i class="icon-random"> </i>'. $text .'</a>';
	
	echo $out;
}



/**
 * Function to extract and prepare embedded videos
 * additionaly it creates HTML5 videos from given plain file links
 * 
 * This function is used in the video post format template.
 * 
 * CURRENTLY NOT IN USE
 * 
 * @since Subar Rum 1.0
 */
// function subarrum_extract_video() {
// 	// regular expression for video file URIs
// 	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\._\/]+\.(ogv|OGV|ogg|OGG|webm|WEBM|mp4|MP4)/";
// 	$reg_exIframe = "/<iframe .*>.*<\/iframe>/";
// 	$reg_exEmbed = "/<embed .*>.*<\/embed>/";
// 	$reg_exVideo = "/<video .*>.*<\/video>/";
// 	$reg_exLink = "/<a .*>.*<\/a>/";
// 	$reg_exRespsonive = '/<div class="embed-container" .*<\/div>/';
// 	$content = get_the_content();
// 	$content = apply_filters('the_content', $content);
// 	$content = str_replace(']]>', ']]&gt;', $content);
// 	$videos = '';
// 
// 	// find stuff that has already made responsive through another function
// 	// if found something, return directly
// 	if (strpos($content, 'embed-container')) return $content;
// 	
// 	// find embedded html5 videos and make them responsive
// 	if (preg_match($reg_exVideo, $content, $html5)) {
// 	  $videos .= '<div class="embed-container subarrum-extract-video">'. $html5[0] .'</div>';
// 	  $content = preg_replace($reg_exVideo, $videos, $content);
// 	  return $content;
// 	}
// 	
// 	// find embedded iframs, for example from youtube, and make them responsive
// 	if (preg_match($reg_exIframe, $content, $iframe)) {
// 	  $videos .= '<div class="embed-container subarrum-extract-video">'. $iframe[0] .'</div>';
// 	  $content = preg_replace($reg_exIframe, $videos, $content);
// 	  return $content;
// 	}
// 	
// 	// find embedded embeds, for example from youtube, and make them responsive
// 	if (preg_match($reg_exEmbed, $content, $embed)) {
// 	  if (!strpos($embed[0], '"display:none"')) {
// 	    $videos .= '<div class="embed-container subarrum-extract-video">'. $embed[0] .'</div>';
// 	    $content = preg_replace($reg_exEmbed, $videos, $content);
// 	    return $content;
// 	  }
// 	}
// 	
// 	
// 	// Find "normal" video links, either encapsulated by <a> tags or raw ones
// 	// and put them in an assoziative array, where the URI is the key name.
// 	// This construct allows automatically generated HTML5 video tags in the next stp.
// 	preg_match_all($reg_exUrl, $content, $urls, PREG_SET_ORDER);
// 	$videolist = array();
// 	foreach($urls as $url) {
// 	  $url = pathinfo($url[0]);
// 	  $file = $url['dirname'].'/'.$url['filename'];
// 	  $videolist[$file][]= $url['extension'];
// 	}
// 
// 	// Build a HTML5 video object out of the extractet plain links and store in $videos
// 	foreach($videolist as $url => $types) {
// 	    $videos .= '<div class="embed-container subarrum-extract-video"><video controls="controls">';
// 	  foreach($types as $type) {
// 	    $src = $url.'.'.$type; // reconstruct the src URI
// 	    $reg_exSrc  = preg_quote($src, '/'); // create regular expression for plain URIs
// 	    $reg_exLink = "/<a .*(".$reg_exSrc.").*<\/a>/";  // regular expression for default links
// 	    $content = preg_replace($reg_exLink, '', $content); // remove used default links from content
// 	    $content = preg_replace('/'.$reg_exSrc.'/', '', $content); // remove used plain URIs from content
// 	    switch($type) { // now build the source entries
// 	      case 'webm':
// 	      case 'WEBM':
// 		    $videos .= '<source src="'.$src.'" type="video/webm">';
// 		    break;
// 	      case 'ogv':
// 	      case 'OGV':
// 	      case 'ogg':
// 	      case 'OGG':
// 		    $videos .= '<source src="'.$src.'" type="video/ogg">';
// 		    break;
// 	      case 'mp4':
// 	      case 'MP4':
// 		    $videos .= '<source src="'.$src.'" type="video/mp4">';
// 		    break;
// 	    }
// 	    
// 	  }
// 	  $videos .= '<div class="alert">';
// 	  $videos .= __('Apologies, unfortunately your browser does not support either HTML5 video or the used video codec, but you can downlod it directly in the following format(s): ', 'subarrum');
// 	  foreach($types as $type) {
// 	    $src = $url.'.'.$type;
// 	    switch($type) { // now build the source entries
// 	      case 'webm':
// 	      case 'WEBM':
// 		    $videos .= '<a href="'.$src.'" type="video/webm">WEBM </a>';
// 		    break;
// 	      case 'ogv':
// 	      case 'OGV':
// 	      case 'ogg':
// 	      case 'OGG':
// 		    $videos .= '<a href="'.$src.'" type="video/ogg">OGG </a>';
// 		    break;
// 	      case 'mp4':
// 	      case 'MP4':
// 		    $videos .= '<a href="'.$src.'" type="video/mp4">MP4 </a>';
// 		    break;
// 	    }
// 	  }
// 	  $videos .= '</div></video></div>';
// 	}
// 	
// 	// build everything together, videos and the rest of the content
// 	return $videos.$content;
// 
// }




/**
 * Hook into the video embed funtion and add a container for more responsiveness... ;-)
 * 
 * @since Subar Rum 1.0
 * CURRENTLY NOT IN USE
 */
// function subarrum_video_embed_responsive($html, $url, $attr) {
// 	$service = parse_url($url, PHP_URL_HOST);
// 	$service = preg_replace('/\./', '-', $service);
// 	$reg_exEmbed = "/<embed .*>.*<\/embed>/";
// 	$reg_exIframe = "/<iframe .*\/iframe>/";
// 	// find embedded vides and make them responsive
// 	if (preg_match($reg_exIframe, $html, $iframe)) {
// 	    $video = '<div class="embed-container subarrum-extract-video '.$service.'">'. $iframe[0] .'</div>';
// 	    $content = preg_replace($reg_exIframe, $video, $html);
// 	    return $content;
// 	} elseif (preg_match($reg_exEmbed, $html, $embed)) {
// 	  if (!strpos($embed[0], '"display:none"')) {
// 	    $video = '<div class="embed-container subarrum-extract-video '.$service.'">'. $embed[0] .'</div>';
// 	    $content = preg_replace($reg_exEmbed, $video, $html);
// 	    return $content;
// 	  }
// 	} else {
// 	  return $html;
// 	}
// }



/**
 * Hook into content presentation and make embedded stuff, especially videos and iframes, responsive
 * 
 * @param string $content post content
 * 
 * @since Subar Rum 1.0
 */
function subarrum_make_embedded_repsonsive($content) {
	$reg_exIframe = "/<iframe.*\/iframe>/";
	$reg_exEmbed = "/<embed.*\/embed>/";
	$reg_exVideo = "/<video.*\/video>/";
	
	preg_match_all($reg_exIframe, $content, $iframes, PREG_SET_ORDER);
	if ($iframes) {
	  foreach ($iframes as $iframe) {
	  $container = '<div class="embed-container subarrum-responsive-iframe';
	  if (strpos($iframe[0], 'soundcloud')) $container .= " soundcloud-responsive";
	  $container .= '">'. $iframe[0] .'</div>';
	  $pattern =  preg_quote($iframe[0], '/');
	  $content = preg_replace('/'.$pattern.'/', $container, $content);
	  }
	}
	
	preg_match_all($reg_exVideo, $content, $videos, PREG_SET_ORDER);
	if ($videos) {
	  foreach ($videos as $video) {
	  $container = '<div class="embed-container subarrum-responsive-video">'. $video[0] .'</div>';
	  $pattern =  preg_quote($video[0], '/');
	  $content = preg_replace('/'.$pattern.'/', $container, $content);
	  }
	}
	
	preg_match_all($reg_exEmbed, $content, $embeds, PREG_SET_ORDER);
	if ($embeds) {
	  foreach ($embeds as $embed) {
	  $container = '<div class="embed-container subarrum-responsive-embed">'. $embed[0] .'</div>';
	  $pattern =  preg_quote($embed[0], '/');
	  $content = preg_replace('/'.$pattern.'/', $container, $content);
	  }
	}
	
	return $content;
}



/**
 * Get an excerpt by id outside the loop
 * 
 * @param integer $id post id
 * @param integer $length excerpt length in words
 *
 * @since Subar Rum 1.0
 */
function subarrum_get_excerpt($id, $length = 30) {
	$item = get_post(absint($id), ARRAY_A);
	$length = absint($length);
	
	$excerpt = ($item['post_excerpt']) ? $item['post_excerpt'] : $item['post_content'];
	$excerpt = strip_tags(strip_shortcodes($excerpt));
	
	$words = explode(' ', $excerpt, $length +1);
	if (count($words) > $length) {
		array_pop($words);
		array_push($words, '...');
		$excerpt = implode(' ', $words);
	}
	return $excerpt;
}



/**
 * function to integrate the comment reply script only when needed
 * 
 * @since Subar Rum 1.0
 */
function subarrum_enqueue_comments_reply() {
	if (get_option('threaded_comments'))
	  wp_enqueue_script('comment-reply');
}


/**
 * Subar Rum Thumbnail shortcode
 *
 * This makes the Bootstrap2 thumbnail code available via a shortcode.
 * Attributes:
 * src = image source
 * link = link for the image
 * label = thumbnail label
 * caption = thumbnail caption
 *
 * @since Subar Rum 1.3.0
 * @param array $attr Atrributes of the shortcode
 * @return string HTML content to display
 */
function subarrum_thumbnail_shortcode($attr) {
        extract(shortcode_atts(array(
                'src'       => '',
                'label'     => '',
                'caption'   => '',
                'link'      => '#'
        ), $attr, 'sr_thumbnail'));
        
        if ($src == '') { return ""; };
        
        if ($label != '' || $caption != '') {
        
                $output = "\n<div class='thumbnail'>\n";
                $output .= "<a href='". $link ."'>";
                $output .= "<img src='". $src ."' alt='' />";
                $output .= "</a>\n";
                if ($label != '') {
                        $output .= "<h4>". $label ."</h4>\n";
                }
                if ($caption != '') {
                        $output .= "<p>". $caption ."</p>\n";
                }
                $output .= "</div>\n";
            
        } else {
                $output  = "\n<a href='". $link ."' class='thumbnail'>\n";
                $output .= "<img src='". $src ."' alt'' />";
                $output .= "</a>\n";
        };
        
        return $output;
};



/**
 * Subar Rum Add Excerpt to pages
 * 
 * Adds the excerpt field to page for use in gallery overview shortcode.
 *
 * @since Subar Rum 1.3.0
 */
function subarrum_add_excerpt_to_ages() {
        add_post_type_support( 'page', 'excerpt' );
};





/**
 * Subar Rum gallery overview private function
 *
 * Takes page ID or list of page IDs to generate a gallery overview, consisting of
 * post tumbunail, excerpt and page permalink.
 * 
 * Used internally by 
 *
 * @since Subar Rum 1.3.0
 * @param array $ids page IDs
 * @param int $page_id current page ID
 * @param int $columns column count
 * @return string HTML content to display gallery overview
 */
function subarrum_gallery_overview_private($ids = null, $page_id = null, $columns = 3, $style = '') {

        global $content_width;
        $_pages = array();

        if (is_null($ids) && is_null($page_id)) {
    
            return "";
            
        } elseif (is_null($ids) || empty($ids)) {
            
            $_pages = get_pages( array('hierarchical' => 'false', 'parent' => $page_id) );
            
        } else {
    
            $_pages = get_pages( array('include' => $ids) );
            
        }
        
        if (is_null($_pages)) {
                return "";
        }
        
        if ($style == '') {
                $style = get_theme_mod('gallery_overview_style', 'grid');
        }
        
        
        $output = "";
        
        
        if ($style == 'list') {
        
        
                
                
                foreach($_pages as $page) {
                        $_thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'thumbnail');
                        $_page_link = get_permalink($page);
                
                        $output .= "<div class='media'>\n";
                
                        $output .= "<a class='pull-left' href='{$_page_link}'>";
//                         $output .= "<img class='media-object' src='". esc_url( $_thumb_image_url[0] ) ."' width='". $_thumb_image_url[1] ."' height='". $_thumb_image_url[3] ."' alt='". $page->post_title ."' /></a>\n";
                        $output .= "<img class='media-object' src='". esc_url( $_thumb_image_url[0] ) ."' width='96' height='96' alt='". $page->post_title ."' /></a>\n";
                        
                        $output .= "<div class='media-body'>\n";
                        $output .= "<h4 class='media-heading'>{$page->post_title}</h4>\n";
                        $output .= "{$page->post_excerpt}\n";
                        $output .= "</div>\n";
                        
                        
                        $output .= "</div>\n";
                }
        
        
        } else {
    
    
                $size = 'post-image-full';
                switch($content_width) {
                        case 630:
                        case 460:
                        case 300:
                                $size = 'post-image-full';
                                break;
                        case 960:
                                $size = 'post-image-full-width';
                }
                
                $span = "span4";
                switch($columns) {
                        case 0:
                        case 1:
                                $span = "span12";
                                break;
                        case 2:
                                $span = "span6";
                                break;
                        case 3:
                                $span = "span4";
                                break;
                        case 4:
                                $span = "span3";
                                break;
                        case 5:
                        case 6:
                                $span = "span2";
                                break;
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                        case 12:
                                $span = "span1";
                }
                

                $output = "\n<ul class='thumbnails'>\n";

                $i = 0;
                foreach ($_pages as $page) {
                
                        $output .= "<li class='".$span."'>\n";
                        
                        $output .= "<div class='thumbnail'>\n";
                        
                        $thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), $size);
                        $page_link = get_permalink($page);
                        
                        $output .= "<a href='{$page_link}'>";
                        
                        $output .= "<img src='". esc_url( $thumb_image_url[0] ) ."' width='". $thumb_image_url[1] ."' height='". $thumb_image_url[3] ."' alt='". $page->post_title ."' /></a>\n";
                        
                        $output .= "<h4>{$page->post_title}</h4>\n";
                        
                        $output .= "<p>{$page->post_excerpt}</p>\n";
                        
                        
                        $output .= "</div>\n";                
                        
                        $output .= "</li>\n";
                
                
                        if ( $columns > 0 && ++$i % $columns == 0 )
                                $output .= "</ul>\n<ul class='thumbnails'>";
                    
                }
                
                $output .= "</ul>\n";
        
        }
    
        return $output;
}



function subarrum_get_gallery_overview($columns = 3) {
        
        $_page = get_post();
        $page_id = $_page->ID;
        
        echo subarrum_gallery_overview_private(null, $page_id, $columns);
        
};


 
/**
 * Subar Rum gallery overview shortcode
 *
 * Generates a Bootstrap style thumbnail gallery linking to the respective
 * pages. Uses page excerpt and page image.
 *
 * @since Subar Rum 1.3.0
 */
function subarrum_gallery_overview($attr = null) {

        $columns = 3;
        $ids = array();
        $style = '';

        extract(shortcode_atts(array(
                        'ids'       => '',
                        'columns'   => 3,
                        'style'     => ''
               ), $attr, 'sr_gallery_overview'));
               
        $page_id = null;
               
        if (empty($ids)) {
                $_page = get_post();
                echo var_dump($_page);
                $page_id = $_page->ID;
        }
        
        echo var_dump($_page->ID);
        
        return subarrum_gallery_overview_private($ids, $page_id, $columns, $style);
}


/**
 * Subar Rum Gallery shortcode.
 *
 * This reimplements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since Subar Rum 1.2.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function subarrum_gallery_shortcode($attr) {
	global $content_width;
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'type'       => '',
		'rowheight'  => 120,
		'justifylastrow' => 'true',
		'fixedheight' => 'false',
		'captions'   => 'true',
		'columns'    => 3,
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery'));
	
	$_captions = ($captions == 'true') ? true : false;
	$_fixedHeight = ($fixedheight == 'true') ? true : false;
	$_justifyLastRow = ($justifylastrow == 'true') ? true : false;
	
	$size = 'post-image-full';
	switch($content_width) {
		case 630:
		case 460:
		case 300:
			$size = 'post-image-full';
			break;
		case 960:
			$size = 'post-image-full-width';
	}

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$columns = intval($columns);
	$float = is_rtl() ? 'right' : 'left';
	
	$selector = "gallery-{$instance}";


	if ($type == 'rectangular' || $type == 'square') {

		wp_enqueue_style( 'justified-gallery-css' );
		wp_enqueue_script( 'justified-gallery' );
		
		$output = "\n<div id='".$selector."'>\n";
		
		$_size = ($type == 'rectangular') ? $size : 'thumbnail';
		
		foreach ( $attachments as $id => $attachment ) {
		
			$thumb_image_url = wp_get_attachment_image_src( $id, $_size);
			$full_image_url = wp_get_attachment_image_src( $id, 'full');
			
			$caption = '';
			if ( ! empty($attachment->post_excerpt) ) {
				$caption = $attachment->post_excerpt;
			} else {
				$caption = $attachment->post_title;
			}
				
			$output .= '<a href="';
			$output .= ( ! empty( $link ) && 'file' === $link ) ? esc_url( $full_image_url[0] ) . '" ' : esc_url( get_permalink(get_post($id))) . '" '; // link to image url or to image page
			$output .= ( ! empty( $link ) && 'file' === $link ) ? 'rel="lightbox['.$selector.']" ' : ''; // add lightbox or not
			$output .= 'title="'. wptexturize($caption) .'">';
			
			$output .= '<img src="'. esc_url( $thumb_image_url[0] ) .'" alt="'. wptexturize($caption) .'" /></a>';
			$output .= "\n";
		}
		
		
		$output .= "</div>\n";
		
		
		$output .= '<script type="text/javascript">';
		
		$output .= 'jQuery("#'.$selector.'").justifiedGallery({
                "sizeRangeSuffixes" : {
                        "lt100":"",
                        "lt240":"",
                        "lt320":"",
                        "lt500":"",
                        "lt640":"",
                        "lt1024":""},';
                if (!$_captions) $output .= '"captions":false,';
                if ($_fixedHeight) $output .= '"fixedHeight":true,';
                if (!$_justifyLastRow) $output .= '"justifyLastRow":false,';
                $output .= '"rowHeight":' . $rowheight . ',';
                $output .= '"margins":2});';
		
		$output .= "</script>\n";
		
	} else {
	
		$span = "span4";
		switch($columns) {
			case 0:
			case 1:
				$span = "span12";
				break;
			case 2:
				$span = "span6";
				break;
			case 3:
				$span = "span4";
				break;
			case 4:
				$span = "span3";
				break;
			case 5:
			case 6:
				$span = "span2";
				break;
			case 7:
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
				$span = "span1";
		}

		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_stlye = "";

		$size_class = sanitize_html_class( $size );
		$gallery_div = "\n<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>\n";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
		$output .= "<ul class='thumbnails'>\n";

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $link ) && 'file' === $link )
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			elseif ( ! empty( $link ) && 'none' === $link )
				$image_output = wp_get_attachment_image( $id, $size, false );
			else
				$image_output = wp_get_attachment_link( $id, $size, true, false );

			$output .= "<li class='".$span."'>";
			if ($_captions)
				$output .= "<div class='thumbnail'>";
			$output .= $image_output;
			if ( $_captions && trim($attachment->post_excerpt) ) {
				$output .= "
					<p>
					" . wptexturize($attachment->post_excerpt) . "
					</p>";
			}
			if ($_captions)
				$output .= "</div>";
			$output .= "</li>\n";
			if ( $columns > 0 && ++$i % $columns == 0 )
				$output .= "</ul>\n<ul class='thumbnails'>";
		}

		$output .= "
				</ul>
			</div>\n";
	}

	return $output;
}
?>