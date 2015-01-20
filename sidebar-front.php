<?php 
/**
 * Frontpate Sidebar
 *
 * Displays the entries in the two front page sidebars.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

if ( ! is_active_sidebar( 'front-1' ) && ! is_active_sidebar( 'front-2' ) )
	return;

?>

<hr />
<div id="front-page-widget-area" class="row-fluid widget-area" role="complementary">
	<div class="span6 first front-widgets">
	<?php if ( is_active_sidebar( 'front-1' ) ) : ?>
		<?php dynamic_sidebar( 'front-1' ); ?>
	<?php endif; ?>
	</div>

	<div class="span6 second front-widgets">
	<?php if ( is_active_sidebar( 'front-2' ) ) : ?>
		<?php dynamic_sidebar( 'front-2' ); ?>
	<?php endif; ?>
	</div>
</div>