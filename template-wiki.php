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


?>

<?php get_header(); ?>

<div id="wiki-menu">
<?php
	foreach($children as $child) {
		echo "<li><a href=#".$child->post_title.">" . $child->post_title . "</a></li>";
	}
?>
</div>

<div id="wiki-content">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post();
     the_content();
	endwhile; endif; ?>

	<?php


// The Loop
if ( $query->have_posts() ) {
	echo '<ul>';
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li name=#"'.get_the_title().'">' . get_the_title() . '</li>';
		echo '<p>' . get_the_content() . '</p>';
	}
	echo '</ul>';
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
?>
</div>

<?php get_footer(); ?>
