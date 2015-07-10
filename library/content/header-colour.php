<?php


/**
 * Calls the class on the post edit screen.
 */
function call_CH_pageColorPicker() {
    new CH_pageColorPicker();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_CH_pageColorPicker' );
    add_action( 'load-post-new.php', 'call_CH_pageColorPicker' );
}

/** 
 * The Class.
 */


class CH_pageColorPicker {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */

	public function colours() {
		return array(
				 "grey"			=>		 	"#999999"
				,"green"		=>			"#278B27"
				,"blue"			=>		 	"#A5b2C7"
				,"lightgreen"	=>			"#6c780f"
				,"purple"		=>			"#9A97B8"
				,"black"		=>			"RGB(33,33,33)"
				,"white"		=>			"RGB(255,255,255)"
				,"orange"		=>			"#BE904D"
			);
	}
	public function add_meta_box( $post_type ) {
            $post_types = array('post', 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'ch_page_color_picker'
			,'Page Colour Picker'
			,array( $this, 'render_meta_box_content' )
			,$post_type
			,'advanced'
			,'high'
		);
            }
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['ch_colorpicker_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ch_colorpicker_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'ch_colorpicker_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['ch_colorpicker_color'] );

		// Update the meta field.
		update_post_meta( $post_id, 'page_color', $mydata );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'ch_colorpicker_inner_custom_box', 'ch_colorpicker_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, 'page_color', true );

		// Display the form, using the current value.
		
		_e( 'Description for this field', 'ch_colorpicker_textdomain' );
		?>
		<ul class='theme-colour-picker'>

			<?php 
			
			foreach ($this->colours()  as $name => $color) {

				$checked = ($value == $name) ? " checked" : "";
				echo "<li data-color='" . $name . "' class='" . $name . "' style='background: " . $color . ";'><label><input type='radio' name='ch_colorpicker_color' value='" . $name . "' " . $checked . "><span>" . $name . "</span></label></li>";
			}


			?>
	
	
		</ul>
	<?php
		
	
	}
}