<?php

function pv_recipes_shortcode(){

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }

    // apply custom css from the plugin to this shortcode only
    wp_enqueue_style( 'pv_lists' );
    
    // get and display recipes
    $results = pv_get_recipes();
    return pv_display_recipes( $results );

}

function pv_get_recipes(){
    global $wpdb;

	$sql = <<<SQL
                SELECT
                    p.post_title,
                    p.post_excerpt,
                    p.guid,
                    t.name
                FROM
                    {$wpdb->prefix}posts p
                    INNER JOIN www_term_relationships r ON p.ID = r.object_id
                    INNER JOIN www_term_taxonomy x ON r.term_taxonomy_id = x.term_taxonomy_id
                    INNER JOIN www_terms t ON x.term_id = t.term_id
                    
                WHERE
                --	p.post_type = 'wprm_recipe' AND 
                    p.post_status = 'publish' AND 
                    t.name IN ( 'Klasse A', 'Klasse B', 'Klasse C', 'Klasse D' ) AND 
                    x.taxonomy = 'category'
                --	x.taxonomy = 'wprm_bierklasse'
                    
                GROUP BY 
                    t.name,
                    p.post_title
            SQL;

    return $wpdb->get_results( $sql, OBJECT );

}

function pv_display_recipes( $results ){
    $output = '<table>';
    foreach( $results as $row){
        $output .= '<tr><td><a href="' . $row->guid . '">' . $row->post_title . '</a></td><td>' . $row->name . '</td><td>' . $row->post_excerpt . '</td></tr>';
    }
    $output .= '</table>';

    return $output;

}