<?php 
/**
 * Default page template
 *
 * Displays default pages.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

 global $page;
 $margin_top = is_singular() ? 'content-singular' : 'content-blog';
?>
	    <article  id="post-<?php the_ID(); ?>" <?php post_class($margin_top); ?>>

		<!-- Start heading -->
	    <header class="entry-header row-fluid">
	      <div class="span12">
		<h1 class="hidden-phone"><?php the_title(); ?></h1>
		<h3 class="visible-phone"><?php the_title(); ?></h3>
	      </div>
	    </header>
		
	    <!-- Start content -->
	    <div class="entry-content row-fluid">
	      <div class="span12">
		<?php
		if (!( is_page_template('page-templates/front-page.php') || is_page_template('page-templates/front-page-no-title.php') || is_page_template('page-templates/gallery.php') )) {
		  if ($page < 2) {
		    if ( is_active_sidebar( 'sidebar-1' ) || ( is_active_sidebar( 'entries-1' ) || is_active_sidebar( 'pages-1' ) ) ) {
		      if ( has_post_thumbnail()) { subarrum_post_thumbnail('post-image-full'); } 
		    } else { 
		      if ( has_post_thumbnail()) { subarrum_post_thumbnail('post-image-wide'); } 
		    }
		  }
		}
		if (is_search()) {
		  the_excerpt();
		} else {
		  the_content();
		  if (is_page_template('page-templates/gallery.php')) {
                    subarrum_get_gallery_overview();
		  }
		}
		?>
	      </div>
	    </div>
	    
	    <!-- Start footer -->
	    <footer class="entry-meta row-fluid" style="margin-top:5px">
	      <div class="span12">
		<?php subarrum_wp_link_pages(); ?>
	      </div>
	    </footer>
		
	  </article>
	  
		
	<!-- check wether comments should be shown -->
	<?php if (get_theme_mod('page_comments')) : ?>
	  <hr />
	  <?php comments_template(); ?>
	<?php endif; ?>