<?php 
/**
 * Footer Sidebar
 *
 * Displays the entries in the two footer sidebars. First checks if there
 * are more than four widgets, becaus footer sidebars are designed to hold
 * a maximum of four widgets.
 * A short JavaScript snippet adds the appropriate classes to the entries.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
	  <hr />
	  <?php $the_sidebars = wp_get_sidebars_widgets();
	        $widgetcount = count( $the_sidebars['footer-1'] ); ?>
	  <?php if ( $widgetcount <= 4 ) : ?>
		
		<div id="footerbar1" class="widget-area row-fluid" role="complementary">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
		<script type="text/javascript">
		    var widgets = "<?php echo $widgetcount; ?>";
		    switch (widgets) {
		      case "1":
			jQuery("#footerbar1 aside").addClass("span12");
			break;
		      case "2":
			jQuery("#footerbar1 aside").addClass("span6");
			break;
		      case "3":
			jQuery("#footerbar1 aside").addClass("span4");
			break;
		      case "4":
			jQuery("#footerbar1 aside").addClass("span3");
			break;
		    }
		</script>
	  <?php else : ?>
		<div class="alert alert-block alert-error">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4><?php _e( 'Warning!', 'subarrum' ); ?></h4>
		  <?php _e( 'Apologies, but there are more than four widgets set for Footer Area 1. This area is only designed for a maximum of four widgets.', 'subarrum' ); ?>
		</div>
	  <?php endif; ?>
	  
	<?php endif; ?>
	
	
	<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
	  <hr />
	  <?php $the_sidebars = wp_get_sidebars_widgets();
	        $widgetcount = count( $the_sidebars['footer-2'] ); ?>
	  <?php if ( $widgetcount <= 4 ) : ?>
		
		<div id="footerbar2" class="widget-area row-fluid" role="complementary">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
		<script type="text/javascript">
		    var widgets = "<?php echo $widgetcount; ?>";
		    switch (widgets) {
		      case "1":
			jQuery("#footerbar2 aside").addClass("span12");
			break;
		      case "2":
			jQuery("#footerbar2 aside").addClass("span6");
			break;
		      case "3":
			jQuery("#footerbar2 aside").addClass("span4");
			break;
		      case "4":
			jQuery("#footerbar2 aside").addClass("span3");
			break;
		    }
		</script>
	  <?php else : ?>
		<div class="alert alert-block alert-error">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4><?php _e( 'Warning!', 'subarrum' ); ?></h4>
		  <?php _e( 'Apologies, but there are more than four widgets set for Footer Area 2. This area is only designed for a maximum of four widgets.', 'subarrum' ); ?>
		</div>
	  <?php endif; ?>

	<?php endif; ?>