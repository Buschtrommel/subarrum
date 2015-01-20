<?php 
/**
 * Single Template
 *
 * Main template for displaying single posts.
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
  <?php if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'entries-1' ) ) : ?>
  <div class="span8">
  <?php else: ?>
  <div class="span12">
  <?php endif; ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	  
	  /* Include the post format-specific template for the content. If you want to
	   * this in a child theme then include a file called called content-___.php
	   * (where ___ is the post format) and that will be used instead.
	   */
	  get_template_part( 'content', get_post_format() ); ?>
	  
	  <nav class="nav-single">
	    <ul class="pager">
	      <li class="previous">
		<?php next_post_link( '%link', '<span class="meta-nav">&larr;<span class="hidden-phone"> %title</span></span>' ); ?>
	      </li>
	      <li class="next">
		<?php previous_post_link( '%link', '<span class="meta-nav"><span class="hidden-phone">%title </span>&rarr;</span>' ); ?>
	      </li>
	    </ul>
	  </nav><!-- .nav-single -->

	<ul id="commSimTabs" class="nav nav-tabs">
	  <li class="active"><a href="#comments" data-toggle="tab"><?php _e('Comments', 'subarrum'); ?></a></li>
	  <li><a href="#similar" data-toggle="tab"><?php _e('Similar posts', 'subarrum'); ?></a></li>
	  <?php if (is_multi_author() || (get_theme_mod('author_info')) ) : ?>
	  <li><a href="#aboutauthor" data-toggle="tab"><?php _e('Author', 'subarrum'); ?></a></li>
	  <?php endif; ?>
	</ul>
	<div id="commSimTabsContent" class="tab-content">
	  <div class="tab-pane fade active in" id="comments"><?php comments_template(); ?></div>
	  <div class="tab-pane fade" id="similar"><?php subarrum_get_similar_posts(); ?></div>
	  <?php if (is_multi_author() || (get_theme_mod('author_info')) ) : ?>
	  <div class="tab-pane fade" id="aboutauthor"><?php get_template_part('info', 'author'); ?></div>
	  <?php endif; ?>
	</div>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	<?php endif; ?>
  </div>
  
  <?php if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'entries-1' ) ) : ?>
    <div class="span4">
	<?php get_sidebar('entries'); ?>
    </div>
  <?php endif; ?>
</div>


<?php get_footer(); ?>