<?php
/**
 * Custom widgets for nicer presentations. Do not override the existing ones,
 * so you are still free to choose.
 * 
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */




/**
 * Subar Rum Meta widget class
 *
 * Displays log in/out, RSS feed links, etc.
 *
 * @since Subar Rum 1.0
 */
class Subarrum_Meta_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( "Log in/out, admin, feed and WordPress links", 'subarrum') );
		parent::__construct('subarrum_meta', __('Subar Rum Meta', 'subarrum'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Meta', 'subarrum') : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>
			<ul>
			<?php wp_register('<li><i class="icon-pencil"></i> '); ?>
			<li><i class="icon-off"></i> <?php wp_loginout(); ?></li>
			<li><i class="icon-rss"></i> <a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0', 'subarrum')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>', 'subarrum'); ?></a></li>
			<li><i class="icon-comments"></i> <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS', 'subarrum')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><i class="icon-globe"></i> <a href="<?php esc_attr_e( 'http://wordpress.org/', 'subarrum' ); ?>" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'subarrum')); ?>"><?php
			/* translators: meta widget link text */
			_e( 'WordPress.org', 'subarrum' );
			?></a></li>
			<?php wp_meta(); ?>
			</ul>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'subarrum'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}



/**
 * Subar Rum Recent_Posts widget class
 *
 * @since Subar Rum 1.0
 */
class Subarrum_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( "The most recent posts on your site", 'subarrum') );
		parent::__construct('subarrum_recent_posts', __('Subar Rum Recent Posts', 'subarrum'), $widget_ops);
		$this->alt_option_name = 'subarrum_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('subarrum_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'subarrum') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php while ( $r->have_posts() ) : $r->the_post(); 
			if ($show_image) {
			$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
			$thumb_image_alt = get_post_meta(get_post_thumbnail_id(),'_wp_attachment_image_alt', true);
			if (!$thumb_image_url[0]) {
				$thumb_image_url[0] = get_theme_mod('small_placeholder_image', get_template_directory_uri() . '/images/similarposts-placeholder.jpg');
				$thumb_image_alt = __('Placeholder', 'subarrum'); } } ?>

			<div class="row-fluid<?php if ($show_image) echo ' recommended-posts-row'; ?>"><div class="span12 recommended-post">
			<?php if ($show_image) : ?>
			  <a href="<?php the_permalink(); ?>">
			    <img class="img-polaroid pull-left recommended-posts" alt="<?php echo $thumb_image_alt; ?>" src="<?php echo $thumb_image_url[0]; ?>" />
			  </a>
			<?php endif; ?>
			  <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
			  <br /><span class="post-date grey"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</div></div>

		<?php endwhile; ?>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('subarrum_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (bool) $new_instance['show_date'];
		$instance['show_image'] = (bool) $new_instance['show_image'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['subarrum_recent_entries']) )
			delete_option('subarrum_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('subarrum_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date  = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'subarrum' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'subarrum' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'subarrum' ); ?></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display post thumbnail?', 'subarrum' ); ?></label></p>
<?php
	}
}


/**
 * Subar Rum Recent_Comments widget class
 *
 * @since Subar Rum 1.0
 */
class Subarrum_Recent_Comments extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( 'The most recent comments', 'subarrum' ) );
		parent::__construct('subarrum_recent_comments', __('Subar Rum Recent Comments', 'subarrum'), $widget_ops);
		$this->alt_option_name = 'subarrum_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array($this, 'recent_comments_style') );

		add_action( 'comment_post', array($this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );
	}

	function recent_comments_style() {
		if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
			|| ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
			return;
		?>
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<?php
	}

	function flush_widget_cache() {
		wp_cache_delete('subarrum_recent_comments', 'widget');
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('subarrum_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments', 'subarrum' ) : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 5;
 		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;

		$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$output .= '<div class="row-fluid';
				$output .= ($show_image) ? ' recent-posts-row' : '';
				$output .= '"><div class="span12">';
				if ($show_image) {
				  $output .= '<div class="pull-left recent_comments_image"><a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_avatar($comment, 60) . '</a></div>';
				}
				$output .=  /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s on<br />%2$s','widgets', 'subarrum'), get_comment_author_link(), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>');
				$output .= '<br /><span class="grey">'. sprintf(_x('%1$s ago', 'widgets', 'subarrum'), human_time_diff( get_comment_time('U'), current_time('timestamp'))) .'</span>';
				$output .= '</div></div>';
			}
 		}
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('subarrum_recent_comments', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$instance['show_image'] = (bool) $new_instance['show_image'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['subarrum_recent_comments']) )
			delete_option('subarrum_recent_comments');

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'subarrum'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:', 'subarrum'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display avatar image?', 'subarrum' ); ?></label></p>
<?php
	}
}


/**
 * Subarrum Random Post widget class
 *
 * Displays a button that load a random post
 *
 * @since Subar Rum 1.0
 */
class Subarrum_Random_Post_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( "Displays a button that loads a random post", "subarrum") );
		parent::__construct('subarrum_random_post', __('Subar Rum Random Post', 'subarrum'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Random post', 'subarrum') : $instance['title'], $instance, $this->id_base);
		$text = empty($instance['text']) ? __('Try your luck and hit or miss', 'subarrum') : strip_tags($instance['text']);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			
			subarrum_get_random_post($text);

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'subarrum'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			
			<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Button-Text:', 'subarrum'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" /></p>
<?php
	}
}




/**
 * Subar Rum Recommended Posts/Images Widget Class
 *
 * Displays a button that load a random post
 *
 * @since Subar Rum 1.0
 */
class Subarrum_Recommended_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( "Display as recommended marked posts or images", "subarrum") );
		parent::__construct('subarrum_recommended', __('Subar Rum Recommended', 'subarrum'), $widget_ops);
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget( $args, $instance ) {
	
		$cache = wp_cache_get('subarrum_recommended', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recommended', 'subarrum') : $instance['title'], $instance, $this->id_base);
		$type = empty($instance['type']) ? 'post' : $instance['type'];
		if ( empty( $instance['limit'] ) || ! $limit = absint( $instance['limit'] ) )
 			$limit = 5;
		$order = empty($instance['order']) ? 'descending' : $instance['order'];
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;

		
		$ids = subarrum_get_featured($type, $limit, $order);
		

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>
		
		
		<?php if ($type == 'post'):
		  $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'post_type' => 'post', 'post__in' => $ids, 'ignore_sticky_posts' => 1 ) ) );
		  if ($r->have_posts()) : ?>

		  <?php while ( $r->have_posts() ) : $r->the_post(); 
			if ($show_image) {
			$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
			$thumb_image_alt = get_post_meta(get_post_thumbnail_id(),'_wp_attachment_image_alt', true);
			if (!$thumb_image_url[0]) {
				$thumb_image_url[0] = get_theme_mod('small_placeholder_image', get_template_directory_uri() . '/images/similarposts-placeholder.jpg');
				$thumb_image_alt = __('Placeholder', 'subarrum'); } } ?>

			<div class="row-fluid<?php if ($show_image) echo ' recommended-posts-row'; ?>"><div class="span12 recommended-post">
			<?php if ($show_image) : ?>
			  <a href="<?php the_permalink(); ?>">
			    <img class="img-polaroid pull-left recommended-posts" alt="<?php echo $thumb_image_alt; ?>" src="<?php echo $thumb_image_url[0]; ?>" />
			  </a>
			<?php endif; ?>
			  <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
			  <br /><span class="post-date grey"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</div></div>

		  <?php endwhile; ?>

		  
<?php
		  // Reset the global $the_post as this query will have stomped on it
		  wp_reset_postdata();

		  endif;
		endif; ?>
		
		<?php if ($type == 'attachment') :
		  $count = 0;
		  foreach ($ids as $id) : 
			$count++;
			$imgsrc = wp_get_attachment_image_src( $id, 'thumbnail' );
			$permalink = get_permalink( $id );?>
			<?php if ($count % 2 != 0) : // open row?>
			<div class="row-fluid recommended-images-row"> <!-- row open -->
			<?php endif; ?>
			  <div class="span6">
			    <a href="<?php echo $permalink; ?>" title="<?php echo get_the_title($id); ?>">
			      <img src="<?php echo $imgsrc[0]; ?>" alt="<?php echo get_the_title($id); ?>" class="img-rounded recommended-image" />
			    </a>
			  </div>
			 <?php if ($count % 2 == 0) : // close row after second entry?>
			 </div>  <!-- row close -->
			 <?php endif; ?>
		  <?php endforeach; ?>
		  <?php if ($count % 2 != 0) : // if the last row only holds one item, close it correctly ?>
			  <div class="span6">
			  </div>
			 </div>
		  <?php endif;
		      endif;
		
		echo $after_widget;
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('subarrum_recommended', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = absint( $new_instance['limit'] );
		$instance['show_date'] = (bool) $new_instance['show_date'];
		$instance['show_image'] = (bool) $new_instance['show_image'];
		if ( in_array( $new_instance['type'], array( 'attachment', 'post' ) ) ) {
			$instance['type'] = $new_instance['type'];
		} else {
			$instance['type'] = 'post';
		}
		if ( in_array( $new_instance['order'], array( 'descending', 'ascending', 'random' ) ) ) {
			$instance['order'] = $new_instance['order'];
		} else {
			$instance['order'] = 'descending';
		}
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['subarrum_recommended']) )
			delete_option('subarrum_recommended');

		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('subarrum_recommended', 'widget');
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'limit' => '', 'type' => 'post', 'order' => 'descending' ) );
		$title = strip_tags($instance['title']);
		$limit = isset($instance['limit']) ? absint($instance['limit']) : 5;
		$show_date  = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'subarrum'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			
			<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'Type:', 'subarrum' ); ?></label>
			<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
				<option value="post"<?php selected( $instance['type'], 'post' ); ?>><?php _e('Posts', 'subarrum'); ?></option>
				<option value="attachment"<?php selected( $instance['type'], 'attachment' ); ?>><?php _e('Images', 'subarrum'); ?></option>
			</select>
			</p>
			
			<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e( 'Sort by:', 'subarrum' ); ?></label>
			<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
				<option value="ascending"<?php selected( $instance['order'], 'ascending' ); ?>><?php _e('ID ascending', 'subarrum'); ?></option>
				<option value="descending"<?php selected( $instance['order'], 'descending' ); ?>><?php _e('ID descending', 'subarrum'); ?></option>
				<option value="random"<?php selected( $instance['order'], 'random' ); ?>><?php _e('Random', 'subarrum'); ?></option>
			</select>
			</p>
			
			<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Number of items to show:', 'subarrum'); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" /></p>
			
			<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'subarrum' ); ?></label></p>
		
			<p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display post thumbnail?', 'subarrum' ); ?></label></p>
<?php
	}
}
