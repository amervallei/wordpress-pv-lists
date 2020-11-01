<?php

function pv_members_shortcode(){

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }
    
    // apply custom css from the plugin to this shortcode only
    wp_enqueue_style( 'pv_lists' );

    /* run database query to collect extensive data for download */
    $results = query_members_full();

    /* convert to csv file and provide download button */
    echo convert_to_csv($results, 'members.csv', ',');

    /* run database query to collect limited data for display on screen */
    $results = query_members();
    
    /* convert to table and display on screen */
    return display_table( $results );

}
