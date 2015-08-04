<?php



if (file_exists( get_stylesheet_directory() . "/library/image-defs.php" )) {
		
	include( get_stylesheet_directory() . "/library/image-defs.php" );
	
} else {

	
	$max = 1400;



	$max_tablet = 600;
	$max_mobile = 320;


	$tablet_ratio = $max_tablet / $max;
	$mobile_ratio = $max_mobile / $max;

	$keepAbove = 150; // don't make thumbnails smaller than this


	$ratio = (9 / 16); // could be 16:9 but this can be restrictive. Photographers often things as 6:4 landscape

	// we're hard coding the 900 value here.  however, this is based on our 'max width' blog which has a max width of 900px

	$featured = array( 735, floor(735 * $ratio), true); // this can be our gallery image
	$panorama = array($max, 600, true); // hard crop. 600px in the CSS.  Generally this is just overf half the screen (1080) so it's okay.

	// a thumbnail is generally going to be in a trio, a 3 column layout.  so if maxwidth is 1000px it's ~ 333px wide, and less with margins thus .33 of 900px
	$thumbnail = array( floor($featured[0] * 0.33), floor($featured[1] * 0.33), true);
	$medium = array( floor($featured[0] * 0.50), floor($featured[1] * 0.50), true);
	$large = array( $featured[0], $featured[1], false); // soft crop featured image


}
/************* THUMBNAIL SIZE OPTIONS *************/

/* sizes needed 

 		gallery


 		gallery-thumb

*/


## Configure your sizes here.  This generally sets the media queries and image sizes to go with it.

 // you'll want to sync this with your LESS variables.






function scale_down_sizes($original_sizes, $ratio) {
	global $keepAbove;
	
	$newArray[0] = floor( $original_sizes[0] * $ratio );
	$newArray[1] = floor($original_sizes[1] * $ratio);
	$newArray[2] = $original_sizes[2];


	$aspect = $newArray[0] / $newArray[1];

	if ($newArray[0] < $keepAbove) {
		
		$newArray[0] = $keepAbove;
		$newArray[1] = $keepAbove / $aspect;

	}
	

	return $newArray;
}


function db_get_image_sizes( $size = '' ) {

        global $_wp_additional_image_sizes;

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {

                if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

                        $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                        $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                        $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

                } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                        $sizes[ $_size ] = array( 
                                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                        );

                }

        }

        // Get only 1 size if found
        if ( $size ) {

                if( isset( $sizes[ $size ] ) ) {
                        return $sizes[ $size ];
                } else {
                        return false;
                }

        }



        return $sizes;

        //.return $sizes;
}

function debug_show_image_sizes() {

	$sizes = db_get_image_sizes();

	ksort($sizes);
	$output = "<PRE>" . print_r($sizes, 1) . "</PRE>";
	return $output;
}

add_shortcode('displayimagesizes', 'debug_show_image_sizes' );
/*
	$tomerge['gallery-large'] = __("Uncropped Responsive Image");
	$tomerge['featured-image'] = __("Cropped*/




$imagesizes = array( 

	// This approach creates a lot of assets, but I don't know if I mind this - it's more important to serve the correct sizes for devices
	// than to save our own server space, which is generally unlimited these days.  Do consider when there is an overlap

	// This does not consider retina displays yet.

	// it also relies heavily on featured-image and gallery-large

	/* add mobile sizes */

	// add upper limit for default sizes

	'large' => $large,
	'large-tablet' => scale_down_sizes($large, $tablet_ratio),
	'large-mobile' => scale_down_sizes($large, $mobile_ratio),

	'medium' => $medium,
	'medium-tablet' => scale_down_sizes($medium, $tablet_ratio),
	'medium-mobile' => scale_down_sizes($medium, $mobile_ratio),
	
	// keep thumbnails a reasonable size for mobiles.
	'thumbnail' => $thumbnail,
	'thumbnail-tablet' => $thumbnail, //scale_down_sizes($thumbnail, $tablet_ratio),
	'thumbnail-mobile' => $thumbnail,
	


	## DO NOT REMOVE THESE WITHOUT RECONFIGURING THINGS BELOW ##

	/*
		It should really be such that it is more dynamic and less hard coded to these two names, and a trio of sizes, 
		but this up for adaptation later and should serve most situations
	*/

	'featured-image' => 		$featured,
	'featured-image-tablet' => 	scale_down_sizes($featured, $tablet_ratio),
	'featured-image-mobile' => scale_down_sizes($featured, $mobile_ratio),

	'panorama' => $panorama,
	'panorama-tablet' => 	scale_down_sizes($panorama, $tablet_ratio),
	'panorama-mobile' => scale_down_sizes($panorama, $tablet_ratio),



	);


// Thumbnail sizes

foreach ($imagesizes as $key => $imagesize) {

	if ($key == 'large' || $key == 'medium' || $key == 'thumbnail') continue;
	add_image_size( $key, $imagesize[0], $imagesize[1], $imagesize[2] );
	@set_post_thumbnail_size( $thumbnail[0] , 	$thumbnail[1], 		$thumbnail[3] ); // feed image

	
}


// fix standard sizes
update_option( 'thumbnail_size_w', $thumbnail[0] );
update_option( 'thumbnail_size_h', $thumbnail[1] );
update_option( 'thumbnail_crop', $thumbnail[2] );


update_option( 'medium_size_w', $medium[0] );
update_option( 'medium_size_h', $medium[1] );
update_option( 'medium_crop', $medium[2] );

update_option( 'large_size_w', $large[0] );
update_option( 'large_size_h', $large[1] );
update_option( 'large_crop', $large[2] );


//update_option('image_default_link_type', 'none' );
update_option('image_default_size', 'medium-tablet' );

/* Change the add media editor, to insert a <picture> if the criteria is right.  

This is flawed in that it may encourage content editors to not use it, which is bad, so we may need to remove the defaults somehow or force this on thumb/medium/large

*/

// only add a responsive image if they asked for one


// prepare and return the actual final responsive image.  This should meet the HTML spec but could be changed if we don't use picture srcset in the future.
// There is a polyfill in the JS to work this, otherwise this is going to break on a lot of browsers as of Jan 2015
function create_picture_element($id, $images, $caption, $title, $align = 'center', $html) {




	    $html = '<picture class="align-' . $align . ' responsive-picture">';
		$html .= '<!--[if IE 9]><video style="display: none;"><![endif]-->';

		global $max, $max_tablet, $max_mobile;

		
		$img_full = wp_get_attachment_image_src($id, $images["large"]["name"]);
		$img_tablet = wp_get_attachment_image_src($id, $images["medium"]["name"]);
		$img_mobile = wp_get_attachment_image_src($id, $images["small"]["name"]);





		$srcset = "";
		
		$srcset .= '<source srcset ="' . $img_mobile[0] . '" media="(max-width: ' . ($max_mobile) . 'px)">';
		$srcset .= '<source srcset ="' . $img_tablet[0] . '" media="(max-width: ' . ($max_tablet) . 'px)">';
		$srcset .= '<source srcset ="' . $img_full[0] . '" media="(min-width: ' . ($max_tablet) . 'px)">'; // anything over basically.
		
		


		$html .= '<!--[if IE 9]></video><![endif]-->';
		$html .= $srcset;
		$html .= '<img src="' . $img_mobile[0] . '" alt="' . $caption . '" title="' . $title . '">';
		$html .= '</picture>';



		return $html;

	
}

function create_img_srcset($id, $images = "", $caption = "", $title = "", $align = "center", $html = "", $minwidth = false, $classes = '') {



		// Let's see if Google prefers this...


	
		global $max, $max_tablet, $max_mobile;




		$images["medium"] = ($images["medium"]["size"] <= $minwidth) ? $images["large"]  : $images["medium"];
		$images["small"] = ($images["small"]["size"] <= $minwidth) ? $images["large"]  : $images["small"];
		

	
		$html = create_picture_element($id, $images, $caption, $title, 'nada', $html);


		
		
		return $html;
		/*

		// old srcset version that appaz Google doesn't like.

		$html .= '<img class="responsive-picture align-' . $align . '" src="' . $img_mobile[0] . '"';

		$html .= ' srcset="'
					. $img_full[0] . ' ' . $img_full[1] . 'w, '
					. $img_tablet[0] . ' ' . $img_tablet[1] . 'w, '
					. $img_mobile[0] . ' ' . $img_mobile[1] . 'w" '
				;

		$html .= ' sizes="(min-width: 768px) 66.6vw, 100vw"';


		$html .= ' alt="' . $caption . '" title="' . $title . '">';


		return $html;

		*/
}


function responsive_image($id, $size, $classes = '', $minwidth = false) {
	$images = get_image_src_list($size);
	//	   create_img_srcset($id, $images,	$caption, 	$title, 	$align, 	$html, 	$minwidth, 	$classes = '')
	return create_img_srcset($id, $images, 	"", 		"", 		"center", 	"", 	$minwidth, 	$classes);
}


// work out what images we can output.  For ease, we're only going with 3 images.
function get_image_src_list($size) {

	
		global $imagesizes;
		$images = array(
					"large" => array(
						"name" => $size,
						"size" => $imagesizes[$size][0]
						),
					"medium" => array(
						"name" => $size . "-tablet",
						"size" => $imagesizes[$size . "-tablet"][0]
						),
					"small" => array(
						"name" => $size . "-mobile",
						"size" => $imagesizes[$size . "-mobile"][0]
						),
					);
	
	
	return $images;
}




// to be used instead of get_the_thumbnail.  However we haven't been able to make the filter work with this so it's a manual call in teh templates.
function responsive_image_thumbnail( $post_id = null, $size = 'featured-image', $attr = '', $imageID = false, $minwidth = false) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	
	// $imageID, if true, indicates that the ID passed in the feirst parameter is actualy an Image ID, rather than the post ID for which we want a featured image.

	$post_thumbnail_id = $imageID ? $post_id : get_post_thumbnail_id( $post_id );



	if ( $post_thumbnail_id ) {

		$images = get_image_src_list($size);
		return create_img_srcset($post_thumbnail_id, $images, "", "", "center", "", $minwidth);

	} else {
		return '';
	}
	
}



// Change a shortcode into a responsive image.  This should stop the 
function responsive_image_shortcode($atts) {

	$images = get_image_src_list($atts["size"]);
	return create_picture_element($atts["id"], $images, $atts["caption"], $atts["title"], $atts["align"], ""); // no html

}
add_shortcode( 'responsive_image', 'responsive_image_shortcode' );


// create a shortcode for the responsive image.  We'll be sending that to the editor instead of the original one.
function create_picture_shortcode($id, $size, $caption, $title, $html, $align) {

	return "[responsive_image id='" . $id . "' size='" . $size . "' caption='" . $caption . "' title='" . $title . "' align='" . $align . "']"; 

	// .  $html . "[/responsive_image]";
	// we could wrap in the original HTML but we won't as this can break and stops people understanding that the image might get ditched.  Make them put in a new shortcode.
}


// Send a shortcode to the editor IF they picked a size which is a responsive set.
function responsive_editor_filter($html, $id, $caption, $title, $align, $url, $size) {
    
    // this should probably be a bit more dynamic but then it's linked to the editor add sizes below so, it's okay for now.
    if ($size == "gallery-large" || $size == "featured-image") {
	    return create_picture_shortcode($id, $size, $caption, $title, $html, $align);
    } else {
    	return $html;
    }
}
/*
	We are disabling this for now until we can test and develop a solution better.  
	It's probably okay if people can just make sure they use sensibly sized images
*/

//	add_filter('image_send_to_editor', 'responsive_editor_filter', 10, 9);


function insert_fill_width_image($html, $id, $caption, $title, $align, $url, $size) {
    
    // this should probably be a bit more dynamic but then it's linked to the editor add sizes below so, it's okay for now.
    
    if (substr($size, -7) == "-tablet") {

    	$size = substr($size,0,-7);

		
		// get the 'large' sie but change align
		$html = get_image_tag($id, $alt, '', 'full-width', $size);	
        
	
	    if ( $url ) {
	    	$html = "<a href=\"" . $url . "\">" . $html . "</a>";
	    	return oikos_get_attachment_link_filter( $html, $id, $size, false );
	    }
			

		return $html;
    
    } else {
    	return oikos_get_attachment_link_filter( $html, $id, $size, false );
    	//return $html;
    }
}
add_filter('image_send_to_editor', 'insert_fill_width_image', 10, 9);

// We may not want this, but it's going to kick in for the gallery, which won't be using picture fill.
// This is a server side replacing of the images.  We can only do this because it's a shortcode.
// We might want to do this for the shortcode of responsive images but the serverside PHP is 
// less effective than client side media queries
add_filter("post_thumbnail_size","responsive_conditional_size");
function responsive_conditional_size($size) {

	if (ISMOBILE) {
		$newsize = $size . "-mobile";
	} else if (ISTABLET) { 
		$newsize = $size . "-tablet";		
	} else {
		// no change needed, we're on a desktop m9s
		return $size;
	}

	// if we got this far then work out a new size
	global $imagesizes;

	if (isset($imagesizes[$newsize])) {

		return $newsize;
	} else {
		return $size; // if we didn't define it we can't ask for it, just give the original
	}
}



// add the new sizes to the WP image insert thing.

add_filter( 'image_size_names_choose', 'cf_custom_image_sizes' );

function cf_custom_image_sizes( $sizes ) {

	//global $imagesizes;
	$tomerge = array();
	$tomerge['large'] = __("Uncropped Image");

	// THIS IS BEING HACKED ABOVE.  It will not send Panorama ever until you change the filter above
	// I am assuming that we will never need a panorama in the wordpress editor because that'd be weird.  
	// But wordpress needs a "real" image size before it'll add it to the editor thing. 
	// So we can't use a placeholder just to add an option and send to editro etc.
	// Above we change panorama to large, but add a special align.
	//$tomerge['panorama'] = __("Fill Width Image (ignores alignment)"); 
	$tomerge['large-tablet'] = __("Large, Fill Width (ignores alignment)");	
	$tomerge['medium-tablet'] = __("Medium, Fill Width (ignores alignment)");	
	$tomerge['thumbnail-tablet'] = __("Thumbnail, Fill Width (ignores alignment)");	
	
	$tomerge['featured-image'] = __("Cropped  Image");	
	
    return array_merge( $sizes, $tomerge );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

// Now fix the gallery:
require_once("gallery.php");

