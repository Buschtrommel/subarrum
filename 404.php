<?php 
/**
 * 404 Error template
 *
 * Shows up when a site is not found and presents a search form and a
 * button for a random post.
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
  <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
  <div class="span8">
  <?php else: ?>
  <div class="span12">
  <?php endif; ?>

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header row-fluid">
				    <div class="span12">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'subarrum' ); ?></h1>
				    </div>
				</header>

				<div class="entry-content row-fluid">
				    <div class="row-fluid">
					<div class="span12 alert alert-error"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'subarrum' ); ?></div>
				    </div>
				    <div class="row-fluid">
					<div class="span6">
					  <?php get_search_form(); ?>
					</div>
					<div class="span6">
					  <?php subarrum_get_random_post(__('Or try your luck and hit or miss', 'subarrum')); ?>
					</div>
				    </div>
				</div>
			</article>
			
  </div>
  
  <?php if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'entries-1' ) ) : ?>
    <div class="span4">
	<?php get_sidebar('entries'); ?>
    </div>
  <?php endif; ?>
</div>


<?php get_footer(); ?>