<?php 
/**
 * Image template
 *
 * Displays image attachments with more information and full width
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
get_header(); ?>


<div class="row-fluid">
  <div class="span12">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	  <article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
	    
	    <!-- Start heading -->
	    <header class="entry-header row-fluid">
	      <?php if (get_theme_mod('meta_data_style', 'icons') == 'popover' ) : ?>
	      <div class="span11">
		<h1 class="hidden-phone"><?php the_title(); ?></h1>
		<h3 class="visible-phone"><?php the_title(); ?></h3>
	      </div>
	      <div class='span1' style='margin-top:10px;'>
		<?php subarrum_entry_meta(); ?>
	      </div>
	      <?php else : ?>
	      <div class="span12">
		<h1 class="hidden-phone"><?php the_title(); ?></h1>
		<h3 class="visible-phone"><?php the_title(); ?></h3>
	      </div>
	      <?php endif; ?>
	      <?php if ((get_theme_mod('meta_data_position', 'footer') == 'header') && (get_theme_mod('meta_data_style', 'icons') != 'popover' )) : ?>
		    <?php subarrum_entry_meta(); ?>
		  <?php endif; ?>
	    </header>
		
	    <!-- Start content -->
	    <div class="entry-content row-fluid">
	      <div class="span12">
	        <?php subarrum_post_thumbnail($thumbsize = 'post-image-full-width', $caption = 1); ?>
		
		<?php the_content(); ?>
				
		<div class="image-metadata">
		<h4><?php _e('Metadata', 'subarrum') ?></h4>
		
		<?php $metadata = wp_get_attachment_metadata();?>
		<table class="table table-striped">
		  <?php if ($metadata['image_meta']['title']) : ?>
		    <tr>
		      <td><b><?php _e('Title', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['title']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['caption']) : ?>
		    <tr>
		      <td><b><?php _e('Caption', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['caption']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['credit']) : ?>
		    <tr>
		      <td><b><?php _e('Credit', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['credit']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['copyright']) : ?>
		    <tr>
		      <td><b><?php _e('Copyright', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['copyright']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['created_timestamp']) : ?>
		    <tr>
		      <td><b><?php _e('Date taken', 'subarrum') ?></b></td>
		      <td><?php echo date_i18n(get_option('date_format'), $metadata['image_meta']['created_timestamp']); ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['camera']) : ?>
		    <tr>
		      <td><b><?php _e('Camera', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['camera']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <tr>
		    <td><b><?php _e('Original size', 'subarrum') ?></b></d>
		    <td><?php echo $metadata['width'] . ' x ' . $metadata['height'] . ' px'; ?></td>
		  </tr>
		  <?php if ($metadata['image_meta']['aperture']) : ?>
		    <tr>
		      <td><b><?php _e('Aperture', 'subarrum') ?></b></td>
		      <td><?php echo 'F' . $metadata['image_meta']['aperture']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['focal_length']) : ?>
		    <tr>
		      <td><b><?php _e('Focal length', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['focal_length'] . ' mm'; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['iso']) : ?>
		    <tr>
		      <td><b><?php _e('Film speed', 'subarrum') ?></b></td>
		      <td><?php echo 'ISO ' . $metadata['image_meta']['iso']; ?></td>
		    </tr>
		  <?php endif; ?>
		  <?php if ($metadata['image_meta']['shutter_speed']) : ?>
		    <tr>
		      <td><b><?php _e('Shutter speed', 'subarrum') ?></b></td>
		      <td><?php echo $metadata['image_meta']['shutter_speed'] . ' s'; ?></td>
		    </tr>
		  <?php endif; ?>
		</table>
		</div>
	      </div>
	    </div>
		
	    <?php if ((get_theme_mod('meta_data_position', 'footer') == 'footer') && (get_theme_mod('meta_data_style', 'icons') != 'popover' )) : ?>
	    <!-- Start footer -->
	    <footer class="entry-meta row-fluid" style="margin-top:5px">
	      <div class="span12">
		<?php subarrum_entry_meta(); ?>
	      </div>
	    </footer>
	    <?php endif; ?>

	  </article>
	  
	  <!-- check wether comments should be shown -->
	  <?php if (get_theme_mod('image_comments')) : ?>
	    <hr />
	    <?php comments_template(); ?>
	  <?php endif; ?>

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'subarrum'); ?></p>
	<?php endif; ?>
  </div>
  
</div>


<?php get_footer(); ?>