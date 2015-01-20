<?php 
/**
 * link format temlate
 *
 * Shows up when a post in the link format is requested.
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

 $margin_top = is_singular() ? 'content-singular' : 'content-blog';
 
 // check if there is maybe only a text link and format it
 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\._\/]+\.[a-zA-Z]{2,3}(\/\S*)+/";
 $reg_exLink = "/<a .*>.*<\/a>/";
 $content = get_the_content();
 if (!preg_match($reg_exLink, $content)) {
	$foundLink = 0;
	$title = get_the_title() ? get_the_title() : __('Link', 'subarrum');
	preg_match($reg_exUrl, $content, $url);
	$replacement = '<a href="'.$url[0].'">'.$title.'</a>';
	$content = preg_replace($reg_exUrl, $replacement, $content);
 } else {
	$foundLink = 1;
 }
?>
	    <article  id="post-<?php the_ID(); ?>" <?php post_class($margin_top); ?>>

		<!-- Start content -->
		<div class="entry-content row-fluid">
		  <div class="span10">
			<?php if ($foundLink) {
				the_content(__('Continue reading &rarr;', 'subarrum'));
			      } else {
				echo '<p>'.$content.'</p>';
			      }
			?>
		  </div>
		  <header class="span2">
			<span class="label pull-right"><i class="icon-globe"> </i><?php _e('Link', 'subarrum'); ?></span>
		  </header>
		</div>

		<!-- Start footer -->
		<footer class="entry-meta row-fluid">
		  <div class="span12">
			<i class="icon-calendar"></i> <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'subarrum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><time class="entry-date grey" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time></a>
			<?php if (!(get_theme_mod('two_columns_enable', 0))) echo '<hr />'; ?>
		  </div>
		</footer>
	    </article>