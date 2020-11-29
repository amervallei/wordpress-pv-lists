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
                oc.user_id Lid, 
                CONCAT(oi.order_item_name,IFNULL(MAX(case when im.meta_key = 'selectie-aangeven' then CONCAT(': ',im.meta_value) END),'')) Product, 
                MAX(case when im.meta_key = '_qty' then im.meta_value END) Stk,
                MAX(case when im.meta_key = '_line_total' then CONCAT(regexp_substr(im.meta_value, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', im.meta_value) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(im.meta_value , '[.].+' ) , '0'),3)
                        END
                    ) END) 
                Euro
            FROM
            	{$wpdb->prefix}posts p
                INNER JOIN	{$wpdb->prefix}wc_order_stats os ON p.ID = os.order_id
                INNER JOIN	{$wpdb->prefix}woocommerce_order_items  oi ON p.ID = oi.order_id
                INNER JOIN	{$wpdb->prefix}wc_customer_lookup oc ON os.customer_id = oc.customer_id
                INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta im ON oi.order_item_id = im.order_item_id
            WHERE
            	p.post_status NOT LIKE '%cancelled%' AND
                to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            GROUP BY 
            	im.order_item_id
            ORDER BY
                oi.order_id desc
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
                oc.user_id Lid, 
                CONCAT(oi.order_item_name,IFNULL(MAX(case when im.meta_key = 'selectie-aangeven' then CONCAT(': ',im.meta_value) END),'')) Product, 
                MAX(case when im.meta_key = '_qty' then im.meta_value END) Stk,
                MAX(case when im.meta_key = '_line_total' then CONCAT(regexp_substr(im.meta_value, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', im.meta_value) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(im.meta_value , '[.].+' ) , '0'),3)
                        END
                    ) END) 
                Euro,
                p.post_excerpt Notities, 
                SUBSTR( p.post_status, 4)  Status, 
                oi.order_item_id Orders
                FROM
            	{$wpdb->prefix}posts p
                INNER JOIN	{$wpdb->prefix}wc_order_stats os ON p.ID = os.order_id
                INNER JOIN	{$wpdb->prefix}woocommerce_order_items  oi ON p.ID = oi.order_id
                INNER JOIN	{$wpdb->prefix}wc_customer_lookup oc ON os.customer_id = oc.customer_id
                INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta im ON oi.order_item_id = im.order_item_id
            WHERE
            	p.post_status NOT LIKE '%cancelled%' AND
                to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            GROUP BY 
            	im.order_item_id
            ORDER BY
                oi.order_id desc
            SQL;

    return $wpdb->get_results( $sql, OBJECT );

}