<?php 
/**
 * Entries Sidebar
 *
 * Displays the entries in the entries widget area. If that is empty
 * it displays the default sidebar.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<hr class="visible-phone" />
	<div style="margin-top:20px;"></div>
	<?php if ( is_active_sidebar( 'entries-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'entries-1' ); ?>
		</div><!-- #secondary -->
	<?php else : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>