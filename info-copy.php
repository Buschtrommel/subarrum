<?php 
/**
 * Copyright info
 *
 * Displays the site copyright and the credits in the footer.
 * Would be nice if you will show the credits to the theme author. :)
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<hr />
	<div class="row-fluid">
	  <div class="span12">
		<?php if (get_theme_mod('footer_show_copy', 1)) : ?>
		  <div class="pull-left copyright">
		    <small class="grey">&copy; 
		    <?php if (get_theme_mod('footer_copy_link', 0)) : ?>
		    <a href="<?php echo get_permalink(get_theme_mod('footer_copy_link', 0)); ?>"><?php bloginfo('name'); ?></a>
		    <?php else : bloginfo('name'); endif; ?>
		    </small>
		  </div>
		<?php endif; ?>
		<?php if (get_theme_mod('footer_show_credits', 1)) : ?>
		  <div class="pull-right credits">
		    <small class="grey">
		      <?php printf(__('Powered by %1$s, Theme %2$s', 'subarrum'), '<a href="http://www.wordpress.org">WordPress</a>', '<a href="http://www.buschmann23.de/entwicklung/wordpress/themes/subar-rum/">Subar Rum</a>'); ?>
		    </small>
		  </div>
		<?php endif; ?>
	  </div>
	</div>