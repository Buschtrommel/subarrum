<?php 
/**
 * Pages Sidebar
 *
 * Displays the entries in the pages widget area. If that is empty
 * it displays the entries sidebar. If that is also empty, it displays
 * the default sidebar entries.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<div style="margin-top:20px;"></div>
	<?php if ( is_active_sidebar( 'pages-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'pages-1' ); ?>
		</div><!-- #secondary -->
	<?php elseif ( is_active_sidebar( 'entries-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'entries-1' ); ?>
		</div><!-- #secondary -->
	<?php else : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>