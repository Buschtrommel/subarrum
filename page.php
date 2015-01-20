<?php 
/**
 * Page template
 *
 * Base page template for default presentation of pages.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

 get_header(); ?>

<div class="row-fluid">
  <?php if ( is_active_sidebar( 'sidebar-1' ) || ( is_active_sidebar( 'entries-1' ) || s_active_sidebar( 'pages-1' ) ) ) : ?>
  <div class="span8">
  <?php else: ?>
  <div class="span12">
  <?php endif; ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    
		      <?php get_template_part( 'content', 'page' ); ?>
	  
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	<?php endif; ?>
  </div>
  
  <?php if ( is_active_sidebar( 'sidebar-1' ) || ( is_active_sidebar( 'entries-1' ) || s_active_sidebar( 'pages-1' ) ) ): ?>
    <div class="span4">
	<?php get_sidebar('pages'); ?>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>