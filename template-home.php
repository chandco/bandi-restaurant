<?php
/*
 Template Name: Home Page
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<style type="text/css">

.container {
  display:flex;
  background:#f00;
  box-sizing:border-box;
}


.item {
  background:#999;
  flex-grow: 1;
  margin:10px;
  display:flex;
 justify-content:space-around;
}

.wider {
  flex-grow: 2;
}

.widget-area {
  background:green;
  margin-bottom:10px;
  display:flex;
  justify-content:space-around;
}

.widget {
   background:orange;
  width:35%;
}

@media screen and (max-width: 872px) {
  .widget-area {
    background:pink;
    flex-direction:row;
  }
  
  .item {
    display:flex;
    flex-direction:column;
  }
  
  
}

@media screen and (max-width: 480px) {
  .widget-area {
    background:blue;
    flex-direction:column;
   
    width:90%;
  } 
  
  .item {
    flex-direction:column;
    align-items:center;
    
  }
  
}

</style>


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

	<div id="footer-sidebar" class='full-width'>
		
		<!-- <h2>Latest Posts</h2> -->
		
		
		<div class="widget-area">
			<div class="item wider">
				<div class="widget-area">
					<div class="widget">
						<?php dynamic_sidebar( 'home-footer-sidebar' ); ?>
					</div>

					<div class="widget-area">
					<div class="widget">
						<?php dynamic_sidebar( 'home-footer-sidebar-2' ); ?>
					</div>
				</div>

				</div>
			</div>
		</div>

			

	

<?php

// create the widget form
 // list categories, selecta
 // list blogs, selecta
 
 // number of posts
 
 
 // create the widget output
 
 
 
 
// nice recent posts widget
 




			
			// 	$args = array(
					
					
			// 		'posts_per_page'         => 4,
			// 		// maybe add tax queries here
					
			// 	);

				
			
			// $latest = new WP_Query( $args );


			// if ( $latest->have_posts() ) {
			// 	echo "<ul class='grid-feed'>";
			// 	while ($latest->have_posts() ) {
			// 		$latest->the_post();

			// 		get_template_part( 'content/post-preview' );

			// 	}

			// 	echo "</ul>";
			// }

			// wp_reset_postdata();


		?>
	</div>

</div>


<?php get_footer(); ?>
