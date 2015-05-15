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


$args2=array(
  'child_of' => $parentID,
  'post_type' => 'page',
  'post_status' => 'publish',
  'posts_per_page' => 100,
  'caller_get_posts'=> 1
);
$my_query = null;
$my_query = new WP_Query($args2);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <div class="main_post_listing2"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">&rsaquo;&nbsp;<?php the_title(); ?></a>&nbsp;&nbsp; &nbsp;&nbsp;<?php the_time('M d, Y') ?>
    </div><?php
  endwhile;
}

wp_reset_query();  // Restore global post data stomped by the_post().




?>
















<?php get_header(); ?>

<div class='responsive-flex-container'>
	
	<div id="wiki-menu" class='left-sidebar'>
		<?php
			echo '<ul>';
			foreach($children as $child) {
				echo 
				'<li>
					<a href="#'.$child->post_title.'">' . $child->post_title . '</a>
				</li>';
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
		echo '<article id="'.get_the_title().'">' . get_the_title();
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
