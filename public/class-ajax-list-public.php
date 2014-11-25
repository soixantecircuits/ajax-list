<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Ajax_List
 * @subpackage Ajax_List/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ajax_List
 * @subpackage Ajax_List/public
 * @author     Shiyue Wang <shiyue@soixantecircuits.fr>
 */
class Ajax_List_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ajax_list    The ID of this plugin.
	 */
	private $ajax_list;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $ajax_list       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $ajax_list, $version ) {

		$this->ajax_list = $ajax_list;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ajax_List_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ajax_List_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->ajax_list, plugin_dir_url( __FILE__ ) . 'css/ajax-list-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ajax_List_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ajax_List_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->ajax_list, plugin_dir_url( __FILE__ ) . 'js/ajax-list-public.js', array( 'jquery' ), $this->version, false );

	}

}
