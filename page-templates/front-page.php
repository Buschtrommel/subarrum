<?php 
/**
 * Template Name: Front Page
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Subar Rum consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */


get_header();?>

	<div id="content" class="row-fluid front-page with-title">
	  <div class="span12">

	  <?php if ( have_posts() ) :
	  
		    while ( have_posts() ) : 
			
			the_post();
			/* Include the post format-specific template for the content. If you want to
			 * this in a child theme then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			if ( has_post_thumbnail() ) : ?>
			<div class="span5 post-thumbnail">
			<?php subarrum_post_thumbnail($thumbsize = 'post-image-full', $caption = '0') ?>
			</div>
			<div class="span7">
			<?php get_template_part( 'content', 'page' ); ?>
			</div>
			<?php else :
			
			get_template_part( 'content', 'page' );
			
			endif;

		    endwhile;
		
		else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	  <?php endif; ?>
	 
	  </div>
	</div>

<?php get_footer(); ?>