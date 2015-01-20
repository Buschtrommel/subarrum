<?php 
/**
 * Search form
 *
 * Displays the search form
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>

<form class="form-inline" action="/" method="get">
	<div class="input-append">
	<input class="input-medium" placeholder="<?php _e('Search', 'subarrum'); ?>..." type="text" name="s" id="search" value="<?php get_search_query(); ?>" />
	<button type="submit" id="searchsubmit" value="<?php _e('Search', 'subarrum'); ?>" class="btn"><i class="icon-search"></i> <span class="hidden-tablet"><?php _e('Search', 'subarrum'); ?></span></button>
	</div>
</form>