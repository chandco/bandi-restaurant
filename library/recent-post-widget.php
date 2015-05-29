<?php

class ita_recent_posts extends WP_Widget {
	function ita_recent_posts() {
		parent::WP_Widget(false, 'ITA recent Posts');
	}
 
 
 
 
	function form($instance) {
		// outputs the options form on admin
		
		$title = esc_attr($instance['title']);
		$numPosts = esc_attr($instance['numPosts']);
		$cats = ($instance['categories']);
		$post_tags =  ($instance['post_tags']);
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        
        <p><label for="<?php echo $this->get_field_id('numPosts'); ?>"><?php _e('Num Posts to Show:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('numPosts'); ?>" name="<?php echo $this->get_field_name('numPosts'); ?>" type="text" value="<?php echo $numPosts; ?>" /></label></p>
		
        
		<p><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Which Categories to Show:'); ?></label>
		
        <?php
        
        $categories = get_categories(  );
    foreach($categories as $category) : ?>
    <div>
        <input type="checkbox" name="<?php echo $this->get_field_name('categories'); ?>[]"
            value="<?php echo $category->term_id; ?>" <?php
            if (in_array($category->term_id,$cats))
			{
				echo "checked";
			}
			
			?>/>
            <?php echo $category->name; ?>
    </div>
    </p>
    <?php endforeach; ?>
        <?php
        /*<input class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo $categories; ?>" /></label></p>*/?>
		
        
        <p><label for="<?php echo $this->get_field_id('post_tags'); ?>"><?php _e('Which Tags to Show:'); ?></label>
		
        <?php
        
        $tags = get_tags( );
    foreach($tags as $tag) : ?>
    <div>
        <input type="checkbox" name="<?php echo $this->get_field_name('post_tags'); ?>[]"
            value="<?php echo $tag->term_id; ?>"  <?php
            if (in_array($tag->term_id,$post_tags))
			{
				echo "checked";
			}
			
			?> />
            <?php echo $tag->name; ?>
    </div>
    </p>
    <?php endforeach; ?>
		
		<?php
		
		
		
		
		
	}
 
	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		//var_dump($new_instance);
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['numPosts'] = ( ! empty( $new_instance['numPosts'] ) ) ? strip_tags( $new_instance['numPosts'] ) : '';
		
		$instance['post_tags'] = ( ! empty( $new_instance['post_tags'] ) ) ? $new_instance['post_tags'] : '';
		
		$instance['categories'] = $new_instance["categories"];//( ! empty( $new_instance['categories'] ) ) ? strip_tags( implode(",",$new_instance['categories']) )  : '';
		return $instance;
		
		
	}
 
	function widget($args, $instance) {
		// outputs the content of the widget
		
		if (is_archive() OR is_category()) {
			return; // don't want it on a feed page.  That's STURPID
		}
		
		if (!isset($instance['title'])) {
			$instance['title'] = 'Latest News';
		}
		
		if (!isset($instance['numPosts'])) {
			$instance['numPosts'] = 3;
		}
		
		
		$args = array(
				'posts_per_page' => $instance['numPosts'],
				'post_type' => 'post',
				
				
				
				);
		if (count($instance['categories']) > 0) {
			
			$args["category__in"] = $instance["categories"];
		} else {
			$args["category__in"] = "9"; // hardcoded to blogs for now! bad idea!
		}
		
		if (count($instance['post_tags']) > 0) {
			
			$args["tag__and"] = $instance["post_tags"];
		}
		
		
		echo "<div class='widget-recent-posts' id='blog-panels'><h2>" . $instance["title"] . "</h2>\n";
 
 
		//$hotPosts = get_posts($args);
		
		/*
		
		We're not using this yet, but if we do, we can use this bit to default the 
		widget to related posts based on the post's tag / categories but we'll implement this when we need this
		
		global $post;
		// are we on a single page?
		if (is_single())
		{
			$tag_output = "<P class='widget-tags'>Tagged: ";
			$search_tags = array();
			$tags = get_the_tags();
			if (is_array($tags)):
			foreach($tags as $tag) {
				$search_tags[] = $tag->term_id;	
				$tag_output .= 	" <a href='" . get_tag_link($tag->term_id) . "' rel='tag'>" . $tag->name . "</a> ";
			}
			$pre_tag_args = $args;
			$args["tag__in"] = $search_tags;
			$hotPosts = get_posts($args);
			$tag_output .= "</p>";
			if (count($hotPosts) == 0)
			{
				$hotPosts = get_posts($pre_tag_args);
			} else {
				$output .= $tag_output;
			}
			else:
			$hotPosts = get_posts($args);
			endif;
			
		 } else {
			 $hotPosts = get_posts($args);
		 }
		 */
		 $y = 0;
		 $the_query = new WP_Query( $args );
		// The Loop
 
		if ($the_query->have_posts()) {
		
		echo "<div class='sidebar-blogs'>";
 
		
 
		echo "<ul class='venue-related-post-container'>";
		while ($the_query->have_posts()) {
				$the_query->the_post();
				
		
		
		
		
 
		
		global $more;    // Declare global $more (before the loop).
		$more = 0;       // Set (inside the loop) to display content above the more tag.
		
		add_filter('the_content','my_strip_tags');
		echo "<li class='venue-related-post'>";
		echo "<a href='" . get_permalink() . "'>";
	
		
		echo get_the_post_thumbnail( $page->ID, "old-blog-thumb");		
		echo "<h4>" . get_the_title() . "</h4>";
		echo "</a></li>";
		
	
 
 
		
		
		} // end of related tags
		wp_reset_postdata();
 
		echo "</ul>";
		echo "</div>
	</div>";
        
		 
		  
	}
	
	}
	
}
 
 
function ita_recent_myplugin_register_widgets() {
	register_widget('ita_recent_posts');
}
 
add_action( 'widgets_init', 'ita_recent_myplugin_register_widgets' );
 


?>