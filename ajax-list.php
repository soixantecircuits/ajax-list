<?php

// THIS IS A COMMENT WITH A TEMPLATE ENTRY Ajax List

/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
* @package   Ajax_List
* @author    Shiyue Wang shiyue@soixantecircuits.fr
* @license   GPL-2.0+
* @link      http://soixantecircuits.fr
* @copyright 2014 Shiyue Wang
 *
 * @wordpress-plugin
 * Plugin Name:       Ajax List
 * Plugin URI:        
 * Description:       @TODO
 * Version:           1.0.0
 * Author:            Shiyue Wang
 * Author URI:        http://soixantecircuits.fr
 * Text Domain:       plugin-name-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages

 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-ajax-list.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */

register_activation_hook( __FILE__, array( 'Ajax_List', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Ajax_List', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Ajax_List', 'get_instance' ) );

require_once plugin_dir_path(  __FILE__  ) . 'includes/shortcodes.php';


/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-ajax-list-admin.php' );
	add_action( 'plugins_loaded', array( 'Ajax_List_Admin', 'get_instance' ) );

}
