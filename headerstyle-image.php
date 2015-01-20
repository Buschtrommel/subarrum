<?php 
/**
 * Header Image
 *
 * Integrates the code for the custom header image into the header.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>

<style type="text/css">
.headerimagecontainer {
  width: <?php echo get_custom_header()->width; ?>;
  height: <?php echo get_custom_header()->height; ?>;
  position: relative;
}

.headerimagecontainer a,
.headertextcontainer a {
  color: #<?php echo get_theme_mod('header_textcolor', '000000'); ?>;
}
</style>

    <?php if (get_custom_header()->url) : ?>
	<div class="headerimagecontainer">
	  <img src="<?php header_image(); ?>" alt="Header Image" class="headerimage" />
	  <?php if (get_theme_mod('header_textcolor', '000000') != 'blank') : ?>
	    <a href="<?php echo site_url(); ?>"><h2><?php bloginfo('name'); ?></h2>
	    <h3><?php bloginfo('description'); ?></h3></a>
	  <?php endif; ?>
	</div>
    <?php elseif (get_theme_mod('header_textcolor', '000000') != 'blank') : ?>
	<div class="headertextcontainer">
	  <a href="<?php echo site_url(); ?>">
	    <h2 class="header"><?php bloginfo('name'); ?> <small><?php bloginfo('description'); ?></small></h2>
	  </a>
	</div>
    <?php endif; ?>