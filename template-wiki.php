<?php
/*
 Template Name: Wiki Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/




$args2 = array(
'order' => 'asc',
'orderby' => 'menu_order',
'post_parent' 	=> get_the_ID(),
'post_type' 	=> 'page',
);



$children = new WP_Query( $args2 );

 get_header(); ?>

<div class='responsive-flex-container max-central'>
	
	<div id="wiki-menu" class='left-sidebar'>
	
	<?php
	//show wiki menu children and grandchildren only
	echo "<h2>".get_the_title()."</h2>";

	echo "<ul class='visual-menu'>";
	if ( $children->have_posts() ) {
		while ( $children->have_posts() ) {
			$children->the_post();

			echo "<li class='parent' id='link-" . get_the_id() . "'><a href=\"#post-" . get_the_id() . "\"> " . get_the_title() . "</a>";

	    	$child_args = array(
		     	'order' => 'asc',
				'orderby' => 'menu_order',
		        'post_parent'      	=> get_the_id(),
		        'hierarchial' 	=> 0,
		        'post_type' 	=> 'page'
		    );

		    

	    	   		
	   		$grandchildren = new WP_Query( $child_args );



	   		if ( $grandchildren->have_posts() ) {

	   			echo "<ul>";
				while ( $grandchildren->have_posts() ) {

					$grandchildren->the_post();
		    		echo "<li class='child' id='link-" . get_the_id() . "'><a href=\"#post-" . get_the_id() . "\"> " . get_the_title() . "</a>";
	    		} 

	    		echo "</ul>";
	    	}
	    	wp_reset_postdata();

	    	echo "</li>";
			}	 
	}
   echo "</ul>";
   wp_reset_postdata();
   ?>
	
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();

		echo "<h1>".get_the_title()."</h1>";

		the_content();
	    
		endwhile; endif; 

		// The Loop to get children
		$children = new WP_Query( $args2 );
		if ( $children->have_posts() ) {
		while ( $children->have_posts() ) {
				$children->the_post();

				echo '<span class="anchor-point" id="post-' . get_the_id() . '"></span>'; // anchor point to offset the hanging fixed header
				echo '<article class="section">';

				echo "<h2>" . get_the_title() . " ";
				
				edit_post_link();
				
				echo '</h2>';

				echo "<div class='content'>";


				echo '<div class="article-div parent" data-link="' . get_the_id() . '" >';
 
				the_content();

				echo '</div>';
				
	
				//The loop to get the grandchildren
				$child_args = array(
			      	'order' => 'asc',
					'orderby' => 'menu_order',
			        'post_parent'      	=> get_the_id(),
			        'hierarchial' 	=> 0,
			        'post_type' 	=> 'page'
			    );
	    	   		
	   			$grandchildren = new WP_Query( $child_args );

	   			if ( $grandchildren->have_posts() ) {

	   				while ( $grandchildren->have_posts() ) {
	   					$grandchildren->the_post();

        

       

		                echo '<span class="anchor-point" id="post-' . get_the_id() . '"></span>'; // anchor point to offset the hanging fixed header
		                echo '<div class="article-div child" data-link="' . get_the_id() . '">';
						
						echo 	"<h3> " . get_the_title() . " ";
								edit_post_link();
						echo 	" </h3>";

								the_content();
						
						echo 	"</div>";

					}
				}
                
                
            
            


        

	        echo '<div class="close-sub-section">Close</div>';   

	        echo "</div>"; // class='content'>";
			echo '</article>';
	            
	        
	        wp_reset_postdata();
       
		}
	} else {
		
		echo "Sorry, you have no posts.";
	}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	?>
	</div>



</div><!--End responsive flex container-->

<?php get_footer(); ?>
