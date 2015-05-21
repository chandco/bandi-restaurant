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

// $args = array(
// 	"post_parent" => $parentID,
// 	"order" => "ASC",
// 	"orderby" => "menu_order",
// 	"post_type" => "page"
// );

// //gets the parent page 
// $query = new WP_Query($args);
// $children = $query->posts;




$args2 = array(
'sort_order' => 'ASC',
'sort_column' => 'menu_order',
'hierarchical' => 1,
'child_of' => $parentID,
'parent' => -1,
'exclude_tree' => '0',
'post_type' => 'page'
);

$query2 = new WP_Query($args2);
//var_dump($query2);


$args = array(
'sort_column' => 'menu_order',
'parent'      => $post->ID,
'post_type' => 'page',
'hierarchial' => 0
);

$children = get_pages( $args );
?>









<?php get_header(); ?>

<div class='responsive-flex-container'>
	
	<div id="wiki-menu" class='left-sidebar widget'>
	
	<?php
	//show wiki menu children and grandchildren only
	echo "<h3 style=\"padding-left:24px;\"><u>".get_the_title()."</u></h3>";


	foreach( $children as $child ) {
    	$child_args = array(
        'sort_column' => 'menu_order',
        'parent'      => $child->ID,
        'hierarchial' => 0,
        'post_type' => 'page'
    );

   		 $grandchildren = get_pages( $child_args ); 

   		echo "<h3><a href=\"#post-$child->ID\">$child->post_title</a></h3>";
    	
    	
    	foreach( $grandchildren as $gchild ) {
    		echo "<h4><a href=\"#post-$gchild->ID\">$gchild->post_title</a></h4>";
    	}
    	
   } ?>
	
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; 

		// The Loop
		if ( $query2->have_posts() ) {
			while ( $query2->have_posts() ) {
				$query2->the_post();
				echo '<article id="post-'.get_the_id().'">' . get_the_title();
				echo '<p>' . get_the_content() . '</p>';
				echo '</article>';
			}
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		?>
	</div>





</div><!--End responsive flex container-->

<?php get_footer(); ?>
