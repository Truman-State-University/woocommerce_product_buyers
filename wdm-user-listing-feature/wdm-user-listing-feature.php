<?php
/**
 * Plugin Name: WisdmLabs User Listing Feature
 * Plugin URI: http://www.wisdmlabs.com/
 * Description: An plugin to list the checkout related data.
 * Version: 1.0.0
 * Author: WisdmLabs
 * Author URI: http://www.wisdmlabs.com
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page() {

	add_menu_page( 'product buyers', 'Product Buyers', 'manage_options', 'wdm-user-listing-feature/display-page/user-listing-admin.php', '','dashicons-groups', 6 );

}