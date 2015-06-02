<?php
/*
 Template Name: Home Page
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>


<?php get_header(); ?>
<div class='responsive-flex-container max-central'>

	<div id="home-left-sidebar" class='left-sidebar'>
		<?php if ( is_active_sidebar( 'home-sidebar' ) ) : ?>

			<?php dynamic_sidebar( 'home-sidebar' ); ?>

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

	<div id="weekly-menu-table" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; ?>
	</div>

	<div id="footer-sidebar">
		
		<!-- <h2>Latest Posts</h2> -->
		<?php
			 dynamic_sidebar( 'home-footer-sidebar' );
		?>
	</div>

</div>


<?php get_footer(); ?>
