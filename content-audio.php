<?php 
/**
 * audio post template
 *
 * Shows posts in audio format.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

$margin_top = is_singular() ? 'content-singular' : 'content-blog';
?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class($margin_top); ?>>

		<!-- Start heading -->
		<header class="entry-header">
		 <div class="row-fluid">
		  <div class="span11">
		    <?php if (is_singular()) : ?>
		    <h1 class="hidden-phone"><i class="icon-volume-up grey"></i> <?php the_title(); ?></h1>
		    <h3 class="visible-phone"><i class="icon-volume-up grey"></i> <?php the_title(); ?></h3>
		    <?php else : ?>
		    <h3><i class="icon-volume-up grey"></i> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		    <?php endif; ?>
		  </div>
		  <?php if (get_theme_mod('meta_data_style', 'icons') == 'popover' ) : ?>
		  <div class="span1" style="margin-top:<?php echo is_singular() ? '20' : '10' ?>px;">
		    <?php subarrum_entry_meta(); ?>
		  </div>
		  <?php else : ?>
		  <div class="span1 hasTip hidden-phone" style="margin-top:<?php echo is_singular() ? '20' : '10'; ?>px;" data-placement="left" title="<?php comments_number(); ?>">
		    <a href="<?php the_permalink(); ?>#comments">
		      <span class="badge pull-right"><i class="icon-comments"></i> <?php comments_number('0', '1', '%'); ?></span>
		    </a>
		  </div>
		  <?php endif; ?>
		 </div>
		 <?php if ((get_theme_mod('meta_data_position', 'footer') == 'header') && (get_theme_mod('meta_data_style', 'icons') != 'popover' )) : ?>
		    <?php subarrum_entry_meta(); ?>
		 <?php endif; ?>
		</header>		
		
		<!-- Start content -->
		<div class="entry-content row-fluid">
		  <div class="span12">
			
			<?php the_content(); ?>
			
		  </div>
		</div>

		<!-- Start footer -->
		<footer class="entry-meta row-fluid">
		  <div class="span12">
		  <?php if ((get_theme_mod('meta_data_position', 'footer') == 'footer') && (get_theme_mod('meta_data_style', 'icons') != 'popover' )) {
			subarrum_entry_meta(); }
			subarrum_wp_link_pages(); ?>
			<?php if (!(get_theme_mod('two_columns_enable', 0))) echo '<hr />'; ?>
		  </div>
		</footer>
	    </article>