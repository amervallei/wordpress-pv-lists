<?php

function pv_members_shortcode(){
    // apply custom css from the plugin to this shortcode only
    wp_enqueue_style( 'pv_lists' );

    // run database query
    return query_members();
}
