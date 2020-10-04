<?php

function query_members(){
    // return '<br>Test for getting orders. This text is coming from the query_orders function!';

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }

    global $wpdb;

    $sql = <<<SQL
                SELECT	*
                FROM		(
                SELECT	u.ID Lid,
                    u.display_name Naam,
                    u.user_email E_mail,
                    -- max(case when m.meta_key = 'first_name' then m.meta_value end) Voornaam,
                    -- max(case when m.meta_key = 'last_name' then m.meta_value end) Achternaam,
                    max(case when m.meta_key = 'billing_address_1' then m.meta_value end) Adres,
                    max(case when m.meta_key = 'billing_postcode' then m.meta_value end) Postcode,
                    max(case when m.meta_key = 'billing_city' then m.meta_value end) Stad,
                    max(case when m.meta_key = 'billing_phone' then m.meta_value end) Phone,
                    max(case when m.meta_key = 'mobile_number' then m.meta_value end) Mobile,
                    -- max(case when m.meta_key = 'billing_email' then m.meta_value end) Email,
                    -- max(case when m.meta_key = 'gilde_status' then m.meta_value end) Gilde_Status,
                    max(case when m.meta_key = 'account_status' then m.meta_value end) Status,
                    REGEXP_SUBSTR(max(case when m.meta_key = '{$wpdb->prefix}capabilities' then m.meta_value END),'([a-z\s]{5,})' ) Rechten
                FROM
                    {$wpdb->prefix}users u
                    INNER JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id
                GROUP BY
                    u.ID, u.display_name, u.user_email
                ) a
                WHERE		a.Status != 'inactive'
            SQL;

    return $wpdb->get_results( $sql, OBJECT );


}


function query_members_full(){
    // return '<br>Test for getting orders. This text is coming from the query_orders function!';

    // Test if user is logged in
    if ( !is_user_logged_in() ){
        return 'You must be logged in to view this content.';
    }

    global $wpdb;

    $sql = <<<SQL
                SELECT	*
                FROM		(
                SELECT	u.ID Lid,
                    u.display_name Naam,
                    u.user_email E_mail,
                    max(case when m.meta_key = 'first_name' then m.meta_value end) Voornaam,
                    max(case when m.meta_key = 'last_name' then m.meta_value end) Achternaam,
                    max(case when m.meta_key = 'billing_address_1' then m.meta_value end) Adres,
                    max(case when m.meta_key = 'billing_postcode' then m.meta_value end) Postcode,
                    max(case when m.meta_key = 'billing_city' then m.meta_value end) Stad,
                    max(case when m.meta_key = 'billing_phone' then m.meta_value end) Phone,
                    max(case when m.meta_key = 'mobile_number' then m.meta_value end) Mobile,
                    max(case when m.meta_key = 'billing_email' then m.meta_value end) Email,
                    max(case when m.meta_key = 'gilde_status' then m.meta_value end) Gilde_Status,
                    max(case when m.meta_key = 'account_status' then m.meta_value end) Status,
                    REGEXP_SUBSTR(max(case when m.meta_key = '{$wpdb->prefix}capabilities' then m.meta_value END),'([a-z\s]{5,})' ) Rechten
                FROM
                    {$wpdb->prefix}users u
                    INNER JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id
                GROUP BY
                    u.ID, u.display_name, u.user_email
                ) a
                WHERE		a.Status != 'inactive'
            SQL;

    return $wpdb->get_results( $sql, OBJECT );


}
