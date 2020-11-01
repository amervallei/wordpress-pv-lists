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
                p.ID Nr, 
                DATE_FORMAT(p.post_date, '%d.%m.%Y' ) Datum,
                CONCAT(oc.first_name, ' ', oc.last_name) Naam,
                os.customer_id Lid, 
                oi.order_item_name Product, 
                os.num_items_sold Stk,
                CONCAT(regexp_substr(os.total_sales, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', os.total_sales) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(os.total_sales , '[.].+' ) , '0'),3)
                        END
                    )
                Euro
            FROM
            	{$wpdb->prefix}posts p
                INNER JOIN	{$wpdb->prefix}wc_order_stats os ON p.ID = os.order_id
                INNER JOIN	{$wpdb->prefix}woocommerce_order_items  oi ON p.ID = oi.order_id
                INNER JOIN	{$wpdb->prefix}wc_customer_lookup oc ON os.customer_id = oc.customer_id
            WHERE
            	p.post_status NOT LIKE '%cancelled%' AND
                to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            ORDER BY
                oi.order_id desc;
            SQL;

    return $wpdb->get_results( $sql, OBJECT );

}


function query_orders_full(){
    // return '<br>Test for getting orders. This text is coming from the query_orders function!';

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }

    global $wpdb;

	$sql = <<<SQL
            SELECT
                p.ID Nr, 
                DATE_FORMAT(p.post_date, '%d.%m.%Y' ) Datum,
                CONCAT(oc.first_name, ' ', oc.last_name) Naam,
                os.customer_id Lid, 
                oi.order_item_name Product, 
                os.num_items_sold Stk,
                CONCAT(regexp_substr(os.total_sales, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', os.total_sales) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(os.total_sales , '[.].+' ) , '0'),3)
                        END
                    )
                Euro,
                p.post_excerpt Notities, 
                SUBSTR( p.post_status, 4)  Status, 
                oi.order_item_id Orders
            FROM
            	{$wpdb->prefix}posts p
                INNER JOIN	{$wpdb->prefix}wc_order_stats os ON p.ID = os.order_id
                INNER JOIN	{$wpdb->prefix}woocommerce_order_items  oi ON p.ID = oi.order_id
                INNER JOIN	{$wpdb->prefix}wc_customer_lookup oc ON os.customer_id = oc.customer_id
            ORDER BY
                oi.order_id desc;
            SQL;

    return $wpdb->get_results( $sql, OBJECT );

}