<?php

function shortcode_empty_paragraph_fix( $content ) {

    // define your shortcodes to filter, '' filters all shortcodes
    $shortcodes = array( 'feature-box' );
    
    foreach ( $shortcodes as $shortcode ) {
        
        $array = array (
        	
          	 '<p>[' . $shortcode 		=> '[' .$shortcode
           , '<p>[/' . $shortcode 		=> '[/' .$shortcode
           , $shortcode . ']</p>' 		=> $shortcode . ']'
           , $shortcode . ']<br />' 		=> $shortcode . ']'
			
            
        );

        $content = strtr( $content, $array );
    }

    

    return $content;
}



add_filter( 'the_content', 'cf_fix_broken_columns' , 8);
function cf_fix_broken_columns($content) {
	$result = preg_replace(
    '/\]\s+\[/', 
    '][', $content);

    return $result;

}




//remove_filter( 'the_content', 'do_shortcode', 11 );
//remove_filter('the_content', 'wpautop');



//add_filter( 'the_content', 'cf_fix_broken_columns' , 1);
// add_filter('the_content', 'wpautop', 99);
//add_filter( 'the_content', 'cf_cleanup', 99 );


//add_filter( 'the_content', 'do_shortcode', 100 );

//add_filter( 'the_content', 'cf_cleanup', 100 );


function cf_cleanup($content) {
	

	$array = array (
        	
          	 '<p></a></p>'		=> '</a>'
			
            
        );

     $content = strtr( $content, $array );

     return $content;
	
}



add_action( 'wp_ajax_get_shortcode_preview', 'prefix_ajax_add_foobar' );
add_action( 'wp_ajax_nopriv_shortcode_preview', 'prefix_ajax_add_foobar' );

function prefix_ajax_add_foobar() {
    // Handle request then generate response using WP_Ajax_Response

  $array = array (
      "{gallery" => "[gallery",
      "{feature-box" => "[feature-box"
  );

  $post = strtr( $_REQUEST['content'], $array);
  
	die( json_encode( do_shortcode( stripslashes(  $post  ) ) ) );
	
}


function views_ed_columns() {

	// manual localisation before I find a better way.
    
	?>

	<?php // list the views here ?>
		<script type="text/html" id="tmpl-editor-columns-box">
		
				<div class='row {{data.colour}}'>
					
						<# if ( data.innercontent ) { #>
							<p>{{ data.innercontent }}</p>
						<# } #>

				</div>

		
			</script>


			<script type="text/html" id="tmpl-editor-columns-box-column">
		
				<div class='column {{data.colour}}'>
					
						<# if ( data.innercontent ) { #>
							<p>{{ data.innercontent }}</p>
						<# } #>

				</div>

		
			</script>
	<?php
}




function shortcode_ed_columns($atts, $content = false) {


	$wrong_X = '&#215;';
	$right_X = 'x';

	$content = str_replace($wrong_X, $right_X, $content);

//	$content = ($content);

	$array = array (
	    '<p>[' => '[', 
	    ']</p>' => ']', 
	    ']<br />' => ']'
	);

	
  




// 	$content = strtr($content, $array);

	$output .= '<div class="row">' . do_shortcode( $content ) . '</div>';

	
	return $output; 
}



function shortcode_ed_column($atts, $content) {

	
	$wider = "";	

	if (is_array($atts)) {
		if (in_array('extend', $atts)) {

			$wider = " wider";

		}
	} else {
		if (strstr($atts, 'extend')) {
			$wider = " wider";
		}
	}

	$shortcodes = array( 'feature-box' );
    
    foreach ( $shortcodes as $shortcode ) {
        
        $array = array (
        	
          	 '<p>[' . $shortcode 		=> '[' .$shortcode
           , '<p>[/' . $shortcode 		=> '[/' .$shortcode
           , $shortcode . ']</p>' 		=> $shortcode . ']'
           , $shortcode . ']<br />' 		=> $shortcode . ']'
			
            
        );

        $content = strtr( $content, $array );
    }

   

    
	$output = '<div class="col-smart' . $wider . '">' . ( ( do_shortcode( $content ) ) ) . '</div>';
	return $output; 
}


add_shortcode( 'columns-box', 'shortcode_ed_columns' );
add_shortcode( 'column', 'shortcode_ed_column' );




// Create the ajax page needed
add_action( 'admin_menu', 'mcea_ed_columns_init' ); 
function mcea_ed_columns_init() {
	add_submenu_page( null, 'Edit Columns Box', 'Edit Columns Box', 'upload_files', 'columns-box-edit', 'ed_columns_page' );
}


// The edit popup that appears in an ifram
	function ed_columns_page() {

		
		?>

		<style>	

	
		#wpadminbar, #adminmenuwrap, #adminmenuback {
			display: none;
		}

		.media-modal {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 38px;
			z-index: 160000;
		}

	
		</style>

		
		<div id='wp-popup-editor-wrap-wrap'>
			<?php wp_editor( '', 'popup-editor', array('editor_height' => 490) ); ?>
			<P><button class="button-primary button update editor-update">Update Column</button></P>
		</div>

		<div id='column-row' class='row'>

		</div>

		<button id='mce-update' class='button button-primary'>Update</button> <button id='mce-close' class='button'>Close without Updating</button>
		<div class='clearfix'></div>
		
<?php
		 
		   
		       
		 
		   

		 		



	}
//}
//$menu = new mcea();

?>