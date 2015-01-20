<?php 
/**
 * Template Name: Gallery with Gallery Sidebar
 *
 * Description: A page template that provides a page template with an own sidebar (gallery).
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */


get_header();?>

	<div id="content" class="row-fluid">
	  <?php if ( is_active_sidebar( 'gallery' ) ) : ?>
	  <div class="span8">
	  <?php else : ?>
	  <div class="span12">
	  <?php endif; ?>

	  <?php if ( have_posts() ) :
	  
		    while ( have_posts() ) : 
			
			the_post();
			/* Include the post format-specific template for the content. If you want to
			 * this in a child theme then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', 'page' );

		    endwhile;
		
		else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	  <?php endif; ?>
	 
	  </div>
      <?php if ( is_active_sidebar( 'gallery' ) ) : ?>
	<div class="span4">
	  <?php get_sidebar('gallery'); ?>
	</div>
      <?php endif; ?>
      </div>
      
<?php get_footer(); ?>