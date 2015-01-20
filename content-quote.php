<?php 
/**
 * quote post format
 *
 * Displays posts in the quote format, without a title and minimized meta data.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

 $margin_top = is_singular() ? 'content-singular' : 'content-blog';
?>
	    <article  id="post-<?php the_ID(); ?>" <?php post_class($margin_top); ?>>

		<!-- Start content -->
		<div class="entry-content row-fluid">
		  <div class="span12">
		    <?php the_content(__('Continue reading &rarr;', 'subarrum')); ?>
		  </div>
		</div>

		<!-- Start footer -->
		<footer class="entry-meta row-fluid">
		  <div class="span12">
			<i class="icon-calendar"></i> <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'subarrum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><time class="entry-date grey" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time></a>
			<?php if (!(get_theme_mod('two_columns_enable', 0))) echo '<hr />'; ?>
		  </div>
		</footer>
	    </article>