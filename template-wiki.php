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
$children = $query->posts;




$args2 = array(
'sort_order' => 'ASC',
'sort_column' => 'menu_order',
'hierarchical' => 1,
'child_of' => $parentID,
'parent' => -1,
'exclude_tree' => '0',
'depth' => '2',
'post_type' => 'page'
);
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

		echo '<ul>';
		$pages = get_pages($args2); 
		foreach($pages as $page){
			if( is_page() && count(get_post_ancestors($page->ID)) == 2 ) {
				echo '<li class="grandChild"><a href=#'.$page->ID.'>'.'- '.$page->post_title.'</a></li>';
				} else {
				echo '<li><a href=#'.$page->ID.'>'.$page->post_title.'</a></li>';
				}
		} 
		echo '</ul>';
		?>
	</div>

	<div id="wiki-content" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; ?>

		<?php



// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<article id="'.get_the_id().'">' . get_the_title();
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
</div>

<?php get_footer(); ?>
