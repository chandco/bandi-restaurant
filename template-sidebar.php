<?php
/*
 Template Name: Sidebar
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<div id="blog-content">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post();
     the_content();
	endwhile; endif; ?>
</div>


<div id="sidebar">
<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'blog-sidebar' ); ?>

			<?php else : ?>

				<?php
					/*
					 * This content shows up if there are no widgets defined in the backend.
					*/
				?>

				<div class="no-widgets">
					<p><?php _e( 'This is a widget ready area. Add some and they will appear here.', 'cf-theme' );  ?></p>
				</div>

			<?php endif; ?>
</div>


<?php get_footer(); ?>
