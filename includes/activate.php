<?php

function pv_activate_plugin(){
  //  If WordPress version is below 5.0 do not activate.
  if( version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ){
    wp_die( _( "You must update WordPress to use this plugin.", 'recipe' ) );
  }
}
