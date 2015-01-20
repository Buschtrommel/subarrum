<?php 
/**
 * Home Template
 *
 * Base template for blog layout presentation of the home page.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

get_header(); global $paged;?>

	<div id="content" class="row-fluid">
	  <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	  <div class="span8">
	  <?php else: ?>
	  <div class="span12">
	  <?php endif; ?>
	  <?php if ( have_posts() ) :
	  
		  $two_columns_enable = get_theme_mod('two_columns_enable', 0);
	  
		  if (!$two_columns_enable) :
		    while ( have_posts() ) : 
			
			the_post();
			/* Include the post format-specific template for the content. If you want to
			 * this in a child theme then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );

		    endwhile;
		  elseif ($two_columns_enable) :
		    $dpp = $wp_query->post_count; //displayed posts
		    $count = 0;
		    $row = 1;
		    while ( have_posts() ) : 
			$count++;
			if ($count % 2 != 0) :
			echo '<div class="row-fluid two-col-row">';
			endif;
			if (($row % 2 != 0) && ($count % 2 != 0)) :
			echo '<div class="span6 two-col-box light-back">';
			elseif (($row % 2 != 0) && ($count % 2 == 0)) :
			echo '<div class="span6 two-col-box dark-back">';
			elseif (($row %2 == 0) && ($count % 2 != 0)) :
			echo '<div class="span6 two-col-box dark-back">';
			elseif (($row %2 == 0) && ($count % 2 == 0)) :
			echo '<div class="span6 two-col-box light-back"">';
			endif;
			the_post();
			/* Include the post format-specific template for the content. If you want to
			 * this in a child theme then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );
			echo '</div>';
			if ($count % 2 != 0) :
			echo '<div class="visible-phone two-col-row"></div>';
			endif;
			if ($count % 2 == 0) :
			$row++;
			echo '</div>';
			endif;
		    endwhile;
		    
		    if ($dpp % 2 != 0) :
			echo '<div class="span6"></div></div>';
		    endif;
		  endif;
		
		else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	  <?php endif; ?>
	  <?php subarrum_paginate_links( 'nav-below' ); ?>
	 
	  </div>
	
	  <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	  <div class="span4">
		<?php get_sidebar(); ?>
	  </div>
	  <?php endif; ?>
	</div>

<?php get_footer(); ?>