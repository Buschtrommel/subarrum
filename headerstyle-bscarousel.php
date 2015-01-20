<?php 
/**
 * Boutstrap Carousel
 *
 * Integrates the Bootstrap Carousel into the header.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
 
	  // get carousel options
	  $slcaption	= get_theme_mod('image_slider_caption', 0);
	  $slcontrols	= get_theme_mod('image_slider_controls', 0);
	  $slpager	= get_theme_mod('image_slider_pager', 0);
	  $slauto	= get_theme_mod('image_slider_auto', 1);
	  $order	= get_theme_mod('image_slider_order', 'random');
	  $limit	= get_theme_mod('image_slider_limit', 100);
	  $type		= get_theme_mod('image_slider_source', 'attachment');
	  $linkit	= get_theme_mod('image_slider_linkit', 0);
	  $slexcerpt	= get_theme_mod('image_slider_excerpt', 0);
	  $slexlength	= get_theme_mod('image_slider_excerpt_length', 30);
	  $slinterval	= get_theme_mod('image_slider_pause', '5000');
	  
	  if (!$slauto) $slinterval = 0;
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.carousel').carousel({
				interval: <?php echo $slinterval; ?>
			});
		});
	</script>
	
		<?php 

		$headerimages = subarrum_get_featured($type, $limit, $order );

		?>
		
		<div id="headerCarousel" class="carousel slide">
		  <?php if ($slpager) : ?>
		  <ol class="carousel-indicators">
		  <?php foreach ($headerimages as $key => $value) : ?>
		    <li data-target="#headerCarousel" data-slide-to="<?php echo $key; ?>"<?php if($key == 0) echo ' class="active"'; ?>></li>
		  <?php endforeach; ?>
		  </ol>
		  <?php endif; ?>
		  
		  <div class="carousel-inner">
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
		    <div class="item<?php if($key == 0) echo ' active'; ?>">
		      <?php if ($linkit) : ?>
		      <a href="<?php echo $permalink; ?>">
		      <?php endif; ?>
			<img src="<?php echo $imgsrc[0]; ?>" title="<?php echo get_the_title($value); ?>" alt="<?php echo get_the_title($value); ?>" />
		      <?php if ($linkit) : ?>
		      </a>
		      <?php endif; ?>
		      <?php if ($slcaption) : ?>
		      <div class="carousel-caption">
			<h4><?php echo get_the_title($value); ?></h4>
			<?php $the_excerpt = ''; if ($slexcerpt) $the_excerpt = subarrum_get_excerpt($value, $slexlength); if ($the_excerpt) : ?>
			<p class="hidden-phone"><?php echo $the_excerpt; ?></p>
			<?php endif; ?>
		      </div>
		      <?php endif; ?>
		    </div>
		  <?php endforeach; ?>
		  </div>
		  <?php if ($slcontrols) : ?>
		  <a class="left carousel-control" href="#headerCarousel" data-slide="prev">&lsaquo;</a>
		  <a class="right carousel-control" href="#headerCarousel" data-slide="next">&rsaquo;</a>
		  <?php endif; ?>
		</div>