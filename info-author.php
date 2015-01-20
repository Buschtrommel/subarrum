<?php 
/**
 * Author info
 *
 * Displays the author info and gets included by other sites when needed.
 *
 * @revised   April 25, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

		if (is_singular()) {
			$curauth = get_userdata((int)$posts[0]->post_author); // get the current author on single
		} else { 
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); // get the current author
		}
	    ?>
	    

	    <div id="author-info" class="row-fluid">
		<div class="well well-small span12">

		  <h4><?php _e('About the author', 'subarrum'); ?></h4>
		  <div class="row-fluid">
		  <div class="span2 pull-left avatar"><?php echo get_avatar( $curauth->ID, 64 ); ?></div>
		  <div class="span10">
		  <p>
			<?php echo $curauth->display_name . '<span class="grey">' . __(' alias ', 'subarrum') . $curauth->nickname . '</span>'; ?>
		  </p>
		  <p><?php echo $curauth->description; ?></p>
		  <p>
			<i class="icon-pencil"></i> <?php printf( '<span class="author vcard"><a class="url fn n hasTip" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( $curauth->ID )),
				esc_attr( sprintf( __( 'View all posts by %s', 'subarrum' ), $curauth->display_name ) ),
				count_user_posts($curauth->ID) .' '. __('Posts', 'subarrum')
				); ?>
			<?php if ($curauth->user_url) : ?>&nbsp;&nbsp;&nbsp;<i class="icon-globe"></i> <a href="<?php echo $curauth->user_url; ?>" class="hasTip" title="<?php _e("Visit author's website", "subarrum"); ?>"><?php echo _e('Website', 'subarrum') ?></a><?php endif; ?>
			&nbsp;&nbsp;&nbsp;
			<i class="icon-rss"></i> <?php printf('<a class="hasTip" title="%1$s" href="%2$s">%3$s</a>',
				__("Subscribe to the author's RSS feed", "subarrum"),
				esc_url(site_url('/author/'.$curauth->user_login.'/feed/')),
				__('Author feed', 'subarrum')
				); ?>
		  </p>
		  </div>
		  </div>
		</div>
	    </div>