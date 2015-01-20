<?php 
/**
 * Default Sidebar
 *
 * The default sidebar is displayed on the blog layout pages (home/archive/etc.)
 * and on the other pages and single posts when there are no widgets set in the
 * sidebars.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<div style="margin-top:10px;"></div>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>