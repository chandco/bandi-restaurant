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
?>









<?php get_header(); ?>

<div class='responsive-flex-container'>
	
	<div id="wiki-menu" class='left-sidebar widget'>
		<?php
			// echo '<ul>';
			// foreach($children as $child) {
			// 	echo 
			// 	'<li>
			// 		<a href="#'.$child->ID.'">' . $child->post_title . '</a>
			// 	</li>';
			// }
			// echo '</ul>';

		echo "<h3 style=\"padding-left:24px;\"><u>".get_the_title()."</u></h3>";

		echo '<nav><ul>';
		$pages = get_pages($args2); 
		foreach($pages as $page){
			//if it is a grandchild append a class to the list item
			if( is_page() && count(get_post_ancestors($page->ID)) == 2 ) {
				echo '<li class="grandChild"><a href=#post-'.$page->ID.'>'.'- '.$page->post_title.'</a></li>';
			} elseif ( is_page() && count(get_post_ancestors($page->ID)) > 2 ) {
				echo " ";
			} else {
				echo '<li><strong><a href=#post-'.$page->ID.'>'.$page->post_title.'</a></strong></li>';
			}
		} 
		echo '</ul></nav>';
		?>
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; ?>

		<?php



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



<div class="wiki-mobile">



<?php 
// $pages = get_pages($args2); 
// 		foreach($pages as $page){
// 			//if it is a page and page is a grandchild append a class to the list item
// 			if( is_page() && count(get_post_ancestors($page->ID)) == 1 ) {

// 				//show children pages
// 				echo '<article>';
// 				echo "<a href= \"javascript:showonlyone('$page->ID')\";><span class=\"right-arrow\">&#9658</span>";
// 				echo '<h3><strong>'.$page->post_title.'</strong></h3></a>';
// 				echo '<p class="wiki-text" id="'.$page->ID.'">'.$page->post_content.'</p>';
// 				echo '</article>';

// 			}
// 		}

?>



 <?php 
$args = array(
    'sort_column' => 'menu_order',
    'parent'      => $post->ID,
    'post_type' => 'page',
    'hierarchial' => 0
);

$children = get_pages( $args );


foreach( $children as $child ) {
    $child_args = array(
        'sort_column' => 'menu_order',
        'parent'      => $child->ID,
        'hierarchial' => 0,
        'post_type' => 'page',
        'number'      => 3
    );

    $grandchildren = get_pages( $child_args ); ?>


<article>
	<a href="javascript:showSubSection();">
    	<h3><?php echo $child->post_title; ?><span class="right-arrow">&#9658</span></h3>
    </a>
    <?php 
    echo '<p class="wiki-text" id="'.$child->ID.'">'.$child->post_content.'</p>';?>

    <div class="sub-section">
   		<?php
    	foreach( $grandchildren as $gchild ) {
    		echo "<h4>- $gchild->post_title</h4>";
    		echo '<p class="wiki-text" id="'.$gchild->ID.'">'.$gchild->post_content.'</p>';
    	}

    	?>
    </div>

    </article>
   <?php
	}
	?>



</div>


</div>

<?php get_footer(); ?>
