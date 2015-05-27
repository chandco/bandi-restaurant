<?php

// Restrict users to control people's access

function add_theme_caps() {
    
    // gets the author role
    $role = get_role( 'administrator' );

	// create custom capability to let admins add pages, but no-one else effectively
    $role->add_cap( 'add_pages' ); 

    $role = get_role( 'editor' );
    // change the default, allow editors to change theme options such as menus, header, widgets etc.
    $role->add_cap( 'edit_theme_options' ); 


}
add_action( 'admin_init', 'add_theme_caps');


function remove_add_new_page() {

  if (!current_user_can('add_pages') ) {
  	// hide the add new page buttons.
  ?>
  <style>
  #wp-admin-bar-new-page {
    display:none;
  }

  a[href*='post-new.php?post_type=page'] {
    display: none !important;
  }

  </style>
  <?php }
}
add_action( 'admin_print_styles', 'remove_add_new_page');



add_action('load-page-new.php', function() {

	// hopefully no-one sees this, because they won't see the links.  But in case we missed any...
  if (!current_user_can('add_pages') ) {
    die("Sorry, you do not have access to this page");
  }

});