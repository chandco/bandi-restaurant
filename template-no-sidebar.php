<?php
/*
 Template Name: Full Width
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<div id="blog-content" style="width:100%; margin-right:0;">

<?php 
if ( has_post_thumbnail() ) {
the_post_thumbnail();
}  ?>

	<?php if ( have_posts() ) : while( have_posts() ) : the_post();
     the_content();
	endwhile; endif; ?>
</div>


<?php get_footer(); ?>
