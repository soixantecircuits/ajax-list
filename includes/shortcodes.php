<?php

add_shortcode( 'ajax-list', 'get_list_by_id' );

function get_list_by_id($atts){
  $return = null;

  extract(shortcode_atts( array(
      'id'    => 0
  ), $atts, 'ajax-list' ) );

  $path = Ajax_List::al_check_path('list');

  $list_items = get_post_meta($id, 'repeatable_fields', true);
    ob_start();
    include( $path );
    $return .= ob_get_contents();
    ob_end_clean();

  return $return;
}