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
            max(case when oim.meta_key = '_line_total' then 
                    CONCAT(regexp_substr(oim.meta_value, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', oim.meta_value) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(oim.meta_value , '[.].+' ) , '0'),3)
                        END
                    )
                end
            ) Euro
            FROM
            {$wpdb->prefix}woocommerce_order_itemmeta oim
            JOIN {$wpdb->prefix}woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
            JOIN {$wpdb->prefix}posts p ON oi.order_id = p.ID
            JOIN {$wpdb->prefix}postmeta pm ON oi.order_id = pm.post_id
            JOIN {$wpdb->prefix}users u ON pm.meta_value = u.ID
            WHERE
            pm.meta_key = '_customer_user'
            AND to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            GROUP BY
            oim.order_item_id
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
            oi.order_id Nr,
            DATE_FORMAT(p.post_date, '%d.%m.%Y' ) Datum,
            u.display_name Naam,
            u.ID Lid,
            oi.order_item_name Product,
            max(case when oim.meta_key = '_qty' then oim.meta_value end) Stk,
            max(case when oim.meta_key = '_line_total' then 
                    CONCAT(regexp_substr(oim.meta_value, '[0-9]+') , 
                        CASE
                        WHEN LOCATE('.', oim.meta_value) = 0 THEN '.00'
                        ELSE LEFT(CONCAT(REGEXP_substr(oim.meta_value , '[.].+' ) , '0'),3)
                        END
                    )
                end
            ) Euro
            FROM
            {$wpdb->prefix}woocommerce_order_itemmeta oim
            JOIN {$wpdb->prefix}woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
            JOIN {$wpdb->prefix}posts p ON oi.order_id = p.ID
            JOIN {$wpdb->prefix}postmeta pm ON oi.order_id = pm.post_id
            JOIN {$wpdb->prefix}users u ON pm.meta_value = u.ID
            WHERE
            pm.meta_key = '_customer_user'
            -- AND to_days(current_timestamp()) - to_days(`p`.`post_date`) < 120
            GROUP BY
            oim.order_item_id
            ORDER BY
            oi.order_id desc;
            SQL;

    return $wpdb->get_results( $sql, OBJECT );

}