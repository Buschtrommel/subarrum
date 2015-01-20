<?php 
/**
 * bxSlider
 *
 * Integrates the bxSlider into the header and loads the needed scripts and styles
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */  
	  // get slider options
	  $slcaption	= get_theme_mod('image_slider_caption', 0) ? 'true' : 'false';
	  $slcontrols	= get_theme_mod('image_slider_controls', 0) ? 'true' : 'false';
	  $slpager	= get_theme_mod('image_slider_pager', 0) ? 'true' : 'false';
	  $slauto	= get_theme_mod('image_slider_auto', 1) ? 'true' : 'false';
// 	  $slstyle	= get_theme_mod('image_slider_style', 'bxslider-css-subarrum');
	  $slstyle	= 'bxslider-css-subarrum';
	  $order	= get_theme_mod('image_slider_order', 'random');
	  $limit	= get_theme_mod('image_slider_limit', 100);
	  $type		= get_theme_mod('image_slider_source', 'attachment');
	  $linkit	= get_theme_mod('image_slider_linkit', 0);
	  
	  // add the necessary scripts and stylees
	  wp_enqueue_style( $slstyle );
	  wp_enqueue_script( 'bxslider' );
	  
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.bxslider').bxSlider({
				captions: <?php echo $slcaption; ?>,
				auto: <?php echo $slauto; ?>,
				controls: <?php echo $slcontrols; ?>,
				mode: <?php echo '\'' . get_theme_mod('image_slider_mode', 'fade') . '\''; ?>,
				speed: <?php echo get_theme_mod('image_slider_speed', '500'); ?>,
				pause: <?php echo get_theme_mod('image_slider_pause', '5000'); ?>,
				easing: 'ease-in-out',
				pager: <?php echo $slpager; ?>,
				autoHover: true
			});
		});
	</script>
	
		<?php 
		$headerimages = subarrum_get_featured($type, $limit, $order );
		?>
		
		<div class="bxslider" style="padding:0px !important;overflow:hidden;height:320px;">
		  <?php foreach ($headerimages as $key => $value) : ?>
		    <?php
			  if ($type == 'attachment') {
				$imgsrc = wp_get_attachment_image_src( $value, 'post-thumbnails-wide' );
			  } else {
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id($value), 'post-thumbnails-wide');
				if (!$imgsrc[0]) $imgsrc[0] = get_theme_mod('image_slider_placeholder', get_template_directory_uri() . '/images/slider-placeholder.jpg');
			  }
			  if ($linkit) $permalink = get_permalink( $value );
		    ?>
		    <div>
		      <?php if ($linkit) : ?>
		      <a href="<?php echo $permalink; ?>">
		      <?php endif; ?>
			<img src="<?php echo $imgsrc[0]; ?>" title="<?php echo get_the_title($value); ?>" alt="<?php echo get_the_title($value); ?>" />
		      <?php if ($linkit) : ?>
		      </a>
		      <?php endif; ?>
		    </div>
		  <?php endforeach; ?>
		</div>