<?php 
/**
 * image format template
 *
 * Shows up when a post in image format is presented.
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
	    <article  id="post-<?php the_ID(); ?>" <?php post_class($margin_top); ?>>

		<!-- Start content -->
		<div class="entry-content row-fluid">
		  <div class="span12">
		    <?php
		      if (has_post_thumbnail()) {
			if (is_singular() && (is_active_sidebar('sidebar-1') || is_active_sidebar('entries-1')))
				$thumbsize = 'post-image-full';
			if (is_singular() && (!is_active_sidebar('sidebar-1') and !is_active_sidebar('entries-1')))
				$thumbsize = 'post-image-wide';
			if (!is_singular() && (is_active_sidebar('sidebar-1') || is_active_sidebar('entries-1')))
				$thumbsize = 'post-image-full';
			if (!is_singular() && (!is_active_sidebar('sidebar-1') and !is_active_sidebar('entries-1')))
				$thumbsize = 'post-image-wide';
			
				subarrum_post_thumbnail($thumbsize, $caption = 0);
				subarrum_entry_meta($style = 'popover');
				?>
				<i class="icon-picture grey"></i> <i><a href="<?php the_permalink(); ?>" class="grey"><?php the_title(); ?></a></i>
				<?php
		      } elseif (!has_post_thumbnail()) {
				the_content();
				subarrum_entry_meta($style = 'popover');
				?>
				<i class="icon-picture grey"></i> <i><a href="<?php the_permalink(); ?>" class="grey"><?php the_title(); ?></a></i>
				<?php
		      }
		    ?>
		  </div>
		</div>

		<!-- Start footer -->
		<footer class="entry-meta row-fluid">
		  <div class="span12">
			<?php if (!(get_theme_mod('two_columns_enable', 0))) echo '<hr />'; ?>
		  </div>
		</footer>
	    </article>