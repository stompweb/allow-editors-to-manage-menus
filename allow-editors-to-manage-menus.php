<?php
/*
Plugin Name: Allow Editors to manage menus
Plugin URI: http://stomptheweb.co.uk
Description: Allows Editors to manage menus.
Version: 1.0.0
Author: Steven Jones
Author URI: http://stomptheweb.co.uk/
License: GPL2
*/

function aemm_give_editors_menu_management() {

	// get the the role object
	$role_object = get_role( 'editor' );

	// add $cap capability to this role object
	$role_object->add_cap( 'edit_theme_options' );

}
add_action('admin_init', 'aemm_give_editors_menu_management');

// Remove the Appearance Menu item for Editors
function aemm_remove_appearance_menu_item() {

	if ('editor' == get_current_user_role())
		remove_menu_page('themes.php');

}
add_action( 'admin_menu', 'aemm_remove_appearance_menu_item' );

// Setup a dedicated Menus item
function aemm_register_menu_page(){

    add_menu_page( 'Menus', 'Menus', 'edit_pages', 'menus', 'aemm_menu_redirect', 'dashicons-list-view', 40 ); 

}
add_action( 'admin_menu', 'aemm_register_menu_page' );

// This is hack central, but the best way I could think it could be done
function aemm_menu_redirect(){ ?>

    <meta http-equiv="refresh" content="0;URL='<?php echo admin_url(); ?>nav-menus.php'" />  

<?php }

// Helper function to get the current user's role
function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return $role;
}