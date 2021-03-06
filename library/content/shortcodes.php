<?php


function cf_wide_background($atts, $content) {


	 $atts = shortcode_atts( array(
        'class' => '',
        'id' => '',
    ), $atts );


	
	$output = "<div class='full-width-background " . $atts["class"] . "'";

	$output .= ($atts["id"]) ? " id='" . $atts["id"] . "'>" : ">";

	$output .= $content;	
	$output .= "</div>";
	

	return $output;
}




function cf_popup_content($atts, $content) {

	/* 
			
	1 PHP:
	1.1 wrap around in a div with special class
	1.2 do shortcodes inside
	
	[popupwindow text='Click me' element='a' class='classname' id='id' 'attributes'='']
	*/

	// we may need to add an ID to remember the originating box in javascript.  Let's see if not though.

	$atts = shortcode_atts( array(
			    'text' => 'More Information', // not really optional but let's not srew up thigns
			    'element' => 'a',
			    'attributes' => false,
			    'id' => false,
			    'class' => false,
			), $atts );

	$opening_chunk = "<";
	if ($atts["element"] == "a" && $atts["attributes"] == false) {
		$opening_chunk .= "a href='#' ";
	} else {
		$opening_chunk .= $atts["element"] . " " . $atts["attributes"] . " ";
	}

	if ($atts["class"]) {
		$opening_chunk .= "class='popup-button " . $atts["class"] . "' ";
	} else {
		$opening_chunk .= "class='popup-button' ";
	}

	if ($atts["id"]) { $opening_chunk .= "id='" . $atts["id"] . "'"; }


	$opening_chunk .= ">" . $atts["text"] . "</" . $atts["element"] . ">";
	
	return "<div class='cf-popup-box'>" . $opening_chunk . "<div class='popup mfp-hide'>" . do_shortcode( $content ) . "</div></div>";
}

add_shortcode( 'popupwindow', 'cf_popup_content' );



// contact details from options page

function cf_option_get_contact_details($args)
{
	switch ($args["type"])
	{
		case "facebook":
		if ($args["link"]) { return "<a href='" . get_option('cf_option_facebook') . "'>" . $args["link"] . "</a>"; } else { return get_option('cf_option_facebook'); }
		break;
		
		case "linkedin":
		if ($args["link"]) { return "<a href='" . get_option('cf_option_linked_in') . "'>" . $args["link"] . "</a>"; } else { return get_option('cf_option_linked_in'); }
		break;
		
		case "twitter":
		if ($args["link"]) { return "<a href='" . get_option('cf_option_twitter') . "'>" . $args["link"] . "</a>"; } else { return get_option('cf_option_twitter'); }
		
		case "email":
		if ($args["link"]) { 
			if ($args["link"] == "useaddress") 
			{ 
				$linktext = get_option('cf_option_email');
				return "<a href='mailto:" . $linktext . "'>" . $linktext . "</a>";
			} else { 
				return "<a href='mailto:" . get_option('cf_option_email') . "'>" . $args["link"] . "</a>";
			}
		} else {
			return get_option('cf_option_email');
		}
		
		break;

		case "phone":
		case "telephone":
		if ($args["link"]) {
			return "<a href='tel:" . str_replace(" ", "", get_option('cf_option_phone')) . "'>" . $args["link"] . "</a>"; 
		} else { 
			return "<a href='tel:" . str_replace(" ", "", get_option('cf_option_phone')) . "'>" . get_option('cf_option_phone') . "</a>"; 
		}
		break;

		default:
		return get_option('cf_option_phone');
	}
}
add_shortcode('contactinfo','cf_option_get_contact_details');


add_shortcode('linkphone', 'cf_get_phone_link');

function cf_get_phone_link() {
	$tel = get_option('cf_option_phone');
	$c_tel = str_replace(" ","",$tel);
	$format_tel = (substr($c_tel,0,1) == "0" && substr($c_tel,1,1) != "0") ? "+44" . substr($tel, 1) : $c_tel;
	return "<a href='tel:" . str_replace(" ", "", $format_tel) . "' class='linkphone'>" . get_option('cf_option_phone') . "</a>";
}


add_shortcode( 'showposts', 'cf_postsfeed' );	
function cf_postsfeed($atts) {

	$atts = shortcode_atts( array(
		'category' => false,
		'number' => 4,
		'post_type' => 'post'
		)

	, $atts, 'showposts' );		


	$args = $atts; // let people do a full wp_query, but do some overrides for security...

	$args["post_status"] = 'publish'; // don't let people show private ones at this stage.

	$args["post_type"] = $atts["post_type"];

	if ($atts["category"]) {
		$args["category_name"] = $atts["category"];
	}

	$args["posts_per_page"] = $atts["number"];


	$posts_array = get_posts( $args );


	
	// The Loop
	$output = "";

	
	if (count($posts_array)) {
	
		ob_start();
		echo "<ul class='post-list shortcode-post-list'>";
			foreach ( $posts_array as $post ) : setup_postdata( $post );
			
			
				global $more;    // Declare global $more (before the loop).
				$more = 0;       // Set (inside the loop) to display content above the more tag.
					
					//add_filter('the_content','my_strip_tags');

				
				?>


				<li class='post-preview'>
					<a href='<?php echo get_permalink( $post->ID ); ?>'>
						<div class='image-container'>
							<?php
							if (has_post_thumbnail($post->ID)) {
								echo responsive_image_thumbnail($post->ID, 'thumbnail');
							}
							?>
						</div>	

						<h4><?php echo $post->post_title; ?></h4>
					</a>
					
					<div class='excerpt'>
						<?php echo string_limit_words( $post->post_excerpt, 40 ); ?>
					</div>
				</li>
		<?php
			
			endforeach;
			wp_reset_postdata();
		echo "</ul>";

		$output = ob_get_contents();

		ob_end_clean();

	}

	return $output;
}