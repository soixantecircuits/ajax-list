<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Ajax_List
 *
 * @wordpress-plugin
 * Plugin Name:       Ajax List
 * Plugin URI:        https://github.com/soixantecircuits/ajax-list
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            Shiyue Wang
 * Author URI:        http://soixantecircuits.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ajax-list
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ajax-list-activator.php
 */
function activate_ajax_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajax-list-activator.php';
	Ajax_List_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ajax-list-deactivator.php
 */
function deactivate_ajax_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajax-list-deactivator.php';
	Ajax_List_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ajax_list' );
register_deactivation_hook( __FILE__, 'deactivate_ajax_list' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ajax-list.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ajax_list() {

	$plugin = new Ajax_List();
	$plugin->run();

}
run_ajax_list();
