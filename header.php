<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<?php /* <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png"> */ ?>


		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
		
		

		<?php // wordpress head functions - try and avoid ANY javascript up here. ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>
		<script>
		// Picture element HTML5 shiv.  We're not putting this in require since it's a fairly fundamental HTML thing and it can handle the Async on its own.
		document.createElement( "picture" );
		</script>
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/library/js/vendor/picturefill.js" async></script>
	</head>
	<?php
	$bodyclass = "";
	if (ISMOBILE) $bodyclass .= " is-mobile ";
	if (ISTABLET) $bodyclass .= " is-tablet ";
	?>
	<body <?php body_class($bodyclass); ?>>
	<!-- <?php echo ISMOBILE; ?> -->
	<!-- <?php echo ISTABLET; ?> -->

	
		<header class="header" role="banner">

				<div id="inner-header" >

					<div id='printlogo'><img src='<?php echo get_stylesheet_directory_uri(); ?>/library/images/printlogo.png' alt='<?php bloginfo('name'); ?>' title='<?php bloginfo('name'); ?>' /></div>


					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<a href="<?php echo home_url(); ?>" rel="nofollow">
						<div id='logo'>
							<img src='<?php echo get_stylesheet_directory_uri(); ?>/library/images/logo.svg' alt='<?php bloginfo('name'); ?>' title='<?php bloginfo('name'); ?>' />
						</div>
					</a>

					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>

					<button id='navigation-dropdown' title='expand navigation menu'><i class='fa fa-bars'></i></button>
					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => false,                           // remove nav container
    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					'menu' => __( 'The Main Menu', 'cf-theme' ),  // nav name
    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					'theme_location' => 'main-nav',                 // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>
					
					</nav>

				</div>

			</header>

		<div id="cta-sidebar" class="sidebar" role="complementary">
			<?php get_sidebar('cta'); ?>
		</div>
			
		<div id="container">

			
