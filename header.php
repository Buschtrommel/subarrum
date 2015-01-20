<?php 
/**
 * Header part
 *
 * Displays the header part of the template
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="description" content="<?php bloginfo( 'description' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?php bloginfo('name'); ?><?php wp_title( '|', true, 'left' ); ?></title>
    
    <?php if (get_theme_mod('set_favicon', 0)) : ?>
    <?php $filetype = wp_check_filetype(get_theme_mod('set_favicon')); ?>
    <link rel="icon" href="<?php echo get_theme_mod('set_favicon'); ?>" type="<?php echo $filetype['type']; ?>" />
    <?php endif; ?>
    
    <?php wp_head(); ?>
  </head>
  
  <?php $classes = (get_theme_mod('two_columns_enable', 0)) ? '2col' : '1col'; ?>
  <body <?php body_class($classes); ?>>

  <?php if (get_theme_mod('navbar_position', 'navbar-fixed-top') != 'navbar-disabled') : ?>
  <div id="navbar" class="<?php echo get_theme_mod( 'navbar_base_color', 'navbar' ); ?> <?php echo get_theme_mod('navbar_position', 'navbar-fixed-top'); ?>">
    <div class="navbar-inner">
      <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-menu">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="<?php echo site_url(); ?>"><strong><?php bloginfo('name'); ?></strong> <small><em><?php bloginfo('description'); ?></em></small></a>
          
	    <?php if(has_nav_menu('navbar')) wp_nav_menu( array( 'theme_location' => 'navbar',
				      'menu_class' => 'nav pull-right',
				      'container_class' => 'navbar-menu nav-collapse collapse navbar-responsive-collapse',
				      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				      'walker' => new subarrum_walker_nav_menu
				      ) ); ?>
	    <?php if(!has_nav_menu('navbar')) : ?>
	     <div class="navbar-menu nav-collapse collapse navbar-responsive-collapse">
	      <form class="navbar-search pull-right" action="/" method="get">
		  <input class="search-query" placeholder="<?php _e('Search', 'subarrum'); ?>..." type="text" name="s" id="search" value="<?php get_search_query(); ?>" />
	      </form>
	     </div>
	    <?php endif; ?>	      

      </div>
    </div>
  </div>
  <?php endif; ?>
  
  
  <div class="body">
    <div class="container">
      <?php // check which type of header it should show
      
	$headerstyle = get_theme_mod('header_type', 'image');
	if (is_home()) {
		if (get_theme_mod('header_show_front', 1)) get_template_part('headerstyle', $headerstyle);
	} elseif (is_front_page()) {
		if (get_theme_mod('header_show_static', 0)) get_template_part('headerstyle', $headerstyle);
	} else {
		if (get_theme_mod('header_show_other', 0)) get_template_part('headerstyle', $headerstyle);
	}
      
      
      ?>
      
      <?php if (has_nav_menu('primary')) : ?>
		<div id="primary-menu">
		    <a class="btn btn-medium hidden-desktop" data-toggle="collapse" data-target=".primary-menu"><i class="icon-reorder grey"></i></a>
		    <?php wp_nav_menu( array( 'theme_location' => 'primary',
				      'menu_class' => 'nav nav-pills',
				      'container_class' => 'primary-menu nav-collapse',
				      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				      'walker' => new subarrum_walker_nav_menu
				      ) ); ?>
		</div>
      <?php endif; ?>
      