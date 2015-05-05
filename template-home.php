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

<div id="home-left-sidebar">
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

<div id="weekly-menu-table">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post();
     the_content();
	endwhile; endif; ?>
</div>

<div id="footer-sidebar">
<?php if ( is_active_sidebar( 'home-footer-sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'home-footer-sidebar' ); ?>

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
