<?php
/*
 Template Name: Custom Carousel Code Template
 *
 * This page is for adding a full width map or other full width <iframe> instead of a carousel.  
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>


				<div id="carousel" class='carousel'>  

					<?php

					$value = get_post_meta( $post->ID, 'custom_content', true ); 
					echo $value;

					?>

				</div>



			<div id="content" class='max-central'>

				<div id="inner-content" class="wrap cf">

						
<?php get_template_part( 'content/page' ); ?>


						<?php // get_sidebar(); ?>

				</div>

				

			</div>



<?php get_footer(); ?>
