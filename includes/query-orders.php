<?php

function query_orders(){
    // return '<br>Test for getting orders. This text is coming from the query_orders function!';

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }

    global $wpdb;

	$sql = <<<SQL
            SELECT
            oi.order_id Nr,
            DATE_FORMAT(p.post_date, '%d.%m.%Y' ) Datum,
            u.display_name Naam,
            u.ID Lid,
            oi.order_item_name Product,
            max(case when oim.meta_key = '_qty' then oim.meta_value end) Stk,
            max(case when oim.meta_key = '_line_total' then oim.meta_value end) Euro
            FROM
            www_woocommerce_order_itemmeta oim
            JOIN www_woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
            JOIN www_posts p ON oi.order_id = p.ID
            JOIN www_postmeta pm ON oi.order_id = pm.post_id
            JOIN www_users u ON pm.meta_value = u.ID
            WHERE
            pm.meta_key = '_customer_user'
            AND to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            GROUP BY
            oim.order_item_id
            ORDER BY
            oi.order_id desc;
            SQL;

    $results = $wpdb->get_results( $sql, OBJECT );

    display_table( $results );

}
