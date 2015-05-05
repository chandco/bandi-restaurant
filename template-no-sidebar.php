<?php
/*
 Template Name: No Sidebar
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<div id="blog-content">

<?php 
if ( has_post_thumbnail() ) {
the_post_thumbnail();
}  ?>

	<?php if ( have_posts() ) : while( have_posts() ) : the_post();
     the_content();
	endwhile; endif; ?>
</div>


<?php get_footer(); ?>
