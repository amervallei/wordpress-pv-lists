<?php

function convert_to_csv($array_of_objects, $output_file_name, $delimiter){
    
    // Set path to download folder location from root
    $output_file_name = 'wp-content/plugins/pv-lists/downloads/' . $output_file_name;
    
    // Open a file to write to
    $fp = fopen($output_file_name, 'wb');

    $i = 0;

    // Loop the array of objects
    foreach( $array_of_objects as $obj ){

        // Transform the current object to an array
    $fields = array();

    foreach ($obj as $k => $v)
    {
        $fields[ $k ] = $v;
    }

    if( $i === 0 )
    {
        fputcsv($fp, array_keys($fields) ); // First write the headers
    }

    fputcsv($fp, $fields); // Then write the fields

    $i++;
    }

    fclose($fp);

    echo '<div class="wp-block-file">
            <a href="' . home_url() . '/' . $output_file_name . '">Output as CSV file </a>
            <a href="' . home_url() . '/' . $output_file_name . '" class="wp-block-file__button" download>Download</a>
        </div>';

}