<?php
/*
* Plugin Name: PV Lists
* Description: A simple WordPress plgin that produces overview lists for orders and members
* Version: 1.5
* Author: Paul Vincent
* Author URI: https://amervallei.nl
* Text Domain: lists
*/

//  Ensure plugin has been called from WordPress and not directly.
if( !function_exists('add_action' ) ){
  echo "Hi there! I\'m just a plugin, not much I can do when called directly.";
  exit;
}

//  Setup


//  Includes
include( 'includes/activate.php' );
include( 'includes/query-orders.php' );
include( 'includes/query-members.php' );
include( 'includes/display-table.php' );
include( 'includes/download.php' );
include( 'includes/shortcodes/orders.php' );
include( 'includes/shortcodes/members.php' );

//  Hooks
register_activation_hook( __FILE__, 'pv_activate_plugin' );


//  Shortcodes
add_shortcode( 'order-list', 'pv_orders_shortcode' );
add_shortcode( 'member-list', 'pv_members_shortcode' );


// Add custom stylesheet called custom.css
function plugin_stylesheets() {
	wp_register_style( 'pv_lists', plugin_dir_url( __FILE__ ) . 'includes/css/pv-lists.css' );
  // register another file here
  
  // Stylesheets are not applied until the plugin is fired - so this code is moved to the shortcode function
  //wp_enqueue_style( 'pv_lists' );
		// enqueue another file here
	}
  add_action('wp_enqueue_scripts', 'plugin_stylesheets');
