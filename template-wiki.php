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
	
	<div id="wiki-menu" class='left-sidebar widget'>
	
	<?php
	//show wiki menu children and grandchildren only
	echo "<h3 style=\"padding-left:24px;\"><u>".get_the_title()."</u></h3>";

	echo "<ul>";
	foreach( $children as $child ) {
    	$child_args = array(
        'sort_column' => 'menu_order',
        'parent'      => $child->ID,
        'hierarchial' => 0,
        'post_type' => 'page'
    );

   		 $grandchildren = get_pages( $child_args ); 

   		echo "<h3><li><a href=\"#post-$child->ID\">$child->post_title</a></li></h3>";
    	
    	foreach( $grandchildren as $gchild ) {
    		echo "<h4><li><a href=\"#post-$gchild->ID\">$gchild->post_title</a></li></h4>";
    	}
    	
   } 
   echo "</ul>";
   ?>
	
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; 

		// The Loop to get children
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo '<article class="section" id="post-'.get_the_id().'">' . "<h3><span class=\"right-arrow\">".get_the_title()."</h3>";
				echo '<p class="wiki-text">' . get_the_content() . '</p>';
				echo '<div class="close-sub-section">Close</div>';
				

				//The loop to get the grandchildren
				 $args3=array(
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'posts_per_page' => 3,
                'post_type' => get_post_type( $post->ID ),
                'post_parent' => $post->ID
        );

        $childpages = new WP_Query($args3);

        if($childpages->post_count > 0) { /* display the children content  */
            while ($childpages->have_posts()) {
                 $childpages->the_post();
                 echo "<h4>".get_the_title()."</h4>";
                 the_content();
            }

            echo '</article></span>';
        }
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
