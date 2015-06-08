<?php

class ita_recent_posts extends WP_Widget {
	function ita_recent_posts() {
		parent::WP_Widget(false, 'Recent Posts By Category');
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
		
        
     <?php /*   <p><label for="<?php echo $this->get_field_id('post_tags'); ?>"><?php _e('Which Tags to Show:'); ?></label> 


		
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

     */ ?>
		
		<?php
		
		
		
		
		
	}
 
	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		//var_dump($new_instance);
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['numPosts'] = ( ! empty( $new_instance['numPosts'] ) ) ? strip_tags( $new_instance['numPosts'] ) : '';
		
		// $instance['post_tags'] = ( ! empty( $new_instance['post_tags'] ) ) ? $new_instance['post_tags'] : '';
		
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
			$instance['numPosts'] = 4;
		}

		
		
		
		$args = array(
				'posts_per_page' => $instance['numPosts'],
				'post_type' => 'post',
				
				
				
				);
		if (count($instance['categories']) > 0) {
			
			$args["category__in"] = $instance["categories"];
		}
		
		// if (count($instance['post_tags']) > 0) {
			
		// 	$args["tag__and"] = $instance["post_tags"];
		// }
		
		
		echo "<div class='custom-recent-posts widget'><h2>" . $instance["title"] . "</h2>\n";
 
 

		 $y = 0;

		 
		 $the_query = new WP_Query( $args );
		// The Loop
 
		if ($the_query->have_posts()) {
		
		
 
			echo "<ul class='post-list'>";
				while ($the_query->have_posts()) {
						$the_query->the_post();
				
						global $more;    // Declare global $more (before the loop).
						$more = 0;       // Set (inside the loop) to display content above the more tag.
						
						//add_filter('the_content','my_strip_tags');
					 get_template_part( 'content/post-preview' );
					//	echo "<li>WHUT?</li>"
				
				} // end of related tags
				wp_reset_postdata();
			echo "</ul>";
		echo "</div>";
        
		 
		  
	}
	
	}
	
}
 
 
function ita_recent_myplugin_register_widgets() {
	register_widget('ita_recent_posts');
}
 
add_action( 'widgets_init', 'ita_recent_myplugin_register_widgets' );
 


?>