<?php

function convert_to_csv($array_of_objects, $output_file_name, $delimiter){
    
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
        <a href="http://localhost/amervallei/report.csv">Output as CSV file </a><a href="http://localhost/amervallei/report.csv" class="wp-block-file__button" download>Download</a></div>';

}