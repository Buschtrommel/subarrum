<?php 
/**
 * Gallery Sidebar
 *
 * Displays the entries in the galley sidebar, used in the gallery page template.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<div style="margin-top:27px;"></div>
	<?php if ( is_active_sidebar( 'gallery' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'gallery' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
