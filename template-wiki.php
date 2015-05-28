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
?>

<?php
$parentID = get_the_ID();

$args = array(
	"post_parent" => $parentID,
	"order" => "ASC",
	"orderby" => "menu_order",
	"post_type" => "page"
);

//gets the parent page 
$query = new WP_Query($args);
//$children2 = $query->posts;


$args2 = array(
'sort_column' => 'menu_order',
'parent'      => $post->ID,
'post_type' => 'page',
'hierarchial' => 0
);

$children = get_pages( $args2 );
?>




<?php get_header(); ?>

<div class='responsive-flex-container'>
	
	<div id="wiki-menu" class='left-sidebar'>
	
	<?php
	//show wiki menu children and grandchildren only
	echo "<h1>".get_the_title()."</h1>";

	echo "<ul class='visual-menu'>";
	foreach( $children as $child ) {


    	$child_args = array(
	        'sort_column' => 'menu_order',
	        'parent'      => $child->ID,
	        'hierarchial' => 0,
	        'post_type' => 'page'
	    );

    	echo "<li class='parent' id='link-" . $child->ID . "'><a href=\"#post-$child->ID\">$child->post_title</a>";
   		
   		$grandchildren = get_pages( $child_args ); 

   		if (count($grandchildren) > 0) {

   			echo "<ul>";
	   		
	    	
	    	foreach( $grandchildren as $gchild ) {
	    		echo "<li class='child' id='link-" . $gchild->ID . "'><a href=\"#post-$gchild->ID\">$gchild->post_title</a></li>";
	    	}

	    	echo "</ul>";

    	}

    	echo "</li>";
    	
   } 
   echo "</ul>";
   ?>
	
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	    
		endwhile; endif; 

		// The Loop to get children
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				echo '<span class="anchor-point" id="post-'.get_the_id().'"></span>'; // anchor point to offset the hanging fixed header
				echo '<article class="section">';

				echo "<h2><span class=\"right-arrow\">" . get_the_title() . " ";
				edit_post_link();
				echo '</h2></span>';

				echo "<div class='content'>";


				echo '<div class="article-div parent" data-link="'.get_the_id().'" >';

				the_content();

				echo '</div>';
				
	
				//The loop to get the grandchildren
				$args3 = array(
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'post_type' => get_post_type( $post->ID ),
                'post_parent' => $post->ID
        );

        $childpages = new WP_Query($args3);

        if($childpages->post_count > 0) { /* display the children content  */
            

            while ($childpages->have_posts()) {
                 $childpages->the_post();

                echo '<span class="anchor-point" id="post-'.get_the_id().'"></span>'; // anchor point to offset the hanging fixed header
                echo '<div class="article-div child" data-link="'.get_the_id().'">';
				
				echo 	"<h3> ".get_the_title() . " ";
						edit_post_link();
				echo 	" </h3>";

						the_content();
				
				echo 	"</div>";
                
                
            }
            


        }

        echo '<div class="close-sub-section">Close</div>';   

        echo "</div>"; // class='content'>";
		echo '</article>';
            
        
        wp_reset_query();
       
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
