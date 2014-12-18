<?php

// THIS IS A COMMENT WITH A TEMPLATE ENTRY Ajax List

/**
 * Plugin Name.
 *
 * @package   Ajax_List
 * @author    Shiyue Wang shiyue@soixantecircuits.fr
 * @license   GPL-2.0+
 * @link      http://soixantecircuits.fr
 * @copyright 2014 Shiyue Wang
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-ajax-list.php`
 *
 * @package Ajax_List_Admin
 * @author  Shiyue Wang shiyue@soixantecircuits.fr
 */
class Ajax_List_Admin {

  /**
   * Instance of this class.
   *
   * @since    1.0.0
   *
   * @var      object
   */
  protected static $instance = null;

  /**
   * Slug of the plugin screen.
   *
   * @since    1.0.0
   *
   * @var      string
   */
  protected $plugin_screen_hook_suffix = null;

  /**
   * Initialize the plugin by loading admin scripts & styles and adding a
   * settings page and menu.
   *
   * @since     1.0.0
   */
  private function __construct() {

    /*
     * @TODO :
     *
     * - Uncomment following lines if the admin class should only be available for super admins
     */
    /* if( ! is_super_admin() ) {
      return;
    } */

    /*
     * Call $plugin_slug from public plugin class.
     */
    $plugin = Ajax_List::get_instance();
    $this->plugin_slug = $plugin->get_plugin_slug();

    // Load admin style sheet and JavaScript.
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

    // Add the options page and menu item.
    add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
    add_action( 'admin_init', array( $this, 'register_mysettings' ) );

    // Add an action link pointing to the options page.
    $plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
    add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

    /*
     * Define custom functionality.
     *
     * Read more about actions and filters:
     * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
     */
    add_action('add_meta_boxes', array( $this, 'al_add_meta_boxes') );
    add_action('save_post', array( $this, 'al_meta_box_save'));

    add_action('edit_form_top', array( $this, 'shortcode_on_the_top'));

    add_filter('manage_ajax_list_posts_columns' , array( $this, 'set_ajax_list_columns'));

    add_action('manage_posts_custom_column' , array( $this, 'ajax_list_columns'), 10, 2 );

  }

  /**
   * Return an instance of this class.
   *
   * @since     1.0.0
   *
   * @return    object    A single instance of this class.
   */
  public static function get_instance() {

    /*
     * @TODO :
     *
     * - Uncomment following lines if the admin class should only be available for super admins
     */
    /* if( ! is_super_admin() ) {
      return;
    } */

    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  /**
   * Register and enqueue admin-specific style sheet.
   *
   * @since     1.0.0
   *
   * @return    null    Return early if no settings page is registered.
   */
  public function enqueue_admin_styles() {

    if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
      return;
    }

    $screen = get_current_screen();
//    if ( $this->plugin_screen_hook_suffix == $screen->id  || $screen->id == 'ajax_list' ) {
      wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Ajax_List::VERSION );
//    }

  }

  /**
   * Register and enqueue admin-specific JavaScript.
   *
   * @since     1.0.0
   *
   * @return    null    Return early if no settings page is registered.
   */
  public function enqueue_admin_scripts() {

    if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
      return;
    }

    $screen = get_current_screen();
    if ( $this->plugin_screen_hook_suffix == $screen->id || $screen->id == 'ajax_list' ) {
      wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Ajax_List::VERSION );
    }
  }

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
  public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     * @TODO:
     *
     * - Change 'Page Title' to the title of your plugin admin page
     * - Change 'Menu Text' to the text for menu item for the plugin settings page
     * - Change 'manage_options' to the capability you see fit
     *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
     */
    $this->plugin_screen_hook_suffix = add_options_page(
        __( 'Ajax List options', $this->plugin_slug ),
        __( 'Ajax List', $this->plugin_slug ),
        'manage_options',
        $this->plugin_slug,
        array( $this, 'display_plugin_admin_page' )
    );

  }

  public function register_mysettings() { // whitelist options
    register_setting( 'ajax-list-option-group', 'ajax-list_page_id' );
//    register_setting( 'ajax-list-option-group', 'sweet_opt' );
//    register_setting( 'ajax-list-option-group', 'test_opt' );
  }

  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  public function display_plugin_admin_page() {
    include_once( 'views/admin.php' );
  }

  /**
   * Add settings action link to the plugins page.
   *
   * @since    1.0.0
   */
  public function add_action_links( $links ) {

    return array_merge(
        array(
            'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
        ),
        $links
    );

  }

  public function al_add_meta_boxes() {
    add_meta_box( 'list-items',
        __('Liste des cours', $this->plugin_slug),
        array($this, 'al_list_items_meta_box_display'),
        'page', 'normal', 'default');
  }

  function al_list_items_meta_box_display($post) {
    $list_items = get_post_meta($post->ID, 'repeatable_fields', true);
    $dropdown_args = array(
        'post_type'        => 'courses',
        'name'             => 'item_links[]',
        'sort_column'      => 'menu_order, post_title',
        'echo'             => 1,
        'id' => '0',
        'selected' => 0
    );

    wp_nonce_field( 'al_list_items_meta_box_nonce', 'al_list_items_meta_box_nonce' );
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
          var id_count =  parseInt($( '.empty-row.screen-reader-text .page-selector select' ).attr('id'));
          $('.empty-row.screen-reader-text .page-selector select' ).attr('id', id_count + 1);
          var row = $( '.empty-row.screen-reader-text' ).clone(true);
          row.removeClass( 'empty-row screen-reader-text' );
          row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
          return false;
        });

        $( '.remove-row' ).on('click', function() {
          $(this).parents('tr').remove();
          return false;
        });
      });
    </script>

    <table id="repeatable-fieldset-one" width="100%">
      <thead>
      <tr>
<!--        <th width="40%">--><?php //echo __('Name', $this->plugin_slug)?><!--</th>-->
        <th width="80%"><?php echo __('Cours', $this->plugin_slug)?></th>
        <th width="20%"></th>
      </tr>
      </thead>
      <tbody>
      <?php

      if ( $list_items ) :
        foreach ( $list_items as $key=>$field ) {
          $dropdown_args['id']=$key;
          $dropdown_args['selected']=$field['page'];
          ?>
          <tr>
<!--            <td><input type="text" class="widefat" name="name[]" value="--><?php //if($field['name'] != '') echo esc_attr( $field['name'] ); ?><!--" /></td>-->
            <td class="page-selector"> <?php wp_dropdown_pages( $dropdown_args); ?> </td>
            <td><a class="button remove-row" href="#"><?php echo __('Supprimer', $this->plugin_slug)?></a></td>
          </tr>
        <?php
        }
      else :
        // show a blank one
        ?>

      <?php endif; ?>

      <tr class="empty-row screen-reader-text">
<!--        <td><input type="text" class="widefat" name="name[]" /></td>-->
        <td class="page-selector"> <?php wp_dropdown_pages( $dropdown_args ); ?> </td>
        <td><a class="button remove-row" href="#"><?php echo __('Supprimer', $this->plugin_slug)?></a></td>
      </tr>
      </tbody>
    </table>

    <p><a id="add-row" class="button" href="#"><?php echo __('Ajouter un cours', $this->plugin_slug)?></a></p>
  <?php
  }

  public function al_meta_box_save($post_id) {
    if ( ! isset( $_POST['al_list_items_meta_box_nonce'] ) ||
        ! wp_verify_nonce( $_POST['al_list_items_meta_box_nonce'], 'al_list_items_meta_box_nonce' ) )
      return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;

    if (!current_user_can('edit_post', $post_id))
      return;

    $old = get_post_meta($post_id, 'repeatable_fields', true);
    $new = array();

//    $names = $_POST['name'];
    $page_id = $_POST['item_links'];
    $count = count( $page_id ) - 1; //Remove the empty row

    for ( $i = 0; $i < $count; $i++ ) {
      if ( $page_id[$i] != '' ) :
//        $new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
        $new[$i]['page'] = $page_id[$i];
      endif;
    }

    if ( !empty( $new ) && $new != $old )
      update_post_meta( $post_id, 'repeatable_fields', $new );
    elseif ( empty($new) && $old )
      delete_post_meta( $post_id, 'repeatable_fields', $old );
  }


  public function shortcode_on_the_top( $post ) {
    if ($post->post_type == 'ajax_list'){
      echo '<div id="ajax-list-shortcode-holder">';
      echo '<h3 id="ajax-list-shortcode-title"><span>'. __('Use the shortcode below to display this member', $this->plugin_slug).'</span></h3>';
      echo "<input type='text' id='member-shortcode'"." value='[ajax-list id=".$post->ID."]' readonly>";
      echo '</div>';
    }
  }

  function set_ajax_list_columns($columns) {
    return array(
        'title'       => __('Title', Ajax_List::get_instance()->get_plugin_slug()),
        'ajax_list_shortcode'   => __('Shortcode', Ajax_List::get_instance()->get_plugin_slug()),
    );
  }


  function ajax_list_columns( $column, $post_id ) {
    switch ( $column ) {
      case 'ajax_list_shortcode' :
        echo "<input type='text' readonly value='[ajax-list id=".$post_id."]'>";
        break;
    }
  }

}
